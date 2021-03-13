<template>
  <a @click="$emit('clicked')"
     :class="`
        simple-button whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border
        border-transparent rounded-md shadow-sm text-base font-medium
        ${bgColor ? 'bg-' + bgColor : ''}
        ${hoverBgColor ? 'hover:bg-' + hoverBgColor : ''}
        ${textColor ? 'text-' + textColor : 'text-white'}
        ${hoverTextColor ? 'hover:text-' + hoverTextColor : 'hover:text-white'}
     `"
  >
    <slot/>
  </a>
</template>

<script>
  export default {
    name: "SimpleButton",
    props: {
      hoverBgColor: {
        type: String,
        required: true
      },
      bgColor: {
        type: String,
        required: true
      },
      textColor: {
        type: String
      },
      hoverTextColor: {
        type: String
      }
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
