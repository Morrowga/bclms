<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import { useTheme } from "vuetify";
import { staticPrimaryColor } from "@/plugins/vuetify/theme";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import { RouteTransitions, Skins } from "@core/enums";
import { SuccessDialog } from "@actions/useSuccess";

import {
    AppContentLayoutNav,
    ContentWidth,
    FooterType,
    NavbarType,
} from "@layouts/enums";
import { themeConfig } from "@themeConfig";

const isNavDrawerOpen = ref(false);
const {
    theme,
    skin,
    appRouteTransition,
    navbarType,
    footerType,
    isVerticalNavCollapsed,
    isVerticalNavSemiDark,
    appContentWidth,
    appContentLayoutNav,
    isAppRtl,
    isNavbarBlurEnabled,
    isLessThanOverlayNavBreakpoint,
} = useThemeConfig();

// 👉 Primary Color
const vuetifyTheme = useTheme();

// const vuetifyThemesName = Object.keys(vuetifyTheme.themes.value)
const initialThemeColors = JSON.parse(
    JSON.stringify(vuetifyTheme.current.value.colors)
);

const colors = ["primary", "secondary", "success", "info", "warning", "error"];

const secondaryColors = [
    "#FF8015",
    "#FDE0CC",
    "#D7DDF2",
    "#F7BFC1",
    "#D7F2F0",
    "#FFF2CE",
    "#BFC0C1",
];

const setPrimaryColor = (color) => {
    const currentThemeName = vuetifyTheme.name.value;

    vuetifyTheme.themes.value[currentThemeName].colors.primary = color;
    localStorage.setItem(
        `${themeConfig.app.title}-${currentThemeName}ThemePrimaryColor`,
        color
    );
    localStorage.setItem(
        `${themeConfig.app.title}-initial-loader-color`,
        color
    );
};

const getBoxColor = (color, index) => (index ? color : staticPrimaryColor);
const { width: windowWidth } = useWindowSize();

const headerValues = computed(() => {
    const entries = Object.entries(NavbarType);
    if (appContentLayoutNav.value === AppContentLayoutNav.Horizontal)
        return entries.filter(([_, val]) => val !== NavbarType.Hidden);

    return entries;
});
const updateTheme = () => {
    SuccessDialog({
        title: "You have successfully updated site theme",
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="12">
                    <h1 class="tiggie-title fs-46 mb-5">Theme Customizer</h1>
                    <p class="tiggie-sub-subtitle">
                        Customize the theme for users
                    </p>
                </VCol>
                <VCol cols="6">
                    <CustomizerSection title="Theming" :divider="false">
                        <!-- 👉 Skin -->
                        <h6 class="tiggie-text fw-500">Skins</h6>
                        <VRadioGroup v-model="skin" inline>
                            <VRadio
                                v-for="[key, val] in Object.entries(Skins)"
                                :key="key"
                                :label="key"
                                :value="val"
                            />
                        </VRadioGroup>

                        <!-- 👉 Theme -->
                        <h6 class="mt-3 tiggie-text">Theme</h6>
                        <VRadioGroup v-model="theme" inline>
                            <VRadio
                                v-for="themeOption in [
                                    'system',
                                    'light',
                                    'dark',
                                ]"
                                :key="themeOption"
                                :label="themeOption"
                                :value="themeOption"
                                class="text-capitalize"
                            />
                        </VRadioGroup>

                        <!-- 👉 Primary color -->
                        <h6 class="mt-3 tiggie-text">Primary Color</h6>
                        <div class="d-flex gap-x-4 mt-2">
                            <div
                                v-for="(color, index) in colors"
                                :key="color"
                                style="
                                    width: 2.5rem;
                                    height: 2.5rem;
                                    border-radius: 0.5rem;
                                    transition: all 0.25s ease;
                                "
                                :style="{
                                    backgroundColor: getBoxColor(
                                        initialThemeColors[color],
                                        index
                                    ),
                                }"
                                class="cursor-pointer d-flex align-center justify-center"
                                :class="{
                                    'elevation-4':
                                        vuetifyTheme.current.value.colors
                                            .primary ===
                                        getBoxColor(
                                            initialThemeColors[color],
                                            index
                                        ),
                                }"
                                @click="
                                    setPrimaryColor(
                                        getBoxColor(
                                            initialThemeColors[color],
                                            index
                                        )
                                    )
                                "
                            >
                                <VFadeTransition>
                                    <VIcon
                                        v-show="
                                            vuetifyTheme.current.value.colors
                                                .primary ===
                                            getBoxColor(
                                                initialThemeColors[color],
                                                index
                                            )
                                        "
                                        icon="mdi-check"
                                        color="white"
                                    />
                                </VFadeTransition>
                            </div>
                        </div>
                        <h6 class="mt-3 tiggie-text">Secondary Color</h6>
                        <div class="d-flex gap-x-4 mt-2">
                            <div
                                v-for="(color, index) in secondaryColors"
                                :key="color"
                                style="
                                    width: 2.5rem;
                                    height: 2.5rem;
                                    border-radius: 0.5rem;
                                    transition: all 0.25s ease;
                                "
                                :style="{
                                    backgroundColor: color,
                                }"
                                class="cursor-pointer d-flex align-center justify-center"
                                :class="{
                                    'elevation-4':
                                        vuetifyTheme.current.value.colors
                                            .primary ===
                                        getBoxColor(
                                            initialThemeColors[color],
                                            index
                                        ),
                                }"
                                @click="
                                    setPrimaryColor(
                                        getBoxColor(
                                            initialThemeColors[color],
                                            index
                                        )
                                    )
                                "
                            >
                                <VFadeTransition>
                                    <VIcon
                                        v-show="
                                            vuetifyTheme.current.value.colors
                                                .primary ===
                                            getBoxColor(
                                                initialThemeColors[color],
                                                index
                                            )
                                        "
                                        icon="mdi-check"
                                        color="white"
                                    />
                                </VFadeTransition>
                            </div>
                        </div>
                    </CustomizerSection>
                </VCol>
                <VCol cols="6">
                    <CustomizerSection title="Layout">
                        <!-- 👉 Content Width -->
                        <h6 class="text-base tiggie-text">Content width</h6>
                        <VRadioGroup v-model="appContentWidth" inline>
                            <VRadio
                                v-for="[key, val] in Object.entries(
                                    ContentWidth
                                )"
                                :key="key"
                                :label="key"
                                :value="val"
                            />
                        </VRadioGroup>
                        <!-- 👉 Navbar Type -->
                        <h6 class="mt-3 tiggie-text">
                            {{
                                appContentLayoutNav ===
                                AppContentLayoutNav.Vertical
                                    ? "Navbar"
                                    : "Header"
                            }}
                            Type
                        </h6>
                        <VRadioGroup v-model="navbarType" inline>
                            <VRadio
                                v-for="[key, val] in headerValues"
                                :key="key"
                                :label="key"
                                :value="val"
                            />
                        </VRadioGroup>
                        <!-- 👉 Footer Type -->
                        <h6 class="mt-3 tiggie-text">Footer Type</h6>
                        <VRadioGroup v-model="footerType" inline>
                            <VRadio
                                v-for="[key, val] in Object.entries(FooterType)"
                                :key="key"
                                :label="key"
                                :value="val"
                            />
                        </VRadioGroup>
                        <!-- 👉 Navbar blur -->
                        <div class="d-flex align-center justify-space-between">
                            <VLabel
                                for="customizer-navbar-blur"
                                class="text-high-emphasis"
                            >
                                Navbar Blur
                            </VLabel>
                            <div>
                                <VSwitch
                                    id="customizer-navbar-blur"
                                    v-model="isNavbarBlurEnabled"
                                    class="ms-2"
                                />
                            </div>
                        </div>
                    </CustomizerSection>
                    <CustomizerSection title="Menu">
                        <!-- 👉 Menu Type -->
                        <h6 class="text-base tiggie-text">Menu Type</h6>
                        <VRadioGroup v-model="appContentLayoutNav" inline>
                            <VRadio
                                v-for="[key, val] in Object.entries(
                                    AppContentLayoutNav
                                )"
                                :key="key"
                                :label="key"
                                :value="val"
                            />
                        </VRadioGroup>
                    </CustomizerSection>
                    <CustomizerSection title="Misc">
                        <!-- 👉 RTL -->
                        <div class="d-flex align-center justify-space-between">
                            <VLabel
                                for="customizer-rtl"
                                class="text-high-emphasis"
                            >
                                RTL
                            </VLabel>
                            <div>
                                <VSwitch
                                    id="customizer-rtl"
                                    v-model="isAppRtl"
                                    class="ms-2"
                                />
                            </div>
                        </div>
                    </CustomizerSection>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4" justify="center" class="ml-2">
                    <VBtn
                        type="button"
                        @click="updateTheme()"
                        class="tiggie-btn text-white"
                        height="50"
                        width="200"
                    >
                        Set Theme
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style lang="scss">
.app-customizer {
    .customizer-section {
        padding: 1.25rem;
    }

    .customizer-heading {
        padding-block: 0.875rem;
        padding-inline: 1.25rem;
    }

    .v-navigation-drawer__content {
        display: flex;
        flex-direction: column;
    }
}

.app-customizer-toggler {
    position: fixed !important;
    inset-block-start: 50%;
    inset-inline-end: 0;
    transform: translateY(-50%);
}

.subheader-theme {
    color: #282828 !important;
    // font-family: PP Pangram Sans;
    font-size: 32px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important;
    /* 131.25% */
}

.fs-46 {
    font-size: 46px !important;
}

.tiggie-text {
    color: #001a8f !important;
    // font-family: PP Pangram Sans;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 32px !important;
    /* 160% */
}

.fw-700 {
    font-weight: 700 !important;
    line-height: 32px !important;
    /* 160% */
}
</style>
