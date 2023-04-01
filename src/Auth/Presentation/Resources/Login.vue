<template>
  <FrontendLayout :route="{ name: route('register'), label: 'Register' }">
    <section class="bg-gray-50 register-bg">
      <Toast />
      <div
        class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
      >
        <div class="w-full md:mt-0 sm:max-w-md xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1
              class="text-3xl font-bold text-center leading-tight tracking-tight text-blue-900"
            >
              Enter your email address
            </h1>
            <form
              class="space-y-4 md:space-y-6"
              action="#"
              @submit.prevent="login"
            >
              <LabelInput
                title="Enter your email"
                type="email"
                label="Enter Your work email address"
                placeholder="name@mail.com"
                v-model="form.email"
                :error="form.errors.email"
                :required="true"
              />
              <br />
              <LabelInput
                type="password"
                label="Enter Your Password"
                placeholder="••••••••••"
                v-model="form.password"
                :error="form.errors.password ?? props.error"
                :required="true"
              />
              <br />

              <!-- <div class="flex items-center justify-between">
                <div class="flex items-start">
                  <div class="flex items-center h-5">
                    <input
                      id="remember"
                      aria-describedby="remember"
                      type="checkbox"
                      class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600"
                    />
                  </div>
                  <div class="ml-3 text-sm">
                    <label
                      for="remember"
                      class="text-gray-500 dark:text-gray-300"
                      >Remember me</label
                    >
                  </div>
                </div>
                <a
                  href="#"
                  class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                  >Forgot password?</a
                >
              </div> -->
              <button
                type="submit"
                class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
              >
                Sign In
              </button>
              <div class="flex justify-center">
                <p class="text-sm font-light text-gray-500">
                  Don’t have an account yet?
                  <Link
                    :href="route('register')"
                    class="font-medium rounded-none text-blue-500 hover:underline"
                    >Sign up</Link
                  >
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </FrontendLayout>
</template>

<script setup>
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, defineProps, onMounted, watch } from "vue";
import LabelInput from "@Composables/LabelInput.vue";
import { useToast } from "primevue/usetoast";

let props = defineProps(["error"]);
let errorMessage = computed(() => usePage().props.flash);
console.log(props.error);
let toast = useToast();
let form = useForm({
  email: "",
  password: "",
});

let login = () => {
  form.post(route("login"), form, {
    onSuccess: () => {},
    onError: (error) => {
      form.setError("email", error?.email);
      form.setError("password", error?.password);
    },
  });
};
onMounted(() => {
  console.log(props.value, "hey you");

  // if (errorMessage.value) {
  //   toast.add({
  //     severity: "error",
  //     summary: "Verify",
  //     detail: errorMessage.value,
  //     life: 3000,
  //   });
  // }
});
</script>
<style scoped>
.register-bg {
  background: url("/public/images/LoginPage.svg") no-repeat;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>