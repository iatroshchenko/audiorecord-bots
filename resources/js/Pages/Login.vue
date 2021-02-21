<template>

  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
             alt="Workflow">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
      </div>
      <form class="mt-8 space-y-6" action="#" method="POST">
        <input type="hidden" name="remember" value="true">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input
              v-model="loginForm.email"
              id="email-address"
              type="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Email address"
            >
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input
              v-model="loginForm.password"
              id="password"
              type="password" required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Password"
            >
          </div>
        </div>

        <!-- Errors block -->
        <div v-if="errors.email">{{ errors.email }}</div>
        <div v-if="errors.password">{{ errors.password }}</div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember_me" name="remember_me" type="checkbox"
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 block text-sm text-gray-900">
              Remember me
            </label>
          </div>

          <div class="text-sm">
            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
              Forgot your password?
            </a>
          </div>
        </div>

        <SubmitButton
          :with-lock-icon="true"
          :loading="loading"
          @clicked="submitLoginForm"
        >
          Create Account
        </SubmitButton>
      </form>
    </div>
  </div>

</template>

<script>
  import SubmitButton from "../components/ui/SubmitButton";

  export default {
    name: "Login",
    props: {
      started: Boolean,
      errors: Object
    },
    data() {
      return {
        loginForm: {
          email: '',
          password: ''
        },
        loading: false
      }
    },
    components: {
      SubmitButton
    },
    methods: {
      async submitLoginForm() {
        this.loading = true;
        try {
          const response = await this.$inertia.post(this.$backendRoute('login.authenticate'), this.loginForm);
        } catch (error) {
          console.log(error);
        }
        this.loading = false;
      }
    }
  }
</script>

<style>

</style>
