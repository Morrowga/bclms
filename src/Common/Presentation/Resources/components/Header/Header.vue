<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";

let props = defineProps({
    site_data: {
        type: Object,
        default: null,
    },
    is_drawer: {
        type: Object,
        default: false,
    },
});
let emit = defineEmits();

let toggle = () => {
    emit("openDrawer");
};
</script>
<template>
    <v-app-bar elevation="0" class="w-100">
        <!-- mobile side navigation -->
        <v-app-bar-nav-icon
            variant="text"
            @click="toggle"
            class="d-flex d-md-none"
        ></v-app-bar-nav-icon>

        <Link
            v-if="!is_drawer"
            to="/"
            class="d-none d-md-flex align-center gap-x-2 ps-15"
        >
            <img :src="site_data.site_logo" width="40" height="40" />
            <h1 class="font-weight-bold leading-normal text-truncate text-xl">
                {{ site_data.site_settings?.site_name }}
            </h1>
        </Link>

        <VSpacer />
        <NavBarNotifications class="me-3" />

        <UserProfile v-if="!is_drawer" class="d-none d-md-flex pe-3" />

        <UserProfile v-if="!is_drawer" class="d-flex d-md-none pe-3" />

        <UserProfile v-if="is_drawer" class="d-flex pe-3" />

        <div class="character-img">
            <img src="/images/tiggie.png" />
        </div>
    </v-app-bar>
</template>
<style scoped>
.character-img img {
    object-fit: contain;
    height: 62px;
    margin-top: 11px;
}
</style>
