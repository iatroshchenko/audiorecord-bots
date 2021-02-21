<template>
  <div
    v-if="withDropdown"
    class="relative"
  >
    <a
      @mouseover="showDropdown"
      @mouseleave="hideDropdown"
      type="button"
      class="group bg-white rounded-md text-gray-500 inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      <slot name="content"></slot>
      <dropdown-icon></dropdown-icon>
    </a>
    <div
      v-show="dropdownVisible"
      @mouseover="showDropdown"
      @mouseleave="hideDropdown"
    >
      <slot name="dropdown"></slot>
    </div>
  </div>

  <a
    :href="link"
    class="text-base font-medium text-gray-500 hover:text-gray-900"
    v-else
  >
    <slot name="content"></slot>
  </a>
</template>

<script>
  import DropdownIcon from "./DropdownIcon";

  export default {
    name: "DesktopMenuItem",
    props: {
      link: String,
      withDropdown: Boolean
    },
    components: {
      DropdownIcon
    },
    data() {
      return {
        dropdownVisible: false,
        dropdownHideTimeout: null
      }
    },
    methods: {
      showDropdown() {
        if (this.dropdownHideTimeout) {
          clearTimeout(this.dropdownHideTimeout);
        }

        if (!this.dropdownVisible) {
          this.dropdownVisible = true;
        }
      },
      hideDropdown() {
        if (this.dropdownVisible) {
          this.dropdownHideTimeout = setTimeout(() => {
            this.dropdownVisible = false;
          }, 100);
        }
      }
    }
  }
</script>

<style scoped>

</style>
