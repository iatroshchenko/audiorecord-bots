<template>
  <div
    v-show="isShown"
    class="fixed z-10 inset-0 overflow-y-auto"
  >
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <!-- This element is to trick the browser into centering the modal contents. -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
      <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all lg:max-w-5xl sm:align-middle sm:max-w-xl md:max-w-2xl sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
              Bulk Record Upload
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
                Fill this form to Upload your Record
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
          <div class="-mx-3 mb-6">

            <div class="px-3 mb-10">
              <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                .ogg Files
              </label>

              <file-pond
                name="file"
                ref="pond"
                label-idle="Upload the .ogg record file"
                accepted-file-types="audio/ogg"
                :allow-multiple="true"
                :server="{
                  url: $backendRoute('internal.records.upload'),
                  process: {
                    headers: {
                      'X-CSRF-TOKEN': $page.props.csrfToken,
                      'accept': 'application/json'
                    },
                    onload: handleFilePondAdd,
                    onerror: handleFilePondError,
                  }
                }"
                @init="handleFilePondInit"
                @removefile="handleFilePondRemove"
              />
            </div>

            <!-- Bulk controls -->
            <div v-if="files.length" class="p-3 mb-10 border-solid border-2 border-indigo-200">
              <div class="px-3 mb-6 md:mb-0">

                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name-divider">
                  Bulk Name Separator Cleanup
                </label>
                <input type="text" id="name-divider" v-model="bulkRecordNameTargetSeparator">
                <p class="mb-1 text-red text-xs italic">Change all dashes (or selected divider) to spaces except first divider (would be replaced with " - ")</p>
                <p class="mb-3 text-red text-xs italic">Type separator symbol we should look for and replace to spaces</p>

                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="name-delete-text">
                  Bulk Name Divider Cleanup
                </label>
                <input type="text" id="name-delete-text" v-model="bulkRecordNameTextToDelete">
                <p class="mb-3 text-red text-xs italic">Type text we should look for and get rid of</p>

                <div class="mb-3">
                  <simple-button
                    hover-bg-color="indigo-700"
                    bg-color="indigo-600"
                    class="ml-1"
                    @clicked="bulkRecordNameTransform"
                  >
                    Transform
                  </simple-button>
                </div>
              </div>

              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="bulk-default-search-available">
                  Bulk Default Search available
                </label>
                <input v-model="bulkDefaultSearchAvailable" type="checkbox" id="bulk-default-search-available">
                <p class="text-red text-xs italic">Determine if record is certain record is available in default search - for all records</p>
              </div>

              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                  Bulk Tags
                </label>

                <div>
                  <multiselect
                    v-model="bulkTags"
                    tag-placeholder="Add this as new tag"
                    placeholder="Search or add a tag"
                    label="name"
                    track-by="uuid"
                    :options="tags"
                    :multiple="true"
                    :taggable="true"
                    @tag="(tag) => { addTag(tag, null, bulkTags) }"
                  ></multiselect>
                  <pre class="language-json"><code>{{ bulkTags }}</code></pre>
                </div>

                <p class="text-red text-xs italic">A certain record will be available for search by this pattern: tag#search (for all records) </p>
              </div>
            </div>

            <!-- Single record -->
            <div class="p-3 mb-10 border-solid border-2 border-gray-200"
              v-for="(record, i) in files"
              :key="i"
            >
              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="`record-${i}-path`">
                  Record Path
                </label>
                <input disabled class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" type="text"
                  :id="`record-${i}-path`"
                  :value="record.path"
                >
                <p class="text-red text-xs italic">Temporary path for record.</p>

                <div v-if="errors[i] && errors[i].path.length" class="errors">
                  <p
                    class="text-red-600 text-xs italic"
                    :key="key"
                    v-for="(error, key) in errors[i].path"
                  >
                    {{ error }}
                  </p>
                </div>
              </div>

              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="`record-${i}-name`">
                  Record Name
                </label>
                <input v-model="record.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" :id="`record-${i}-name`" type="text" placeholder="This is record name">
                <p class="text-red text-xs italic">The record will be available for search by this name.</p>

                <div v-if="errors[i] && errors[i].name.length" class="errors">
                  <p
                    class="text-red-600 text-xs italic"
                    :key="key"
                    v-for="(error, key) in errors[i].name"
                  >
                    {{ error }}
                  </p>
                </div>
              </div>

              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" :for="`record-${i}-default-search`">
                  Default Search available
                </label>
                <input v-model="record.default_search_available" type="checkbox" :id="`record-${i}-default-search`">
                <p class="text-red text-xs italic">Determine if record is available in default search</p>

                <div v-if="errors[i] && errors[i].default_search_available.length" class="errors">
                  <p
                    class="text-red-600 text-xs italic"
                    :key="key"
                    v-for="(error, key) in errors[i].default_search_available"
                  >
                    {{ error }}
                  </p>
                </div>

              </div>

              <div class="px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                  Tags
                </label>

                <div>
                  <multiselect
                    v-model="record.tags"
                    tag-placeholder="Add this as new tag"
                    placeholder="Search or add a tag"
                    label="name"
                    track-by="uuid"
                    :options="tags"
                    :multiple="true"
                    :taggable="true"
                    @tag="(tag) => { addTag(tag, record) }"
                  ></multiselect>
                  <pre class="language-json"><code>{{ record.tags }}</code></pre>
                </div>

                <p class="text-red text-xs italic">The record will be available for search by this pattern: tag#search </p>

                <div v-if="errors[i] && errors[i].tags.length" class="errors">
                  <p
                    class="text-red-600 text-xs italic"
                    :key="key"
                    v-for="(error, key) in errors[i].tags"
                  >
                    {{ error }}
                  </p>
                </div>
              </div>


            </div>

          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <simple-button
            hover-bg-color="indigo-700"
            bg-color="indigo-600"
            class="ml-1"
            :loading="bulkRecordCreating"
            @clicked="onUploadRecordClick"
          >
            Upload
          </simple-button>
          <simple-button
            @clicked="hide"
            hover-bg-color="gray-100"
            bg-color="gray-200"
            text-color="gray-700"
            hover-text-color="gray-600"
          >
            Cancel
          </simple-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import SimpleButton from "../../ui/SimpleButton";
  import Multiselect from 'vue-multiselect';

  import vueFilePond from "vue-filepond";
  import "filepond/dist/filepond.min.css";

  import axios from 'axios';

  // Create component
  const FilePond = vueFilePond();

  export default {
    name: "BulkCreateRecordModal",
    components: {
      SimpleButton,
      Multiselect,
      FilePond
    },
    data() {
      return {
        isShown: false,

        files: [],
        errors: [],

        /* Tags */
        tags: [],
        bulkTags: [],
        bulkDefaultSearchAvailable: true,

        /* FilePond */
        recordFile: [],

        /* Bulk Record Creating */
        bulkRecordCreating: false,
        bulkRecordNameTargetSeparator: '-',
        bulkRecordNameTextToDelete: '.ogg'
      }
    },
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    watch: {
      show(val) {
        this.isShown = !!val;
      },
      bulkDefaultSearchAvailable(val) {
        this.files.forEach(file => {
          file.default_search_available = val ? 1 : 0;
        })
      },
      bulkTags(val) {
        this.files.forEach(file => {
          file.tags = [...val]
        })
      }
    },
    methods: {
      hide() {
        this.clearErrors();
        this.clearForm();
        this.$emit('hide');
      },
      done() {
        this.clearErrors();
        this.clearForm();
        this.$emit('done');
      },
      addTag (newTag, record = null, directObject = null) {
        this.uploadTagFromInput(newTag)
          .then(res => {
            const tag = {...res.data.data};
            this
              .loadTags()
              .then(res => {
                if (record) record.tags.push(tag);
                if (directObject) directObject.push(tag);
              });
          })
          .catch(err => {
            console.log(err);
          })
      },

      /* CleanUp */
      clearErrors() {
        this.errors = [];

        this.files.forEach(file => {
          this.errors.push({
            name: [],
            path: [],
            default_search_available: [],
            tags: []
          });
        });
      },
      clearForm() {
        this.files = [];
        this.$refs.pond.removeFiles();
      },

      /* FilePond */
      handleFilePondInit () {
        console.log("FilePond has initialized");
        console.log(this.$refs.pond);
        this.$refs.pond.getFiles()
      },
      handleFilePondAdd (res) {
        const response = JSON.parse(res);

        setTimeout(() => {
          this.syncFiles();
        }, 100)
        return response.path;
      },
      handleFilePondError (err) {
        setTimeout(() => {
          this.syncFiles();
        }, 100);
        return err;
      },
      handleFilePondRemove (error, file) {
        const index = this.files.findIndex(i => i.id === file.id);
        this.files = this.files.filter(i => i.id !== file.id);
        this.errors = this.errors.filter((item, i) => i !== index);
      },

      /* Multiple file upload */
      syncFiles() {
        const filePondFiles = this.$refs.pond.getFiles();

        filePondFiles.forEach(fpFile => {
          const existingFile = this.files.find(file => file.id === fpFile.id);

          if (!existingFile) {
            this.files.push({
              id: fpFile.id,
              name: fpFile.file.name,
              path: fpFile.serverId,
              default_search_available: true,
              tags: []
            })
          } else {
            if (!existingFile.path && fpFile.serverId) {
              existingFile.path = fpFile.serverId;
            }
          }
        });
      },
      /* Multiple file upload */

      /* Bulk Record Create */
      bulkRecordNameTransform() {
        this.files.forEach(file => {
          let name = file.name.split(this.bulkRecordNameTextToDelete).join('');

          const firstAppearanceIndex = file.name.indexOf(this.bulkRecordNameTargetSeparator);
          if (firstAppearanceIndex) {
            name = name.substring(0, firstAppearanceIndex) + '#####' + name.substring(firstAppearanceIndex + 1);
            name = name.split(this.bulkRecordNameTargetSeparator).join(' ');
            name = name.split('#####').join(' - ');
          }

          file.name = name;
        })
      },

      onUploadRecordClick() {
        if (this.bulkRecordCreating) return;
        this.bulkRecordCreating = true;
        this.clearErrors();

        this.bulkCreateRecords()
          .then(res => {
            this.done();
          })
          .catch(err => {
            const errors = err.response.data.errors;

            Object.keys(this.errors).forEach(key => {

              const certainError = this.errors[key];
              Object.keys(certainError).forEach(field => {
                // sample error key: records.0.path

                if (errors[`records.${key}.${field}`]) {
                  errors[`records.${key}.${field}`].forEach(e => {
                    certainError[field].push(e);
                  })
                }
              })

            });
          })
          .finally(() => {
            this.bulkRecordCreating = false;
          });
      },
      bulkCreateRecords() {
        return axios.post('/internal/records-bulk', {
          records: this.files.map(record => ({
            ...record,
            tags: record.tags.map(i=>i.uuid),
            default_search_available: record.default_search_available ? 1 : 0
          }))
        })
      },

      /* Upload */
      uploadTagFromInput(name) {
        return axios.post('/internal/tags', {
          name
        });
      },

      /* Load */
      loadTags() {
        return axios.get('/internal/tags')
          .then(res => {
            this.tags = [...res.data.data];
          })
          .catch(err => {
            console.log(err);
          })
      }
    },
    mounted() {
      this.loadTags();
    }
  }
</script>

<style scoped>

</style>
