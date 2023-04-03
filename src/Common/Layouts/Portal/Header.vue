<template>
  <div class="card relative z-2">
    <Menubar :model="items" class="flex items-center">
      <template #start>
        <h1 class="text-h4 text-blue-800 pl-5">Logo</h1>
      </template>
      <template
        #item
        v-if="route().current() != 'login' && route().current() != 'register'"
      >
        <div class="flex gap-3">
          <select
            class="py-3 px-4 pr-9 block w-full text-primary font-bold rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
          >
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
        <div class="flex gap-[10px] items-center">
          <!-- #################### Notification Start ########### -->
          <div class="card" v-if="auth != null">
            <Notifications />
          </div>
          <!-- #################### Notification End ########### -->
          <div v-if="auth == null">
            <Link
              :href="route('login')"
              v-if="route().current() != 'login'"
              class="px-1"
            >
              <Button label="Login" class="bg-primary" />
            </Link>
            <Link
              :href="route('register')"
              v-if="route().current() != 'register'"
              class="px-1"
            >
              <Button label="Sign Up" class="bg-primary" />
            </Link>
          </div>
          <div v-else>
            <Avatar
              image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
              size="large"
              @click="toggle"
              class="mr-2"
              shape="circle"
            />
            <AvatarMenu
              v-if="showProfile"
              :title="auth?.name"
              :subtitle="auth?.email"
              :items="menuItems"
            >
              <template #footer>
                <button
                  class="w-full p-link flex items-center p-2 pl-4 text-color hover:surface-200 border-noround"
                  type="submit"
                  @click.prevent="Logout"
                >
                  <div class="pl-6">
                    <i class="pi pi-sign-out"></i
                    ><span class="ml-2">Log Out</span>
                  </div>
                </button>
              </template>
            </AvatarMenu>
          </div>
        </div>
      </template>
    </Menubar>
  </div>
</template>

<script setup>
import Menubar from "primevue/menubar";
import InputText from "primevue/inputtext";
import TreeSelect from "primevue/treeselect";
import { computed, ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { useInfiniteScroll } from "@vueuse/core";
import Notifications from "@Composables/Notifications.vue";
import AvatarMenu from "@Composables/AvatarMenu.vue";
import axios from "axios";
let auth = computed(() => usePage().props.auth.data);
const items = ref([1]);
const showProfile = ref(false);
const selectedCountry = ref();
const menuItems = [
  {
    label: "Students",
    icon: "pi pi-users",
    url: route("dashboard"),
    is_active: auth.value?.roles?.[0]?.name == "teacher/parent",
  },
  {
    label: "Settings",
    icon: "pi pi-cog",
    url: "#",
    is_active: true,
  },
  {
    label: "Edit Profile",
    icon: "pi pi-user-edit",
    url: "#",
    is_active: true,
  },
  {
    label: "Subscription",
    icon: "pi pi-money-bill",
    url: "#",
    is_active: true,
  },
  {
    label: "Help",
    icon: "pi pi-compass",
    url: "#",
    is_active: true,
  },
];
const countries = ref([
  {
    key: "1",
    label: "Movies",
    icon: "pi pi-fw pi-calendar",
    data: "Movies Folder",
  },
  {
    key: "2",
    label: "Movies",
    icon: "pi pi-fw pi-calendar",
    data: "Movies Folder",
  },
  {
    key: "3",
    label: "Movies",
    icon: "pi pi-fw pi-calendar",
    data: "Movies Folder",
  },
]);

function Logout() {
  router.post("/logout");
}
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

.p-treeselect-items-wrapper {
  padding-left: -200px !important;
}
</style>
