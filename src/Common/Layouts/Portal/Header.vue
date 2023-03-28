<template>
  <div class="card relative z-2 ">
    <Menubar :model="items" class="flex items-center">
      <template #start>
        <h1 class="text-h4 text-blue-800 pl-5">Logo</h1>
      </template>
      <template #item
        v-if="route().current() != 'login' && route().current() != 'register'"
      >
        <div class="flex gap-3">
           <select class="py-3 px-4 pr-9 block w-full text-primary font-bold rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
            <option selected>Categories</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            </select>
          <div class="card flex justify-content-center">
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText v-model="value1" placeholder="Search" />
            </span>
          </div>
          <div class="card flex justify-content-center">
            <Button
              class="bg-primary"
              icon="pi pi-align-center"
              aria-label="Filter"
              label="Filters"
            />
          </div>
        </div>
      </template>
      <template #end>
        <div class="flex gap-[10px]">
          <!-- <div class="bg-primary rounded-full"> -->
            <img src="images/notification.png" width="50" height="30" alt="">
            <!-- <i class="pi pi-bell p-3 text-white" style="font-size: 1.7rem"></i> -->
          <!-- </div> -->
          <Link :href="route('login')">
            <Button label="Login" />
          </Link>
          <Link :href="route('register')">
            <Button label="Sign Up" />
          </Link>
        </div>
      </template>
    </Menubar>
  </div>
</template>

<script setup>
import Menubar from "primevue/menubar";
import InputText from "primevue/inputtext";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import TreeSelect from "primevue/treeselect";
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
let auth = computed(() => usePage().props.auth);
const selectedCountry = ref();

const showProfile = ref(false);
const items = ref([1]);

defineProps(["route_data"]);

const countries = ref([
  { "key": "1",
    "label": "Movies",
    "icon": "pi pi-fw pi-calendar",
    "data": "Movies Folder",

   },
  {
    "key": "2",
    "label": "Movies",
    "icon": "pi pi-fw pi-calendar",
    "data": "Movies Folder",

  },
  {
    "key": "3",
    "label": "Movies",
    "icon": "pi pi-fw pi-calendar",
    "data": "Movies Folder",
   },
]);

const toggle = () => {
  showProfile.value = !showProfile.value;
};
</script>

<style>
.p-menubar .p-menubar-root-list {
  margin-left: auto;
}

.p-button.p-button-link {
  background: #4338ca !important;
  text-decoration: none !important;
  color: aliceblue !important;
}

.p-treeselect-items-wrapper	{
   padding-left:-200px !important;
}

</style>
