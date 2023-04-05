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
import { HorizontalNavLayout } from "@layouts";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
const { appRouteTransition } = useThemeConfig();
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
  <HorizontalNavLayout :nav-items="navItems">
    <!-- :point_right: navbar -->
    <template #navbar>
      <v-app-bar class="px-4" elevation="0">
        <Link to="/" class="d-flex align-start gap-x-2">
          <VNodeRenderer :nodes="themeConfig.app.logo" />
          <h1 class="font-weight-bold leading-normal text-xl">
            {{ themeConfig.app.title }}
          </h1>
        </Link>
        <VSpacer />
        <NavSearchBar trigger-btn-class="ms-lg-n3" />
        <VSpacer />
        <NavbarThemeSwitcher class="me-1" />
        <NavbarShortcuts class="me-1" />
        <NavBarNotifications class="me-3" />
        <UserProfile />
      </v-app-bar>
    </template>
    <!-- :point_right: Pages -->
    <Transition :name="appRouteTransition" mode="out-in">
      <v-main class="" style="height: 600px">
        <slot> </slot>
      </v-main>
    </Transition>
    <!-- :point_right: Footer -->
    <template #footer>
      <Footer />
    </template>
    <!-- :point_right: Customizer -->
    <!-- <TheCustomizer /> -->
  </HorizontalNavLayout>
</template>