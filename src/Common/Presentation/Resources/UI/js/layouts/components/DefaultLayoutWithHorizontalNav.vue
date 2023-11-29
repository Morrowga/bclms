<script setup>
import navItems from "@/navigation/horizontal";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import { themeConfig } from "@themeConfig";
// Components
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarShortcuts from "@/layouts/components/NavbarShortcuts.vue";
// import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import NavSearchBar from "@/layouts/components/NavSearchBar.vue";
import HorizontalNavLayout from "@layouts/components/HorizontalNavLayout.vue";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import MobileSidebar from "./MobileSidebar.vue";
import Header from "@mainRoot/components/Header/Header.vue";
import BCTeacherHeader from "@mainRoot/components/BCTeacherHeader/BCTeacherHeader.vue";
import B2BTeacherHeader from "@mainRoot/components/B2BTeacherHeader/B2BTeacherHeader.vue";
import OrgAdminHeader from "@mainRoot/components/OrgAdminHeader/OrgAdminHeader.vue";
import StudentHeader from "@mainRoot/components/Student/StudentHeader.vue";
import ParentHeader from "@mainRoot/components/ParentHeader/ParentHeader.vue";
import Footer from "@mainRoot/components/Footer/Footer.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { HorizontalNav } from "@layouts/components";
import HorizontalMobileNav from "@layouts/components/HorizontalMobileNav.vue";
import MobileNavLink from "@mainRoot/components/MobileNavLink/MobileNavLink.vue";
import MobileGroupNavLink from "@mainRoot/components/MobileGroupNavLink/MobileGroupNavLink.vue";
import { serverParams } from "@Composables/useServerSideDatable.js";
// import HorizontalMobileNav from "./HorizontalMobileNav.vue";
// import HorizontalMobileNavLink from "./HorizontalMobileNavLink.vue";
// import HorizontalMobileNavGroup from "./HorizontalMobileNavGroup.vue";

const { appRouteTransition } = useThemeConfig();
import { ref, defineProps, computed, defineEmits } from "vue";

let drawer = ref(false);
let toggle = () => {
    drawer.value = !drawer.value;
};

let props = defineProps(["user_role"]);
let page = usePage();
let showMenubar = ref(true);
let text = ref("");
let emit = defineEmits();
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

const resolveNavItemComponent = (item) => {
    if ("children" in item) return MobileGroupNavLink;

    return MobileNavLink;
};
const siteImage = computed(() => page?.site_settings?.media[0]?.original_url);
const siteName = computed(() => page?.site_settings?.site_name);
const openMenu = () => {
    emit("openMenu");
};
onMounted(() => {
    serverParams.value.columnFilters = {};
    serverParams.value.search = "";
});
</script>
<template>
    <HorizontalNavLayout>
        <!-- :point_right: navbar -->
        <template #mobilenav>
            <HorizontalMobileNav>
                <VNavigation-drawer v-model="drawer" temporary>
                    <template v-slot:prepend>
                        <Link to="/" class="d-flex align-start gap-x-2 pa-5">
                            <img :src="siteImage" width="40" height="40" />
                            <h1
                                class="font-weight-bold leading-normal text-truncate text-xl"
                            >
                                {{ siteName }}
                            </h1>
                        </Link>
                    </template>

                    <v-divider></v-divider>

                    <v-list density="compact" nav>
                        <Component
                            :is="resolveNavItemComponent(item)"
                            v-for="(item, index) in navItems"
                            :key="index"
                            :item="item"
                        />
                    </v-list>
                </VNavigation-drawer>
            </HorizontalMobileNav>
        </template>
        <template #navbar>
            <Component
                :site_data="$page.props"
                style="position: fixed"
                :is="resolveHeaderComponent()"
                :is_drawer="drawer"
                @openMenu="openMenu()"
            />
        </template>
        <template #menubar v-if="showMenubar">
            <v-toolbar
                class="w-100 tb px-13 bg-navImage"
                style="
                    background-image: url('/images/defaults/tiggie_horizonal.png') !important;
                "
                elevation="1"
            >
                <HorizontalNav :nav-items="navItems" />
            </v-toolbar>
        </template>
        <template #padding v-if="showMenubar">
            <div
                class="d-none d-md-flex"
                style="padding-top: 5% !important"
            ></div>
        </template>
        <!-- :point_right: Pages -->
        <Transition :name="appRouteTransition" mode="out-in">
            <main>
                <slot> </slot>
            </main>
        </Transition>
        <!-- :point_right: Footer -->
        <template v-if="props.user_role !== 'Student'" #footer>
            <Footer />
        </template>
        <!-- :point_right: Customizer -->
        <!-- 👉 Customizer -->
        <!-- <TheCustomizer /> -->
    </HorizontalNavLayout>
</template>

<style scoped>
:deep(.v-toolbar__content) {
    justify-content: center;
}
</style>
