
<template>
    <div class="card relative z-2">
        <Menubar :model="items" class="flex justify-center items-center">
            <template #start>
               <h1 class="text-h4 text-blue-800 pl-5">Logo</h1>
            </template>
            <template #end>
                <Avatar image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png" size="large"  @click="toggle" class="mr-2" shape="circle" />
                 <div
                  class="absolute w-auto right-3 z-10 mt-2 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  v-if="showProfile"
                >
                  <div class="p-5">
                    <div class="flex flex-col">
                      <div
                        class="grid grid-rows-3 grid-flow-col gap-x-4 gap-y-1"
                      >
                        <img
                          src="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
                          class="col-span-5 rounded row-span-3"
                        />

                        <div class="col-span-2">
                          <span class="font-bold whitespace-nowrap">
                            Admin
                          </span>
                        </div>
                        <div class="row-span-2 col-span-2">
                          admin@admin.com
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
                </div>
            </template>
        </Menubar>
    </div>
</template>

<script setup>
import Menubar from "primevue/menubar"
import InputText from "primevue/inputtext"
import axios from 'axios';
import {router } from "@inertiajs/vue3";

import { ref } from "vue";

const showProfile = ref(false);
const items = ref([
    {
        label: 'Home',
        url:"/",
        icon: 'home',

    },
    {
        label: 'Organization',
        icon: 'pi pi-fw pi-pencil',
    },
    {
        label: 'Users',
        icon: 'pi pi-fw pi-user',
        items: [
            {
                label: 'Roles',
                url:"/roles",
                icon: 'pi pi-fw pi-user-plus'
            },
            {
                label: 'Permission',
                url:"/permissions",
                icon: 'pi pi-fw pi-user-minus'
            },
            {
                label: 'Management',
                url:"/users",
                icon: 'pi pi-fw pi-users',
            }
        ]
    },
    {
        label: 'Announment',
        icon: 'pi pi-fw pi-calendar',

    }
]);

function Logout()
{
    router.post('/logout');
}

const toggle = () => {
  showProfile.value = !showProfile.value
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
</style>
