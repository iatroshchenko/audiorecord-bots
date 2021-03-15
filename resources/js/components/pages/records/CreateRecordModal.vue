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
      <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
              Add Record
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
            <div class="px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="record-name">
                Record Name
              </label>
              <input v-model="record.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="record-name" type="text" placeholder="This is record name">
              <p class="text-red text-xs italic">The record will be available for search by this name.</p>

              <div v-if="errors.name.length" class="errors">
                <p
                  class="text-red-600 text-xs italic"
                  :key="key"
                  v-for="(error, key) in errors.name"
                >
                  {{ error }}
                </p>
              </div>
            </div>

            <div class="px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                .ogg File
              </label>

              <file-pond
                name="file"
                ref="pond"
                label-idle="Upload the .ogg record file"
                accepted-file-types="audio/ogg"
                :allow-multiple="false"
                :server="{
                  url: $backendRoute('internal.records.upload'),
                  process: {
                    headers: {
                      'X-CSRF-TOKEN': $page.props.csrfToken,
                      'accept': 'application/json'
                    },
                    onload: handleFilePondAdd
                  }
                }"
                :files="recordFile"
                @init="handleFilePondInit"
              />

              <div v-if="errors.path.length" class="errors">
                <p
                  class="text-red-600 text-xs italic"
                  :key="key"
                  v-for="(error, key) in errors.path"
                >
                  {{ error }}
                </p>
              </div>
            </div>

            <div class="px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="record-default-search">
                Default Search available
              </label>
              <input v-model="record.default_search_available" type="checkbox" id="record-default-search" placeholder="This is record name">
              <p class="text-red text-xs italic">Determine if record is available in default search</p>

              <div v-if="errors.default_search_available.length" class="errors">
                <p
                  class="text-red-600 text-xs italic"
                  :key="key"
                  v-for="(error, key) in errors.default_search_available"
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
                  @tag="addTag"
                ></multiselect>
                <pre class="language-json"><code>{{ record.tags }}</code></pre>
              </div>

              <p class="text-red text-xs italic">The record will be available for search by this tags: #tag@search </p>

              <div v-if="errors.tags.length" class="errors">
                <p
                  class="text-red-600 text-xs italic"
                  :key="key"
                  v-for="(error, key) in errors.tags"
                >
                  {{ error }}
                </p>
              </div>

            </div>

          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <simple-button
            hover-bg-color="indigo-700"
            bg-color="indigo-600"
            class="ml-1"
            :loading="creatingRecord"
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
    name: "CreateRecordModal",
    components: {
      SimpleButton,
      Multiselect,
      FilePond
    },
    data() {
      return {
        isShown: false,
        record: {
          name: '',
          path: '',
          default_search_available: true,
          tags: []
        },

        errors: {
          name: [],
          path: [],
          default_search_available: [],
          tags: []
        },

        /* Tags */
        tags: [],

        /* FilePond */
        recordFile: [],

        /* Creating Record */
        creatingRecord: false
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
      addTag (newTag) {
        this.uploadTagFromInput(newTag)
          .then(res => {
            const tag = {...res.data.data};
            this
              .loadTags()
              .then(res => {
                this.record.tags.push(tag);
              });
          })
          .catch(err => {
            console.log(err);
          })
      },

      /* CleanUp */
      clearErrors() {
        this.errors = {
          name: [],
          path: [],
          default_search_available: [],
          tags: []
        };
      },
      clearForm() {
        this.record = {
          name: '',
          path: '',
          default_search_available: true,
          tags: []
        }

        this.$refs.pond.removeFile();
      },

      /* FilePond */
      handleFilePondInit () {
        console.log("FilePond has initialized");
        console.log(this.$refs.pond);
      },
      handleFilePondAdd (res) {
        const response = JSON.parse(res);
        this.record.path = response.path;
      },

      /* Create Record */
      onUploadRecordClick() {
        if (this.creatingRecord) return;
        this.creatingRecord = true;
        this.clearErrors();

        this.createRecord()
          .then(res => {
            this.done();
          })
          .catch(err => {
            const errors = err.response.data.errors;

            Object.keys(this.errors).forEach(key => {
              const e = errors[key];
              if (e && e.length) {
                e.forEach(error => {
                  this.errors[key].push(error);
                })
              }
            })
          })
          .finally(() => {
            this.creatingRecord = false;
          });
      },
      createRecord() {
        return axios.post('/internal/records', {
          ...this.record,
          tags: this.record.tags.map(i=>i.uuid),
          default_search_available: this.record.default_search_available ? 1 : 0
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
