<template>
  <div>
    <create-record-modal
      :show="createRecordModalShown"
      @hide="onCreateRecordModalHide"
      @done="onCreateRecordModalDone"
    ></create-record-modal>

    <div class="rounded-t-xl overflow-hidden bg-gradient-to-r from-emerald-50 to-teal-100 p-10">
      <div class="text-right">
        <simple-button
          hover-bg-color="indigo-700"
          bg-color="indigo-600"
          @clicked="onAddRecordButtonClick"
        >
          Add Record <i class='ml-1 icon bx bx-user-voice'></i>
        </simple-button>
      </div>
    </div>

    <server-paginated-table
      :headers="headers"
      :items="paginated.data.data"
      :sort-by="sortBy"
      :loading="loading"
      @sort="onSort"
    >
      <template v-slot:default_search_available="{ item }">
        <div class="tags d-flex flex-wrap">
          <pill
            :color="item.default_search_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
          >{{ item.default_search_available ? 'yes' : 'no' }}</pill>
        </div>
      </template>
      <template v-slot:tags="{ item }">
        <div class="tags d-flex flex-wrap">
          <pill
            v-for="(t, key) in item.tags"
            :key="key"
            :color="t.color"
          >{{ t.name }}</pill>
        </div>
      </template>
      <template v-slot:actions="{ item }">
        <div class="flex item-center justify-center">
          <div
            class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
            @click="edit(item)"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </div>
          <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
          </div>
          <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </div>
        </div>
      </template>
    </server-paginated-table>
    <pagination-links
      :last-page="paginated.last_page"
      :current-page="paginated.current_page"
      @page-selected="onPageSelected"
    ></pagination-links>
  </div>
</template>

<script>
  import AppLayout from "../layouts/AppLayout";
  import ServerPaginatedTable from "../components/pagination/ServerPaginatedTable";
  import PaginationLinks from "../components/pagination/PaginationLinks";
  import SimpleButton from "../components/ui/SimpleButton";
  import Pill from "../components/ui/Pill";
  import CreateRecordModal from "../components/pages/records/CreateRecordModal";
  import { Inertia } from '@inertiajs/inertia'

  export default {
    name: "Records",
    layout: AppLayout,
    components: {
      ServerPaginatedTable,
      PaginationLinks,
      SimpleButton,
      CreateRecordModal,
      Pill
    },
    props: {
      paginated: {
        type: Object
      },
      sortBy: {
        type: String
      }
    },
    data() {
      return {
        /* Loading */
        loading: false,

        /* Add Record */
        createRecordModalShown: false,
        /* Add Record */

        headers: [
          {
            text: 'Name',
            value: 'name',
            class: 'py-3 px-6 text-left'
          },
          {
            text: 'General Search',
            value: 'default_search_available',
            class: 'py-3 px-6 text-left'
          },
          {
            text: 'Tags',
            value: 'tags',
            class: 'py-3 px-6 text-left',
            sortable: false
          },
          {
            text: 'Created At',
            value: 'created_at',
            class: 'py-3 px-6 text-left'
          },
          {
            text: 'Actions',
            value: 'actions',
            class: 'py-3 px-6 text-right',
            sortable: false
          }
        ],
        items: []
      }
    },
    methods: {
      edit(item) {
        alert(item.name);
      },

      /* Add Record */
      toggleCreateRecordModal(val) {
        this.createRecordModalShown = !!val;
      },
      onAddRecordButtonClick() {
        this.toggleCreateRecordModal(true);
      },
      onCreateRecordModalHide() {
        this.toggleCreateRecordModal(false);
      },
      onCreateRecordModalDone() {
        this.toggleCreateRecordModal(false);

        Inertia.visit(this.$backendRoute('pages.records'), {
          data: {
            page: 1,
            sort: null
          }
        });
      },
      /* Add Record */

      /* Pagination and Sorting */
      onPageSelected(page) {
        Inertia.visit(this.$backendRoute('pages.records'), {
          data: {
            page: page,
            sort: this.sortBy
          }
        })
      },
      onSort(field) {
        console.log(field);

        Inertia.visit(this.$backendRoute('pages.records'), {
          data: {
            page: this.paginated.current_page,
            sort: field
          }
        })
      }
    }
  }
</script>

<style scoped>
  .tags {
    max-width: 320px;
  }

  i.icon {
    font-size: 24px;
  }
</style>
