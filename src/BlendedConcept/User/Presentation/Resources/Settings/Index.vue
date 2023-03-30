<template>
    <AdminLayout>
        <div class="grid grid-cols-12 gap-3 h-full ">
        <div class="menu-items bg-cwhite col-span-2 text-center pt-10">
            <div class="items">
                <ul>
                    <li class="flex items-center justify-items-center" @click="settings('global')">
                        <span class="material-symbols-outlined p-3">
                            settings
                        </span>
                        global setting
                    </li>
                    <li class="flex items-center justify-items-center ">
                        <span class="material-symbols-outlined p-3">
                            settings
                        </span>
                        color setting
                    </li>
                    <li class="flex items-center gap-2 justify-items-center ">
                        <span class="material-symbols-outlined p-3">
                            settings
                        </span>
                        font setting
                    </li>
                    <li class="flex items-center gap-2 justify-items-center ">
                        <span class="material-symbols-outlined p-3">
                            settings
                        </span>
                        banner setting
                    </li>
                </ul>
            </div>
        </div>
        <div class="container col-span-10 pt-10 pl-10">
            <Globle v-if="currentSettings=='global'"/>
        </div>
         </div>
    </AdminLayout>
</template>

<script setup>
import {ref} from "vue"
import AdminLayout from "@dashboard/AdminLayout.vue";
import Globle from "./globle.vue"
let currentSettings = ref("");
// globale setting function

function settings(value)
{
    currentSettings.value = value
}
</script>
