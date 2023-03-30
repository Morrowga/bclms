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
            <Button
              label=""
              style="padding: 7px"
              rounded
              @click="openPosition('topright')"
            >
              <i style="font-size: 1.3rem" class="pi pi-bell"></i>
            </Button>
            <Badge
              class="mb-4"
              :value="unread_notifications_count"
              severity="danger"
            ></Badge>
            <Dialog
              v-model:visible="visible"
              header="Notifications"
              :style="{ width: '40vw' }"
              :position="position"
              :modal="true"
              :draggable="false"
            >
              <div
                v-if="notifications?.length > 0"
                class="flex flex-col justify-between"
              >
                <Message
                  v-for="(notifcation, index) in notifications"
                  :key="index"
                  severity="info"
                  icon="pi pi-bell"
                  @close.prevent="markAsRead(notifcation.id)"
                  >{{ notifcation.data.message }}</Message
                >
                <div class="d-flex text-center w-100">
                  <Button
                    size="small"
                    class="w-1/3"
                    label="Clear All"
                    outlined
                    @click="markAsReadAll"
                  />
                </div>
              </div>
              <div v-else>
                <p>Empty Notifications...</p>
              </div>
            </Dialog>
          </div>
          <!-- #################### Notification End ########### -->
          <div v-if="auth == null">
            <Link
              :href="route('login')"
              v-if="route().current() != 'login'"
              class="px-1"
            >
              <Button label="Login" />
            </Link>
            <Link
              :href="route('register')"
              v-if="route().current() != 'register'"
              class="px-1"
            >
              <Button label="Sign Up" />
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
            <div
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
                      <span class="font-bold whitespace-nowrap"> Admin </span>
                    </div>
                    <div class="row-span-2 col-span-2">admin@admin.com</div>
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
            </div>
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

let auth = computed(() => usePage().props.auth.data);
let notifications = computed(() => usePage().props.notifications);
let unread_notifications_count = computed(
  () => usePage().props.unreadNotificationsCount
);

const selectedCountry = ref();

const showProfile = ref(false);
const items = ref([1]);

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

const position = ref("center");

const visible = ref(false);

const openPosition = (pos) => {
  position.value = pos;
  visible.value = true;
};
const markAsRead = async (noti_id) => {
  await router.post(route("markAsRead", { id: noti_id }), {
    onSuccess: () => {
      console.log("deleted");
    },
  });
};
const markAsReadAll = async (noti_id) => {
  await router.post(route("markAsReadAll"), {
    onSuccess: () => {
      console.log("deleted all");
    },
  });
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
