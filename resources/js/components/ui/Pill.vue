<template>
  <div class="tag inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
     :class="color ? color : ''"
  >
    <slot/>
  </div>
</template>

<script>
  export default {
    name: "Pill",
    props: {
      color: {
        type: String
      }
    }
  }
</script>

<style scoped>
  .tag {
    font-size: 14px;
    margin-bottom: 5px;
    margin-right: 5px;
  }
</style>
