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
      :items="items"
      :sort-by="sortBy"
      @sort="onSort"
    >
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
    <pagination-links></pagination-links>
  </div>
</template>

<script>
  import AppLayout from "../layouts/AppLayout";
  import ServerPaginatedTable from "../components/pagination/ServerPaginatedTable";
  import PaginationLinks from "../components/pagination/PaginationLinks";
  import SimpleButton from "../components/ui/SimpleButton";
  import CreateRecordModal from "../components/pages/records/CreateRecordModal";

  export default {
    name: "Records",
    layout: AppLayout,
    components: {
      ServerPaginatedTable,
      PaginationLinks,
      SimpleButton,
      CreateRecordModal
    },
    data() {
      return {
        /* Add Record */
        createRecordModalShown: false,
        /* Add Record */

        headers: [
          {
            text: 'Dessert (100g serving)',
            value: 'name',
            class: 'py-3 px-6 text-left'
          },
          { text: 'Calories', value: 'calories', class: 'py-3 px-6 text-left' },
          { text: 'Fat (g)', value: 'fat', class: 'py-3 px-6 text-left' },
          { text: 'Carbs (g)', value: 'carbs', class: 'py-3 px-6 text-center' },
          { text: 'Protein (g)', value: 'protein', class: 'py-3 px-6 text-center' },
          { text: 'Iron (%)', value: 'iron', class: 'py-3 px-6 text-center' },
          { text: 'Actions', value: 'actions', class: 'py-3 px-6 text-right' }
        ],
        items: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
            iron: '1%',
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            iron: '1%',
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0,
            iron: '7%',
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3,
            iron: '8%',
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9,
            iron: '16%',
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0,
            iron: '0%',
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0,
            iron: '2%',
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5,
            iron: '45%',
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9,
            iron: '22%',
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7,
            iron: '6%',
          }
        ],
        sortBy: null
      }
    },
    methods: {
      edit(item) {
        alert(item.name);
      },
      onSort(field) {
        this.sortBy = field;
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
      }
      /* Add Record */
    }
  }
</script>

<style scoped>
  i.icon {
    font-size: 24px;
  }
</style>
