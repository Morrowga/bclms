<script setup>
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { themeConfig } from "@themeConfig";
import navItems from "@/navigation/horizontal";
import TheCustomizer from "@core/components/TheCustomizer.vue";
import VerticalNavLink from "@layouts/components/VerticalNavLink.vue";
import VerticalNavGroup from "@layouts/components/VerticalNavGroup.vue";
import Header from "@mainRoot/components/Header/Header.vue";
import Footer from "@mainRoot/components/Footer/Footer.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";
import { onMounted, ref, computed } from "vue";
const resolveNavItemComponent = (item) => {
    if ("children" in item) return VerticalNavGroup;

    return VerticalNavLink;
};
let open = ref([]);
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
let page = usePage().props;
</script>
<template>
    <v-layout>
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

        <Header
            :site_data="$page.props"
            :is_drawer="true"
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

<style scoped></style>
