<template>
  <div class="my-navbar relative bg-white">
    <DesktopMenu></DesktopMenu>
    <MobileMenu></MobileMenu>
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
    }
  }
</script>

<style scoped>

</style>
