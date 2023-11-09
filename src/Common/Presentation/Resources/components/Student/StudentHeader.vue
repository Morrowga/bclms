<script setup>
import { ref, defineProps, defineEmits } from "vue";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
// import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import StudentProfile from "@/layouts/components/StudentProfile.vue";
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
let tiggieImage = "";
let user_role = computed(() => page.props.user_info.user_role.name);
let student = computed(() => page.props.auth.data.student);
let toggle = () => {
    emit("openDrawer");
};
onMounted(() => {
    switch (route()?.current()) {
        case "dashboard":
            tiggieImage = "/images/Tiggie Face Blue.png";
            break;

        case "storybooks":
            tiggieImage = "/images/tiggie.png";
            break;

        case "student-games":
            tiggieImage = "/images/tiggie-pink.png";
            break;

        case "student-rewards":
            tiggieImage = "/images/tiggie-yellow.png";
            break;

        default:
            tiggieImage = "/images/Tiggie Face Blue.png";
            break;
    }
});
const openStdMenu = () => {
    emit("openMenu");
};
</script>
<template>
    <v-app-bar elevation="0" class="std-head-bar">
        <!-- mobile side navigation -->
        <StudentProfile
            class="d-none d-lg-flex pe-3"
            v-if="route().current() === 'dashboard'"
            @openStdMenu="openStdMenu()"
        />

        <v-app-bar-nav-icon
            variant="text"
            @click="toggle"
            class="d-flex d-lg-none"
        ></v-app-bar-nav-icon>

        <Link
            href="/home"
            v-if="!is_drawer"
            class="d-none d-lg-flex align-center"
        >
            <img src="/images/logowhite.png" width="200" height="55" />
        </Link>

        <VSpacer />
        <div class="d-none d-md-flex">
            <HorizontalNavStudent
                :nav-items="navItems"
                :current_user_role="user_role"
            />
        </div>

        <VSpacer />

        <v-img :src="tiggieImage"></v-img>

        <div class="ml-5 mt-1">
            <span class="header-coin-text ruddy-bold">Coins</span>
            <div>
                <v-chip class="pa-0 ma-0">
                    <img src="/images/chipcoin.png" width="16" height="16" />
                    <span class="header-coin-chip ml-1 ruddy-bold">{{
                        student.num_silver_coins
                    }}</span>
                    <img
                        src="/images/chipcoin2.png"
                        class="ml-2"
                        width="16"
                        height="16"
                    />
                    <span class="header-coin-chip ruddy-bold">{{
                        student.num_gold_coins
                    }}</span>
                </v-chip>
            </div>
        </div>
    </v-app-bar>
</template>
<style scoped>
.header-coin-text {
    color: #fff !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.header-coin-chip {
    color: #fff;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    text-transform: capitalize;
}
.character-img img {
    object-fit: contain;
    height: 62px;
    margin-top: 11px;
}
.std-head-bar {
    background: #000 !important;
    padding: 0 40px;
}
</style>
