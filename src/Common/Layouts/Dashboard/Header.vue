
<template>
  <div class="card relative z-2">
    <Menubar :model="items" class="flex justify-center items-center">
      <template #start>
        <h1 class="text-h4 text-blue-800 pl-5">Logo</h1>
      </template>
      <template #item="{ item }">
        <div class="menu-list-custom">
          <div v-if="item.is_dropdown" class="">
            <a
              href="#"
              class="p-menuitem-link"
              :class="[item.active_class ? 'active' : '']"
              tabindex="-1"
              aria-hidden="true"
              v-if="item.is_active"
            >
              <span class="p-menuitem-icon pi pi-fw pi-user"></span>
              <span class="p-menuitem-text">{{ item.label }}</span>
              <span class="p-submenu-icon pi pi-angle-down"></span>
            </a>
            <ul role="menu" class="p-submenu-list">
              <li
                v-for="(sub_item, index) in item.items"
                :key="index"
                id="pv_id_8_2_0"
                class="p-menuitem"
                role="menuitem"
                aria-label="Roles"
                aria-level="2"
                aria-setsize="3"
                aria-posinset="1"
              >
                <div class="p-menuitem-content">
                  <Link
                    :href="sub_item.url"
                    class="p-menuitem-link"
                    :class="[item.active_class ? 'active' : '']"
                    tabindex="-1"
                    aria-hidden="true"
                  >
                    <span
                      class="p-menuitem-icons"
                      :class="sub_item.icon"
                    ></span>
                    <span class="p-menuitem-text">{{ sub_item.label }}</span>
                  </Link>
                </div>
                <!---->
              </li>
            </ul>
          </div>
          <div v-else>
            <Link
              :href="item.url"
              class="p-menuitem-link"
              :class="[item.active_class ? 'active' : '']"
              tabindex="-1"
              aria-hidden="true"
              v-if="item.is_active"
            >
              <span class="p-menuitem-icon" :class="item.icon"></span>
              <span class="p-menuitem-text">{{ item.label }}</span>
            </Link>
          </div>
        </div>
      </template>
      <template #end>
        <!-- #################### Notification Start ########### -->

        <div class="flex gap-[10px] items-center">
          <div class="card" v-if="auth != null">
            <Notifications />
          </div>
          <Avatar
            image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
            size="large"
            @click="toggle"
            shape="circle"
          />
        </div>
        <AvatarMenu
          v-if="showProfile"
          :title="props.auth?.data?.name"
          :subtitle="props.auth?.data?.email"
          :items="menuItems"
        >
          <template #footer>
            <button
              class="w-full p-link flex items-center p-2 pl-4 text-color hover:surface-200 border-noround"
              type="submit"
              @click.prevent="Logout"
            >
              <div class="pl-6">
                <i class="pi pi-sign-out"></i>
                <span class="ml-2">
                  {{
                    route().current()?.includes("studentdashboard")
                      ? "Go To Teacher"
                      : "Log Out"
                  }}
                </span>
              </div>
            </button>
          </template>
        </AvatarMenu>
        <!-- <div
          class="absolute w-auto right-3 z-10 mt-2 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
          v-if="showProfile"
        >
          <div class="p-5">
            <div class="flex flex-col">
              <div class="grid grid-rows-3 grid-flow-col gap-x-4 gap-y-1">
                <img
                  src="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
                  class="col-span-5 rounded row-span-3"
                />

                <div class="col-span-2">
                  <span class="font-bold whitespace-nowrap">
                    {{ props.auth?.data?.name ?? "" }}
                  </span>
                </div>
                <div class="row-span-2 col-span-2">
                  {{ props.auth?.data?.email ?? "" }}
                </div>
              </div>

              <div class="grid grid-cols-2 grid-rows-3">
                <span class="row-span-1 col-span-2"> </span>
              </div>

              <button
                type="submit"
                @click.prevent="Logout"
                class="mt-4 justify-self-end w-100 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
              >
                Sign Out
              </button>
            </div>
          </div>
        </div> -->
      </template>
    </Menubar>
  </div>
</template>

<script setup>
import Menubar from "primevue/menubar";
import InputText from "primevue/inputtext";
import axios from "axios";
import { router, usePage, Link } from "@inertiajs/vue3";
import Notifications from "@Composables/Notifications.vue";
import AvatarMenu from "@Composables/AvatarMenu.vue";

import { computed, ref } from "vue";
let props = computed(() => usePage().props);
let auth = computed(() => usePage().props.auth.data);
const permissions = props.value.auth.data.permissions;

const role = props.value.auth.data.roles;
const showProfile = ref(false);
const role_name = role?.[0]?.name;

let checkPermission = (permission) => {
  return permissions.includes(permission) ? true : false;
};
let activate_class = (route_name) => {
  return route().current()?.includes(route_name);
};
const items = ref([
  {
    label: "Home",
    url: "/home",
    icon: "pi pi-home",
    is_active: true,
    active_class: activate_class("dashboard"),
  },
  {
    label: "Organization",
    icon: "pi pi-fw pi-pencil",
    url: "#",
    is_active: checkPermission("access_organization"),
    active_class: false,
  },
  {
    label: "Users",
    icon: "pi pi-fw pi-user",
    url: "#",
    is_dropdown: true,
    is_active: checkPermission("access_user"),
    active_class:
      activate_class("users.index") ||
      activate_class("permissions.index") ||
      activate_class("roles.index"),
    items: [
      {
        label: "Roles",
        url: "/roles",
        icon: "pi pi-fw pi-user-plus",
        is_active: checkPermission("access_role"),
        active_class: activate_class("roles.index"),
      },
      {
        label: "Permission",
        url: "/permissions",
        icon: "pi pi-fw pi-user-minus",
        is_active: checkPermission("access_permission"),
        active_class: activate_class("permissions.index"),
      },
      {
        label: "Management",
        url: "/users",
        icon: "pi pi-fw pi-users",
        is_active: checkPermission("access_user"),
        active_class: activate_class("users.index"),
      },
    ],
  },
  {
    label: "Announcement",
    icon: "pi pi-fw pi-calendar",
    url: "/",
    is_active: checkPermission("access_announcement"),
    active_class: false,
  },
  {
    label: "Settings",
    icon: "pi pi-spin pi-cog",
    is_active: checkPermission("access_announcement"),
    url: "/settings",
  },
]);

const menuItems = [
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
function Logout() {
  router.post("/logout");
}
console.log(items.value);
const toggle = () => {
  showProfile.value = !showProfile.value;
};
// let signOut = () =>{
//   route
//   router.get(route('login-page'));
// }
</script>

<style >
.p-menubar .p-menubar-root-list {
  margin-left: auto;
}
.active {
  color: #495057;
  background: #e9ecef;
  border-radius: none;
}
.p-menuitem {
  margin: 0 6px !important;
}
.p-submenu-list .p-menuitem {
  margin: 0 !important;
}
.p-menuitem-content {
  border-radius: 0 !important;
}
</style>
