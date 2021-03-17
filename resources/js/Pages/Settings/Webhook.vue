<template>
  <!-- Webhook details -->
  <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
    <section aria-labelledby="webhook_details_header">
      <form>
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="bg-white py-6 px-4 sm:p-6">
            <div>
              <h2 id="webhook_details_header" class="text-lg leading-6 font-medium text-gray-900">Webhook details</h2>
              <p class="mt-1 text-sm text-gray-500">
                Here You can update your webhook settings for the bot
              </p>
            </div>

            <div class="mt-6 grid grid-cols-4 gap-6">
              <div class="col-span-4">
                <label  class="block text-sm font-medium text-gray-700">
                  WebHook Info
                </label>

                <indigo-loader v-if="loading"></indigo-loader>
                <pre v-else><code>{{ webHookInfo }}</code></pre>
              </div>

              <div class="col-span-4">
                <label for="webhook_url" class="block text-sm font-medium text-gray-700">Webhook URL</label>
                <input v-model="url" type="text" id="webhook_url" autocomplete="cc-given-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                <p v-for="(e,key) in errors.url" class="mt-1 text-sm text-red-500" :key="key">
                  {{ e }}
                </p>
              </div>

<!--              <div class="col-span-4 sm:col-span-1">-->
<!--                <label for="expiration_date" class="block text-sm font-medium text-gray-700">Expration date</label>-->
<!--                <input type="text" name="expiration_date" id="expiration_date" autocomplete="cc-exp" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" placeholder="MM / YY">-->
<!--              </div>-->

<!--              <div class="col-span-4 sm:col-span-1">-->
<!--                <label for="security_code" class="flex items-center text-sm font-medium text-gray-700">-->
<!--                  <span>Security code</span>-->
<!--                  <svg class="ml-1 flex-shrink-0 h-5 w-5 text-gray-300" x-description="Heroicon name: solid/question-mark-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">-->
<!--                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>-->
<!--                  </svg>-->
<!--                </label>-->
<!--                <input type="text" name="security_code" id="security_code" autocomplete="cc-csc" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">-->
<!--              </div>-->

<!--              <div class="col-span-4 sm:col-span-2">-->
<!--                <label for="country" class="block text-sm font-medium text-gray-700">Country / Region</label>-->
<!--                <select id="country" name="country" autocomplete="country" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">-->
<!--                  <option>United States</option>-->
<!--                  <option>Canada</option>-->
<!--                  <option>Mexico</option>-->
<!--                </select>-->
<!--              </div>-->
            </div>
          </div>

          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a
              @click="setWebhook"
              class="cursor-pointer bg-gray-800 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
            >
              Save
            </a>
          </div>
        </div>
      </form>

      <mounted @mounted="loadData"></mounted>
    </section>
  </div>
</template>

<script>
  import AppLayout from "../../layouts/AppLayout";
  import SettingsLayout from "../../layouts/SettingsLayout";
  import axios from 'axios';
  import Mounted from "../../components/service/Mounted";
  import IndigoLoader from "../../components/ui/ColorLoaders/IndigoLoader";

  export default {
    name: "Webhook",
    components: {
      IndigoLoader,
      Mounted
    },
    layout: [AppLayout, SettingsLayout],

    data() {
      return {
        webHookInfo: '',
        loading: false,

        url: '',
        errors: {
          url: []
        }
      }
    },
    methods: {
      clearErrors() {
        this.errors = {
          url: []
        }
      },

      setWebhook() {
        this.clearErrors();

        axios.post(this.$backendRoute('webhook.set'), {
          url: this.url
        })
          .then(res => {
            this.url = '';
            this.getWebhookInfo();
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
      },
      getWebhookInfo() {
        this.loading = true;

        axios.get(this.$backendRoute('webhook.info'))
          .then(res => {
            this.webHookInfo = {...res.data};
          })
          .catch(err => {
            console.log(err);
          })
          .finally(() => {
            this.loading = false;
          })
      },
      loadData() {
        this.getWebhookInfo();
      }
    }
  }
</script>
