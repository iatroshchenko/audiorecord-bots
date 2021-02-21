<template>
  <a @click="$emit('clicked')"
     :class="`
        simple-button whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border
        border-transparent rounded-md shadow-sm text-base font-medium text-white
        ${bgColor ? 'bg-' + bgColor : ''}
        ${hoverBgColor ? 'hover:bg-' + hoverBgColor : ''}
     `"
  >
    <slot/>
  </a>
</template>

<script>
  export default {
    name: "SimpleButton",
    props: {
      hoverBgColor: String,
      bgColor: String
    }
  }
</script>

<style scoped>
  .simple-button {
    cursor: pointer;
  }

  .simple-button:hover {
    text-decoration: none;
  }
</style>
