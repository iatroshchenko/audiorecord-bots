<template>
  <div class="lds-dual-ring"></div>
</template>

<script>
  export default {
    name: "IndigoLoader"
  }
</script>

<style scoped>
  .lds-dual-ring {
  }

  .lds-dual-ring:after {
    content: " ";
    display: block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #6365f1;
    border-color: #6365f1 transparent #6365f1 transparent;
    animation: lds-dual-ring 1.2s linear infinite;
  }

  @keyframes lds-dual-ring {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>
