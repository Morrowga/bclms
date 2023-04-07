<template>
  <v-list-group :value="item.title">
    <template v-slot:activator="{ props }">
      <v-list-item
        v-bind="props"
        :prepend-icon="item.icon.icon"
        :title="item.title"
        :class="isParentActive(item.children) ? 'bg-primary' : ''"
        :color="isParentActive(item.children) ? '#fff' : ''"
      ></v-list-item>
    </template>
    <v-list-item
      v-for="(sitem, sindex) in item.children"
      :key="sindex"
      :value="sitem.title"
      :title="sitem.title"
      @click="goLink(sitem.url)"
      :class="isLinkActive(sitem.route_name) ? 'active-list' : ''"
    ></v-list-item>
  </v-list-group>
</template>
<script setup>
import { router } from "@inertiajs/core";
defineProps(["item"]);
let isLinkActive = (currentRoute) => {
  return route().current().includes(currentRoute);
};
let isParentActive = (routeList) => {
  return routeList.find((item) => route().current().includes(item.route_name));
};
let goLink = (url) => {
  router.get(url);
};
</script>
<style scoped>
.active-list {
  background-color: #ededff !important;
  color: #666cff !important;
}
</style>