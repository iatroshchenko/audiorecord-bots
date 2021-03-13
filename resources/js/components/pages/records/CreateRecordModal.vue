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
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <simple-button
            hover-bg-color="indigo-700"
            bg-color="indigo-600"
            class="ml-1"
          >
            Upload
          </simple-button>
          <simple-button
            @clicked="hide()"
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

  export default {
    name: "CreateRecordModal",
    components: {
      SimpleButton
    },
    data() {
      return {
        isShown: false
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
        this.$emit('hide');
      }
    }
  }
</script>

<style scoped>

</style>
