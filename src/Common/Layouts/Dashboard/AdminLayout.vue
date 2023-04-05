
<template>
  <AppLayout>
    <template v-if="appContentLayoutNav !== AppContentLayoutNav.Vertical">
      <DefaultLayoutWithVerticalNav v-bind="layoutAttrs">
        <slot />
      </DefaultLayoutWithVerticalNav>
    </template>
    <template v-else>
      <DefaultLayoutWithHorizontalNav v-bind="layoutAttrs">
        <slot />
      </DefaultLayoutWithHorizontalNav>
    </template>
  </AppLayout>
</template>
<script setup>
import { useSkins } from "@core/composable/useSkins";
import { useThemeConfig } from "@core/composable/useThemeConfig";
import AppLayout from "@AppRoot/AppLayout.vue";

// @layouts plugin
import { AppContentLayoutNav } from "@layouts/enums";

const DefaultLayoutWithHorizontalNav = defineAsyncComponent(() =>
  import("@/layouts/components/DefaultLayoutWithHorizontalNav.vue")
);
const DefaultLayoutWithVerticalNav = defineAsyncComponent(() =>
  import("@layouts/components/DefaultLayoutWithVerticalNav.vue")
);
const { width: windowWidth } = useWindowSize();
const { appContentLayoutNav, switchToVerticalNavOnLtOverlayNavBreakpoint } =
  useThemeConfig();

// Remove below composable usage if you are not using horizontal nav layout in your app
switchToVerticalNavOnLtOverlayNavBreakpoint(windowWidth);

const { layoutAttrs, injectSkinClasses } = useSkins();

injectSkinClasses();
</script>
<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";
</style>
