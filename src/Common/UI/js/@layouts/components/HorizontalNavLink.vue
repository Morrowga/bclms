<script setup>
// import { useLayouts } from "@layouts";
import { config } from "@layouts/config";
import { Link } from "@inertiajs/inertia-vue3";
import { router } from "@inertiajs/core";

// import { can } from "@layouts/plugins/casl";
// import { getComputedNavLinkToProp, isNavLinkActive } from "@layouts/utils";

const props = defineProps({
  item: {
    type: null,
    required: true,
  },
  isSubItem: {
    type: Boolean,
    required: false,
    default: false,
  },
});

// const { dynamicI18nProps } = useLayouts();
let isLinkActive = (currentRoute) => {
  return route().current().includes(currentRoute);
};
let goLink = (url) => {
  router.get(url);
};
</script>

<template>
  <v-btn
    variant="text"
    :prepend-icon="item.icon.icon"
    class="mx-2"
    :class="isLinkActive(item.route_name) ? 'bg-primary' : ''"
    :color="isLinkActive(item.route_name) ? '#fff' : ''"
    @click="goLink(item.url)"
  >
    <span :style="isLinkActive(item.route_name) ? 'color: #fff' : 'color:#000'">
      {{ item.title }}
    </span>
  </v-btn>
</template>

<style lang="scss">
.layout-horizontal-nav {
  .nav-link a {
    display: flex;
    align-items: center;
  }
}
</style>
