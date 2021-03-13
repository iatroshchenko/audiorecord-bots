<template>
  <div class="my-navbar relative bg-white">
    <desktop-menu
      @open-mobile-menu="onMobileMenuOpen"
    ></desktop-menu>
    <mobile-menu
      :show="mobileMenuShown"
      @hide="onMobileMenuHide"
    ></mobile-menu>
  </div>
</template>

<script>
  import DesktopMenu from "./DesktopMenu";
  import MobileMenu from "./MobileMenu";

  export default {
    name: "Navbar",
    components: {
      DesktopMenu,
      MobileMenu
    },
    data() {
      return {
        mobileMenuShown: false
      }
    },
    methods: {
      toggleMobileMenu(val) {
        this.mobileMenuShown = !!val;
      },
      onMobileMenuHide() {
        this.toggleMobileMenu(false);
      },
      onMobileMenuOpen() {
        this.toggleMobileMenu(true);
      }
    }
  }
</script>

<style scoped>

</style>
