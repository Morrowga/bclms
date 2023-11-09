<script setup>
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { themeConfig } from "@themeConfig";
import navItems from "@/navigation/horizontal";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";
import VerticalNavGroup from "@layouts/components/VerticalNavGroup.vue";
import Header from "@mainRoot/components/Header/Header.vue";
import BCTeacherHeader from "@mainRoot/components/BCTeacherHeader/BCTeacherHeader.vue";
import B2BTeacherHeader from "@mainRoot/components/B2BTeacherHeader/B2BTeacherHeader.vue";
import OrgAdminHeader from "@mainRoot/components/OrgAdminHeader/OrgAdminHeader.vue";
import StudentHeader from "@mainRoot/components/Student/StudentHeader.vue";
import ParentHeader from "@mainRoot/components/ParentHeader/ParentHeader.vue";
import Footer from "@mainRoot/components/Footer/Footer.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";
import { onMounted, ref, computed, defineProps } from "vue";
const resolveNavItemComponent = (item) => {
    if ("children" in item) return VerticalNavGroup;

    return VerticalNavLink;
};
let open = ref([]);
let showMenubar = ref(true);

const openmenu = (title) => {
    localStorage.setItem("menu_title", title);
};
onMounted(() => {
    let title = localStorage.getItem("menu_title");
    route().current() == "dashboard"
        ? (open.value = ["Dashboard"])
        : (open.value = [title]);
    // localStorage.removeItem("menu_title");
});

// get site name
let drawer = ref(false);
let toggle = () => {
    drawer.value = !drawer.value;
};
let emit = defineEmits();

const openMenu = () => {
    emit("openMenu");
};
let props = defineProps({
    user_role: {
        type: String,
        required: true,
    },
});
let isStudent = ref(false);
let page = usePage().props;
const resolveHeaderComponent = () => {
    switch (props.user_role) {
        case "BC Super Admin":
            return Header;
        case "BC Subscriber":
            showMenubar.value = false;
            return BCTeacherHeader;
        case "B2B Parent":
            showMenubar.value = false;
            return ParentHeader;
        case "B2C Parent":
            showMenubar.value = false;
            return ParentHeader;
        case "Both Parent":
            showMenubar.value = false;
            return ParentHeader;
        case "Teacher":
            showMenubar.value = false;
            return B2BTeacherHeader;
        case "Student":
            showMenubar.value = false;
            isStudent.value = true;
            return StudentHeader;
        case "Organisation Admin":
            showMenubar.value = false;
            return OrgAdminHeader;
        default:
            return Header;
    }
    // showMenubar.value = false;
    // return StudentHeader;
};
</script>
<template>
    <v-layout :class="isStudent ? 'std-layout' : ''">
        <VNavigation-drawer v-model="drawer" style="position: fixed">
            <template v-slot:prepend>
                <Link to="/" class="d-flex align-center gap-x-2 pa-5">
                    <img
                        src="/images/sitelogotext.svg"
                        width="200"
                        height="200"
                    />
                    <!-- <img
                        :src="$page?.props?.site_logo"
                        width="40"
                        height="40"
                    />
                    <h1
                        class="font-weight-bold leading-normal text-truncate text-xl"
                    >
                        {{ $page?.props?.site_settings?.site_name }}
                    </h1> -->
                </Link>
            </template>

            <v-divider></v-divider>

            <v-list density="compact" nav v-model:opened="open">
                <Component
                    :is="resolveNavItemComponent(item)"
                    v-for="(item, index) in navItems"
                    :key="index"
                    :item="item"
                    @open_menu="openmenu"
                />
            </v-list>
        </VNavigation-drawer>

        <!-- <Header
            :site_data="$page.props"
            :is_drawer="true"
            @openDrawer="toggle"
        /> -->
        <Component
            :site_data="$page.props"
            style="position: fixed"
            :is="resolveHeaderComponent()"
            :is_drawer="drawer"
            @openMenu="openMenu()"
            @openDrawer="toggle"
        />

        <!-- 👉 Customizer -->
        <!-- <TheCustomizer /> -->
        <v-main style="min-height: 100vh">
            <v-container>
                <slot />
            </v-container>
        </v-main>
    </v-layout>
</template>

<style scoped>
.std-layout {
    background: url(/images/artbg.png) no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
}
</style>
