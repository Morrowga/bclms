<script setup>
import navItems from "@/navigation/horizontal";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import TheCustomizer from "@core/components/TheCustomizer.vue";
import { themeConfig } from "@themeConfig";
// Components
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarShortcuts from "@/layouts/components/NavbarShortcuts.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import NavSearchBar from "@/layouts/components/NavSearchBar.vue";
import HorizontalNavLayout from "@layouts/components/HorizontalNavLayout.vue";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import MobileSidebar from "./MobileSidebar.vue";
import Header from "@mainRoot/components/Header/Header.vue";
import BCTeacherHeader from "@mainRoot/components/BCTeacherHeader/BCTeacherHeader.vue";
import B2BTeacherHeader from "@mainRoot/components/B2BTeacherHeader/B2BTeacherHeader.vue";
import Footer from "@mainRoot/components/Footer/Footer.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { HorizontalNav } from "@layouts/components";
import HorizontalMobileNav from "@layouts/components/HorizontalMobileNav.vue";
import MobileNavLink from "@mainRoot/components/MobileNavLink/MobileNavLink.vue";
import MobileGroupNavLink from "@mainRoot/components/MobileGroupNavLink/MobileGroupNavLink.vue";

// import HorizontalMobileNav from "./HorizontalMobileNav.vue";
// import HorizontalMobileNavLink from "./HorizontalMobileNavLink.vue";
// import HorizontalMobileNavGroup from "./HorizontalMobileNavGroup.vue";

const { appRouteTransition } = useThemeConfig();
import { ref, defineProps, computed } from "vue";

let drawer = ref(false);
let toggle = () => {
    drawer.value = !drawer.value;
};
let props = defineProps(["user_role"]);
let page = usePage();
let showMenubar = ref(true);
let text = ref("");
const resolveHeaderComponent = () => {
    switch (props.user_role) {
        case "BC Super Admin":
            return Header;
        case "BC Subscriber":
            showMenubar.value = false;
            return BCTeacherHeader;
        case "Teacher":
            showMenubar.value = false;
            return B2BTeacherHeader;
        default:
            return Header;
    }
};
const resolveNavItemComponent = (item) => {
    if ("children" in item) return MobileGroupNavLink;

    return MobileNavLink;
};
const siteImage = computed(() => page?.site_settings?.media[0]?.original_url);
const siteName = computed(() => page?.site_settings?.site_name);
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
            <main class="" style="min-height: 485px">
                <slot> </slot>
            </main>
        </Transition>
        <!-- :point_right: Footer -->
        <template #footer>
            <Footer />
        </template>
        <!-- :point_right: Customizer -->
        <!-- 👉 Customizer -->
        <TheCustomizer />
    </HorizontalNavLayout>
</template>
