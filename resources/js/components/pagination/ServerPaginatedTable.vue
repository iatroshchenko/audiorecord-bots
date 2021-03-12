<template>
  <div
    class="min-w-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
    <div class="w-full lg:w-5/6">
      <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-max w-full table-auto">
          <thead>
          <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th
              v-for="(header, key) in headers"
              :key="key"
              :class="header.class"
              @click="sort(header.value)"
              style="cursor:pointer;"
            >
              <span class="header-text">
                {{ header.text }}
              </span>
              <span class="header-icon">
                <i v-if="sortBy === header.value" class='bx bx-sort-down' ></i>
                <i v-else-if="sortBy === '-' + header.value" class='bx bx-sort-up' ></i>
                <i v-else class='bx bx-sort-alt-2' ></i>
              </span>
            </th>
          </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">

          <!-- Render Table -->
          <tr
            v-for="(item, i) in items"
            class="border-b border-gray-200 hover:bg-gray-100"
            :class="i % 2 ? 'bg-gray-50' : ''"
          >
            <td
              v-for="(header, key) in headers"
              :key="key"
              :class="header.class"
            >
              <slot :name="header.value" :item="item">
                {{ item[header.value] }}
              </slot>
            </td>
          </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "ServerPaginatedTable",
    props: {
      headers: {
        type: Array,
        required: true
      },
      items: {
        type: Array,
        required: true
      },
      sortBy: {
        type: String
      }
    },
    methods: {
      sort(field) {
        let sortBy = this.sortBy;

        // 1. - if there's no current sort - just do -field and return.
        if (!sortBy) {
          this.$emit('sort', field);
          return;
        }

        /*
         2. If not returned until here, there is some current sort - so we check sortBy.includes(field)
         "Not Includes" would mean there's a sort by another field
        */
        if (!sortBy.includes(field)) {
          this.$emit('sort', field);
          return;
        }

        // 3. If exact match - we just do reverse sort
        if (sortBy === field) {
          this.$emit('sort', '-' + field);
          return;
        }

        // 4. else - remove sort by that field
        this.$emit('sort', null);
      }
    }
  }
</script>

<style scoped>

</style>
