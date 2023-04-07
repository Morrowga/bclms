<template>
  <v-list-item
    :prepend-icon="item.icon.icon"
    :title="item.title"
    :value="item.title"
    :class="isLinkActive(item.route_name) ? 'bg-primary' : ''"
    :color="isLinkActive(item.route_name) ? '#fff' : ''"
    @click="goLink(item.url)"
  ></v-list-item>
</template>
<script setup>
import { router } from "@inertiajs/core";
defineProps(["item"]);
let isLinkActive = (currentRoute) => {
  return route().current().includes(currentRoute);
};
let goLink = (url) => {
  router.get(url);
};
</script>