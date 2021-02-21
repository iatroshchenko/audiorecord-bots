<template>
  <div class="layout">
    <Navbar></Navbar>

    <!-- Content Here ? -->
    <slot/>
  </div>
</template>

<script>
  import Navbar from "../components/navbar/Navbar";

  export default {
    name: "Layout",
    components: {
      Navbar
    }
  }
</script>

<style scoped>

</style>
