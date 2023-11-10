<script setup>
import { useSkins } from "@core/composable/useSkins";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import AppLayout from "./AppLayout.vue";

// @layouts plugin
import { AppContentLayoutNav } from "@layouts/enums";

import DefaultLayoutWithHorizontalNav from "@/layouts/components/DefaultLayoutWithHorizontalNav.vue";
import DefaultLayoutWithVerticalNav from "@/layouts/components/DefaultLayoutWithVerticalNav.vue";
import { Link, usePage } from "@inertiajs/vue3";
import axios from "axios";

const { width: windowWidth } = useWindowSize();
const { appContentLayoutNav, switchToVerticalNavOnLtOverlayNavBreakpoint } =
    useThemeConfig();

// Remove below composable usage if you are not using horizontal nav layout in your app
switchToVerticalNavOnLtOverlayNavBreakpoint(windowWidth);

const { layoutAttrs, injectSkinClasses } = useSkins();

injectSkinClasses();

let props = defineProps(["user"]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let emit = defineEmits();
const openMenu = () => {
    emit("openMenu");
};
// function forceLandscape() {
//     var myScreenOrientation = window.screen.orientation;
//     if (myScreenOrientation && myScreenOrientation.lock) {
//         myScreenOrientation.type.startsWith("portrait")
//             ? myScreenOrientation.lock("landscape-primary")
//             : "";
//     }
// }
const lockScreenOrientation = async () => {
    try {
        await document.documentElement.requestFullscreen();
        await screen.orientation.lock("landscape-primary");
        console.log("Orientation locked successfully");
    } catch (error) {
        console.error("Failed to lock orientation:", error);
    }
};

onMounted(() => {
    lockScreenOrientation();
});
</script>
<template>
    <AppLayout class="student">
        <template v-if="appContentLayoutNav === AppContentLayoutNav.Vertical">
            <DefaultLayoutWithVerticalNav
                v-bind="layoutAttrs"
                :user_role="user_role"
                @openMenu="openMenu()"
            >
                <slot />
            </DefaultLayoutWithVerticalNav>
        </template>
        <template v-else>
            <DefaultLayoutWithHorizontalNav
                v-bind="layoutAttrs"
                :user_role="user_role"
                @openMenu="openMenu()"
            >
                <slot />
            </DefaultLayoutWithHorizontalNav>
        </template>
    </AppLayout>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";

.student .layout-page-content {
    background: url("/images/artbg.png") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
}
.student .layout-footer {
    display: none !important;
}
</style>
