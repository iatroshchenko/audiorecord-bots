<template>
  <div class="flex flex-col items-center my-12">
    <div class="flex text-gray-700">
      <div class="h-12 w-12 mr-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer"
        @click="onPrevPageClick"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-chevron-left w-6 h-6">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </div>
      <div class="flex h-12 font-medium rounded-full bg-gray-200">
        <div
          v-for="(p, key) in pages"
          class="w-12 md:flex justify-center items-center hidden cursor-pointer leading-5 transition duration-150 ease-in rounded-full "
          :class="currentPage === p ? 'bg-indigo-600 text-white' : ''"
          :key="key"
          @click="onPageSelected(p)"
        >
          {{ p ? p : '...' }}
        </div>
      </div>
      <div class="h-12 w-12 ml-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer"
        @click="onNextPageClick"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-chevron-right w-6 h-6">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "PaginationLinks",
    props: {
      lastPage: {
        type: Number,
        required: true
      },
      currentPage: {
        type: Number,
        required: true
      }
    },
    data() {
      return {
        firstPage: 1,
        pages: []
      }
    },
    methods: {
      onPrevPageClick() {
        this.onPageSelected(this.currentPage - 1);
      },
      onNextPageClick() {
        this.onPageSelected(this.currentPage + 1);
      },
      onPageSelected(page) {
        if (!page || page === this.currentPage || page > this.lastPage) return;
        this.$emit('page-selected', page);
      },
      recalculatePages() {
        /*
        * [1,2,3,0,5,6,7,0,9,10,11] -
        * is 1 2 3 ... 5 6 7 ... 9 10 11
        *
        * */

        this.pages = [];

        if (this.lastPage <= 10) {
          for (let i = 1; i <= this.lastPage; i++) {
            this.pages.push(i);
          }

          return;
        }

        this.pages = [1, 2, 3];
        const currentPage = this.currentPage;
        const previousPage = currentPage - 1;
        const nextPage = currentPage + 1;

        const lastPage = this.lastPage;
        const beforeLastPage = this.lastPage - 1;
        const twiceBeforeLastPage = this.lastPage - 2;

        // 0 between 1,2,3 and currentPage
        if ((currentPage - 3) > 2) {
          // this means we are ahead from first 3 pages more than 2 steps, so we put 0
          this.pages.push(0);
          this.pages.push(previousPage);
          this.pages.push(currentPage);
          this.pages.push(nextPage);
        } else {
          // this means we still touch first 3 pages
          if (previousPage) {
            if (!this.pages.includes(previousPage)) this.pages.push(previousPage);
          }
          if (!this.pages.includes(currentPage)) this.pages.push(currentPage);
          if (!this.pages.includes(nextPage)) this.pages.push(nextPage);
        }

        // 0 between currentPage and 98,99,100
        if ((twiceBeforeLastPage - currentPage) > 2) {
          // this means we are behind last 3 pages more than 2 steps, so we put 0
          this.pages.push(0);
          this.pages.push(twiceBeforeLastPage);
          this.pages.push(beforeLastPage);
          this.pages.push(lastPage);
        } else {
          // this means we touch first 3 pages
          if (twiceBeforeLastPage) {
            if (!this.pages.includes(twiceBeforeLastPage)) this.pages.push(twiceBeforeLastPage);
          }
          if (beforeLastPage) {
            if (!this.pages.includes(beforeLastPage)) this.pages.push(beforeLastPage);
          }
          if (!this.pages.includes(lastPage)) this.pages.push(lastPage);
        }
      }
    },
    watch: {
      currentPage() {
        this.recalculatePages();
      }
    },
    mounted() {
      this.recalculatePages();
    }
  }
</script>

<style scoped>

</style>
