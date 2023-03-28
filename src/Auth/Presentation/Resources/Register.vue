<template>
  <FrontendLayout :route="{name: route('login'),label:'Login'}">
  <div class="container mx-auto mt-28 ">
    <form action="#" @submit.prevent="register">
        <div class="flex  flex-col justify-around p-3 md:flex-row" >
          <div :class="organization == 'on' ? '':'text-clip' ">
            <h1
              class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white animate-fadein transition-opacity duration-500"
            >
              Are you signing up under
            </h1>
            <h1
              class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
            >
              an Organization account ?
            </h1>
              <div
                class="border-dashed my-5 border-4 border-purple-600 p-3 text-center flex justify-between"
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
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
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
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >No</label
                  >
                </div>
              </div>
               <div class="card mt-5 flex justify-content-center grow h-14" v-if="organization =='on'">
               <Dropdown  v-model="selectedCountry" :options="countries" filter optionLabel="name" placeholder="Select a Country" class="w-full md:w-14rem">
                  <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex align-items-center">
                    <img :alt="slotProps.value.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.value.code.toLowerCase()}`" style="width: 18px" />
                    <div>{{ slotProps.value.name }}</div>
                   </div>
                   <span v-else>
                    {{ slotProps.placeholder }}
                   </span>
                </template>
                <template #option="slotProps">
                   <div class="flex align-items-center">
                    <img :alt="slotProps.option.label" src="https://primefaces.org/cdn/primevue/images/flag/flag_placeholder.png" :class="`mr-2 flag flag-${slotProps.option.code.toLowerCase()}`" style="width: 18px" />
                    <div>{{ slotProps.option.name }}</div>
                  </div>
                </template>
            </Dropdown>
               </div>

              <div class="flex gap-3 my-4">
              <Checkbox v-model="checked" class="mt-2" inputId="ingredient4" name="pizza" value="Onion" />
              <label for="ingredient4" class="text-sm w-48"> Yes! I would like to receive udpates, special offers, and other information from Ed+ </label>
              </div>
          </div>
           <B2BRegister v-if="organization == 'on'"  :class="organization == 'on' ? 'animate__animated animate__backInRight animate__delay-0.1s':'text-clip' "/>
           <B2CRegister v-if="organization == 'off'" :class="organization == 'off' ? 'animate__animated animate__backInRight animate__delay-0.1s':'text-clip' "/>
        </div>
    </form>
  </div>
  </FrontendLayout>
</template>

<script setup>
import {ref,watch} from "vue"
import { useForm} from "@inertiajs/vue3";
import Checkbox from "primevue/checkbox"
import Dropdown  from "primevue/dropdown"
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import B2CRegister from "./B2CRegister.vue"
import B2BRegister from "./B2BRegister.vue"

let organization = ref();
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
    { name: 'Australia', code: 'AU' },
    { name: 'Brazil', code: 'BR' },
    { name: 'China', code: 'CN' },
    { name: 'Egypt', code: 'EG' },
    { name: 'France', code: 'FR' },
    { name: 'Germany', code: 'DE' },
    { name: 'India', code: 'IN' },
    { name: 'Japan', code: 'JP' },
    { name: 'Spain', code: 'ES' },
    { name: 'United States', code: 'US' }
]);
watch(organization,(newValue,oldValue)=>
{
    console.log(newValue);
})
</script>
