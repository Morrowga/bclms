<script setup>
import { ref, defineProps, defineEmits } from "vue";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";
import HorizontalNavStudent from "@layouts/components/HorizontalNavStudent.vue";
import { Link, usePage } from "@inertiajs/vue3";
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
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);

let toggle = () => {
    emit("openDrawer");
};
</script>
<template>
    <v-app-bar elevation="0" style="background: #000 !important; padding: 0 40px">
        <!-- mobile side navigation -->
        <UserProfile class="d-flex pe-3 "/>

        <VSpacer />

        <v-app-bar-nav-icon
            variant="text"
            @click="toggle"
            class="d-flex d-md-none"
        ></v-app-bar-nav-icon>

        <Link v-if="!is_drawer" to="/" class="d-none d-md-flex align-center">
            <img src="/images/logowhite.png" width="200" height="55" />
        </Link>
        <VSpacer />

        <HorizontalNavStudent :nav-items="navItems" :current_user_role="user_role" />

        <VSpacer />

        <v-img src="/images/Tiggie Face Blue.png"></v-img>

    </v-app-bar>
</template>
<style scoped>
.character-img img {
    object-fit: contain;
    height: 62px;
    margin-top: 11px;
}
</style>
