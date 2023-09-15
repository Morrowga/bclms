<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";

import { HorizontalNav } from "@layouts/components";
import navItems from "@/navigation/horizontal";

let props = defineProps({
    site_data: {
        type: Object,
        default: null,
    },
    is_drawer: {
        type: Boolean,
        default: false,
    },
});
let emit = defineEmits();

let toggle = () => {
    emit("openDrawer");
};
</script>
<template>
    <v-app-bar elevation="0" class="head-padding">
        <!-- mobile side navigation -->
        <v-app-bar-nav-icon
            variant="text"
            @click="toggle"
            class="d-flex d-md-none"
        ></v-app-bar-nav-icon>

        <Link v-if="!is_drawer" to="/" class="d-none d-md-flex align-center">
            <img src="/images/sitelogotext.svg" width="200" height="200" />
        </Link>
        <VSpacer />

        <HorizontalNav :nav-items="navItems" />

        <VSpacer />
        <NavBarNotifications class="me-3" />

        <UserProfile v-if="!is_drawer" class="d-none d-md-flex pe-3" />

        <UserProfile v-if="!is_drawer" class="d-flex d-md-none pe-3" />

        <UserProfile v-if="is_drawer" class="d-flex pe-3" />
    </v-app-bar>
</template>
<style scoped>
.character-img img {
    object-fit: contain;
    height: 62px;
    margin-top: 11px;
}
.head-padding {
    padding: 0 171px !important;
}
</style>
