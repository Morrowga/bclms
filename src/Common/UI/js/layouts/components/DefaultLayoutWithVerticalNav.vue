<script setup>
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { Link } from "@inertiajs/inertia-vue3";
import { themeConfig } from "@themeConfig";
import navItems from "@/navigation/horizontal";
import TheCustomizer from "@core/components/TheCustomizer.vue";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";
import VerticalNavGroup from "@layouts/components/VerticalNavGroup.vue";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
import NavbarShortcuts from "@/layouts/components/NavbarShortcuts.vue";
import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import NavSearchBar from "@/layouts/components/NavSearchBar.vue";
import UserProfile from "@/layouts/components/UserProfile.vue";
import { ref } from "vue";
const resolveNavItemComponent = (item) => {
  if ("children" in item) return VerticalNavGroup;

  return VerticalNavLink;
};
let drawer = ref(true);
const toggle = () => {
  drawer.value = !drawer.value;
};

let open = ref([]);
</script>
<template>
  <v-layout>
    <VNavigation-drawer v-model="drawer" style="position: fixed">
      <template v-slot:prepend>
        <Link to="/" class="d-flex align-start gap-x-2 pa-5">
          <VNodeRenderer :nodes="themeConfig.app.logo" />
          <h1 class="font-weight-bold leading-normal text-xl">
            {{ themeConfig.app.title }}
          </h1>
        </Link>
      </template>

      <v-divider></v-divider>

      <v-list density="compact" nav v-model:opened="open">
        <Component
          :is="resolveNavItemComponent(item)"
          v-for="(item, index) in navItems"
          :key="index"
          :item="item"
        />
      </v-list>
    </VNavigation-drawer>

    <v-app-bar>
      <v-app-bar-nav-icon
        variant="text"
        @click="toggle"
        class="d-flex d-md-none"
      ></v-app-bar-nav-icon>
      <VSpacer />
      <NavbarThemeSwitcher class="me-1" />
      <!-- <NavbarShortcuts class="me-1" /> -->
      <NavBarNotifications class="me-3" />
      <UserProfile class="pe-15" />
    </v-app-bar>

    <v-main style="min-height: 100vh">
      <v-container>
        <slot />
      </v-container>
    </v-main>
    <!-- 👉 Customizer -->
    <TheCustomizer />
  </v-layout>
</template>