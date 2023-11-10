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
const openMenu = () => {
    emit("openMenu");
};

onMounted(() => {
    var myScreenOrientation = screen.orientation;
    if (myScreenOrientation.type.startsWith("portrait")) {
        openDialog.value = true;
    } else {
        openDialog.value = false;
    }
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
