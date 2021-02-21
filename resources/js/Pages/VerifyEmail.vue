<template>
  <!-- Full-width fluid until the `lg` breakpoint, then lock to container -->
  <div class="md:container md:mx-auto">
    Now You should verify your email

    <simple-button
      hover-bg-color="indigo-700"
      bg-color="indigo-600"
    >
      Change Email
    </simple-button>

    <simple-button
      bg-color="red-600"
      hover-bg-color="red-700"
    >
      Resend Verification Notification
    </simple-button>
  </div>
</template>

<script>

  import AppLayout from "../layouts/AppLayout";
  import SimpleButton from "../components/ui/SimpleButton";

  export default {
    name: "VerifyEmail",
    components: {
      SimpleButton
    },
    data() {
      return {

      }
    },
    layout: AppLayout
  }
</script>

<style>

</style>
