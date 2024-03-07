<script setup>
import { useSkins } from "@core/composable/useSkins";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import FullScreenComponent from "./FullScreenComponent.vue";
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
let openDialog = ref(false);
let disableNav = ref(false);
const openMenu = () => {
    emit("openMenu");
};
let current_route_name = route().current();

const handleOrientationChange = () => {
    if (isPortrait()) {
        openDialog.value = true;
    } else {
        openDialog.value = false;
    }
};

const isPortrait = () => {
    // Check whether the screen is in portrait mode
    return window.innerHeight > window.innerWidth;
};

onMounted(() => {
    // Initial check for orientation
    handleOrientationChange();

    // Add an event listener for orientation change
    window.addEventListener("resize", handleOrientationChange);
});

onUnmounted(() => {
    // Remove the event listener when the component is unmounted
    window.removeEventListener("resize", handleOrientationChange);
});
</script>
<template>
    <AppLayout class="student">
        <FullScreenComponent
            @close_orientation="openDialog = false"
            :openDialog="openDialog"
        />
        <template v-if="appContentLayoutNav === AppContentLayoutNav.Vertical">
            <DefaultLayoutWithVerticalNav
                v-bind="layoutAttrs"
                :user_role="user_role"
                @openMenu="openMenu()"
            >
                <div
                    class="reward-bg"
                    v-if="current_route_name == 'student-rewards'"
                >
                    <slot />
                </div>
                <div v-else>
                    <slot />
                </div>
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
    padding: 0 !important;
    background: url("/images/studentbg.webp") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
    // min-height: 92.1vh !important;
    overflow: hidden !important;
}
.student .layout-footer {
    display: none !important;
}
.reward-bg {
    background: url("/images/rewardbg2.png") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 64px;
    overflow: hidden;
}
</style>
