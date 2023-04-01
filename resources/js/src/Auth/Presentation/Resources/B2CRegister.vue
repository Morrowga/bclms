<template>
 <div class="basis-1/3">
            <h1
              class="align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
            >
              Enter your B2C Register
            </h1>
            <br />
            <form @submit.prevent="RegisterAsB2C">
            <div class="mb-4">
              <LabelInput
                type="email"
                label="Your Email"
                placeholder="name@mail.com"
                v-model="form.email"
                :error="form.errors.email"
                :required="true"
              />
            </div>
            <div class="mb-4">
              <LabelInput
                type="password"
                label="Password"
                placeholder="••••••••"
                v-model="form.password"
                :error="form.errors.password"
                :required="true"
              />
            </div>

            <div class="mb-4 text-justify">
              <span>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui
                commodi exercitationem, dolores beatae quae eveniet neque
                maiores obcaecati nostrum quod at quidem autem. Dolorum
                repudiandae cum rem incidunt labore suscipit!
              </span>
            </div>
            <div class="mb-4">
              <button
                type="submit"
                class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
              >
                Register
              </button>
            </div>
            </form>
          </div>
</template>

<script setup>
import LabelInput from "@Composables/LabelInput.vue";
import { useForm } from "@inertiajs/vue3";
let form = useForm({
  email: "",
  password: "",
});


function RegisterAsB2C()
{
    form.post(route("b2cstore"), form, {
    onSuccess: () => {},
    onError: (error) => {
      form.setError("user",error?.user);
      form.setError("email", error?.email);
      form.setError("password", error?.password);
    },
  });
}

</script>
