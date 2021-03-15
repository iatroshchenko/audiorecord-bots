<template>
  <div
    class="tag py-2 px-4 rounded-full text-white text-center font-extrabold mr-1 mb-1"
    :class="color ? 'bg-' + color : ''"
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
  }
</style>
