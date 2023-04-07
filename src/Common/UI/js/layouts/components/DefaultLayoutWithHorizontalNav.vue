<script setup>
import navItems from "@/navigation/horizontal";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import { themeConfig } from "@themeConfig";
// Components
import Footer from "@/layouts/components/Footer.vue";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarShortcuts from "@/layouts/components/NavbarShortcuts.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import NavSearchBar from "@/layouts/components/NavSearchBar.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";
import HorizontalNavLayout from "@layouts/components/HorizontalNavLayout.vue";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import MobileSidebar from "./MobileSidebar.vue";
const { appRouteTransition } = useThemeConfig();
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
let drawer = ref(false);
let toggle = () => {
  drawer.value = !drawer.value;
};
</script>
<template>
  <HorizontalNavLayout :nav-items="navItems" :drawer="drawer">
    <!-- :point_right: navbar -->
    <template #navbar>
      <v-app-bar elevation="0">
        <!-- mobile side navigation -->
        <v-app-bar-nav-icon
          variant="text"
          @click="toggle"
          class="d-flex d-md-none"
        ></v-app-bar-nav-icon>

        <Link to="/" class="d-none d-md-flex align-start gap-x-2 ps-15">
          <VNodeRenderer :nodes="themeConfig.app.logo" />
          <h1 class="font-weight-bold leading-normal text-xl">
            {{ themeConfig.app.title }}
          </h1>
        </Link>
        <VSpacer class="d-none d-md-flex" />
        <NavSearchBar trigger-btn-class="ms-lg-n3" />
        <VSpacer />
        <NavbarThemeSwitcher class="me-1" />
        <NavbarShortcuts class="me-1" />
        <NavBarNotifications class="me-3" />
        <UserProfile class="d-none d-md-flex pe-15" />
        <UserProfile class="d-flex d-md-none pe-3" />
      </v-app-bar>
    </template>
    <!-- :point_right: Pages -->
    <Transition :name="appRouteTransition" mode="out-in">
      <main class="">
        <slot> </slot>
      </main>
    </Transition>
    <!-- :point_right: Footer -->
    <template #footer>
      <Footer />
    </template>
    <!-- :point_right: Customizer -->
    <!-- <TheCustomizer /> -->
  </HorizontalNavLayout>
</template>
