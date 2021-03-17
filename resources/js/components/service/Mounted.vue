<template>
  <div class="mounted" v-show="false"></div>
</template>

<script>
  export default {
    name: 'Mounted',
    mounted() {
      this.$emit('mounted')
    }
  }
</script>
