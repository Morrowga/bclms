<script setup>
import { useTheme } from "vuetify";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import { hexToRgb } from "@layouts/utils";
import { usePage } from "@inertiajs/vue3";
import {computed,onMounted} from "vue";

const {
    syncInitialLoaderTheme,
    syncVuetifyThemeWithTheme: syncConfigThemeWithVuetifyTheme,
    isAppRtl,
} = useThemeConfig();

const { global } = useTheme();


const page = usePage();
const site_themes = computed(() => page.props);
const site_theme = site_themes.value.system_themes


// set Site Theme to localstorage @harom284
localStorage.setItem("site_theme",JSON.stringify(site_themes.value));
// console.log(site_theme,"sddd")
localStorage.setItem("Blended Concept-skin","light");
localStorage.setItem("Blended Concept-theme","light");
// localStorage.setItem("Blended Concept-initial-loader-bg","dark");
// localStorage.setItem("Blended Concept-navbarBlur","dark");
// localStorage.setItem("Tiggie Kids-initial-loader-color","dark");
// localStorage.setItem("Blended Concept-contentWidth","dark");
// localStorage.setItem("Blended Concept-lightThemePrimaryColor","dark");
// localStorage.setItem("Blended Concept-isVerticalNavCollapsed","dark");
// ℹ️ Sync current theme with initial loader theme
syncInitialLoaderTheme();
syncConfigThemeWithVuetifyTheme();
</script>

<template>
    <VLocaleProvider :rtl="isAppRtl">
        <!-- ℹ️ This is required to set the background color of active nav link based on currently active global theme's primary -->
        <VApp
            :style="`--v-global-theme-primary: ${hexToRgb(
                global.current.value.colors.primary
            )}`">
            <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    <slot />
                </div>
            </div>
        </VApp>
    </VLocaleProvider>
</template>
