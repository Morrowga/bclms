<template>
  <FrontendLayout :route="{ name: route('login'), label: 'Login' }">
    <div class="overflow-hidden register-bg">
      <div class="mx-auto" style="max-width: 1024px">
        <form action="#" @submit.prevent="register">
          <div class="flex flex-col justify-around p-3 md:flex-row">
            <div class="mt-14" :class="organization == 'on' ? '' : 'text-clip'">
              <h1
                class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-blue-800 md:text-lg lg:text-2xl animate-fadein transition-opacity duration-500"
              >
                Are you signing up under
              </h1>
              <h1
                class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-blue-800 md:text-lg lg:text-2xl"
              >
                an Organization account ?
              </h1>
              <div
                class="scale-90 border-dashed my-5 border-4 border-purple-600 p-3 text-center flex justify-between"
              >
                <div class="px-5">
                  <input
                    id="default-radio-1"
                    type="radio"
                    value="on"
                    name="organization"
                    v-model="organization"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />

                  <label
                    for="default-radio-1"
                    class="ml-2 text-sm font-medium text-gray-900"
                    >Yes</label
                  >
                </div>
                <div class="px-5">
                  <input
                    id="default-radio-2"
                    type="radio"
                    value="off"
                    name="organization"
                    v-model="organization"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="default-radio-2"
                    class="ml-2 text-sm font-medium text-gray-900"
                    >No</label
                  >
                </div>
              </div>
              <div
                class="card mt-5 flex justify-content-center grow h-14"
                v-if="organization == 'on'"
              >
                <Dropdown
                  v-model="selectedCountry"
                  :options="countries"
                  filter
                  optionLabel="name"
                  placeholder="Select a Country"
                  class="w-full md:w-14rem"
                >
                  <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex align-items-center">
                      <img
                        :alt="slotProps.value.label"
                        src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                        :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`"
                        style="width: 18px"
                      />
                      <div>{{ slotProps.value.name }}</div>
                    </div>
                    <span v-else>
                      {{ slotProps.placeholder }}
                    </span>
                  </template>
                  <template #option="slotProps">
                    <div class="flex align-items-center">
                      <img
                        :alt="slotProps.option.label"
                        src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png"
                        :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`"
                        style="width: 18px"
                      />
                      <div>{{ slotProps.option.name }}</div>
                    </div>
                  </template>
                </Dropdown>
              </div>

              <div class="flex gap-3 my-16" v-if="organization == 'initial'">
                <hr style="border: 1px solid #3b82f6; width: 100%" />
              </div>
              <div
                class="flex gap-3 my-4 w-full"
                v-if="organization == 'on' || organization == 'off'"
              >
                <Checkbox
                  v-model="checked"
                  class="mt-2"
                  inputId="ingredient4"
                  name="pizza"
                  value="Onion"
                />
                <label for="ingredient4" class="text-sm w-72">
                  Yes! I would like to receive udpates, special offers, and
                  other information from Ed+
                </label>
              </div>
              <div
                class="flex gap-3 my-4 w-full justify-center"
                v-if="organization == 'initial'"
              >
                <span
                  >Already have an account?
                  <Link class="text-blue-500" :href="route('login')"
                    >Log In</Link
                  ></span
                >
              </div>
            </div>
            <B2BRegister
              v-if="organization == 'on'"
              :class="
                organization == 'on'
                  ? 'animate__animated animate__backInRight animate__delay-0.1s'
                  : 'text-clip'
              "
            />
            <B2CRegister
              v-if="organization == 'off'"
              :class="
                organization == 'off'
                  ? 'animate__animated animate__backInRight animate__delay-0.1s'
                  : 'text-clip'
              "
            />
          </div>
        </form>
      </div>
    </div>
  </FrontendLayout>
</template>

<script setup>
import { ref, watch } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import Checkbox from "primevue/checkbox";
import Dropdown from "primevue/dropdown";
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";

let organization = ref("initial");
const checked = ref();
const selectedCountry = ref();

let form = useForm({
  email: "",
  password: "",
  user: "",
});

let assignUser = (event) => {
  form.user = event.target.value;
};
let register = () => {
  form.post(route("register"), {
    onSuccess: () => {},
    onError: (error) => {
      form.setError("email", error?.email);
      form.setError("password", error?.password);
    },
  });
};

// organization select
const countries = ref([
  { name: "Australia", code: "AU" },
  { name: "Brazil", code: "BR" },
  { name: "China", code: "CN" },
  { name: "Egypt", code: "EG" },
  { name: "France", code: "FR" },
  { name: "Germany", code: "DE" },
  { name: "India", code: "IN" },
  { name: "Japan", code: "JP" },
  { name: "Spain", code: "ES" },
  { name: "United States", code: "US" },
]);
watch(organization, (newValue, oldValue) => {
  console.log(newValue);
});
</script>
<style scoped>
.register-bg {
  background: url("/public/images/regiser.svg") 100% 100% no-repeat;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>
