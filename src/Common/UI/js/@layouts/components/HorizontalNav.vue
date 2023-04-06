<script setup>
import HorizontalNavGroup from "@layouts/components/HorizontalNavGroup.vue";
import HorizontalNavLink from "@layouts/components/HorizontalNavLink.vue";

const props = defineProps({
  navItems: {
    type: null,
    required: true,
  },
});
const resolveNavItemComponent = (item) => {
  if ("children" in item) return HorizontalNavGroup;

  return HorizontalNavLink;
};
</script>

<template>
  <v-app-bar
    class="px-10"
    elevation="1"
    style="border-top: 2px solid rgba(0, 0, 0, 0.053)"
  >
    <Component
      :is="resolveNavItemComponent(item)"
      v-for="(item, index) in navItems"
      :key="index"
      :item="item"
    />
  </v-app-bar>
</template>

<style lang="scss">
.nav-items {
  display: flex;
  flex-wrap: wrap;
}
</style>
