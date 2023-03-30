<template>
    <AdminLayout>
        <div class="grid grid-cols-12 gap-3 h-full ">
        <div class="menu-items bg-cwhite col-span-2 text-center pt-10">
            <div class="items">
                <ul>
                    <li :class="['flex items-center justify-items-center ',currentSettings =='global' ? 'border-l-8      border-l-primary':'']" @click="settings('global')">
                        <span class="material-symbols-outlined p-3">
                            settings_applications
                        </span>
                        Application
                    </li>
                    <li :class="['flex items-center justify-items-center ',currentSettings =='date_format' ? 'border-l-8 border-l-primary':'']" @click="settings('date_format')">
                        <span class="material-symbols-outlined p-3">
                            history_toggle_off
                        </span>
                        Date Format
                    </li>

                    <li :class="['flex items-center justify-items-center ',currentSettings =='banner' ? 'border-l-8 border-l-primary':'']" @click="settings('banner')">
                        <span class="material-symbols-outlined p-3">
                            vrpano
                        </span>
                        Banner
                    </li>
                </ul>
            </div>
        </div>
        <div class="container col-span-10 pt-10 pl-10">
            <Globle v-if="currentSettings=='global'"/>
            <DateFormat v-if="currentSettings=='date_format'"/>
            <Banner v-if="currentSettings == 'banner'"/>
        </div>
         </div>
    </AdminLayout>
</template>

<script setup>
import {ref} from "vue"
import AdminLayout from "@dashboard/AdminLayout.vue";
import Globle from "./Globle.vue";
import DateFormat from "./DateFormat.vue"
import Banner from "./Banner.vue"

let currentSettings = ref("global");
// globale setting function

function settings(value)
{
    currentSettings.value = value
}
</script>
