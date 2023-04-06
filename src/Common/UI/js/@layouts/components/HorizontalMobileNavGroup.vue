<template>
  <v-list-group :value="item.title">
    <template v-slot:activator="{ props }">
      <v-list-item
        v-bind="props"
        :prepend-icon="item.icon.icon"
        :title="item.title"
      ></v-list-item>
    </template>
    <v-list-item
      v-for="(sitem, sindex) in item.children"
      :key="sindex"
      :value="sitem.title"
      :title="sitem.title"
    ></v-list-item>
  </v-list-group>
</template>
<script setup>
defineProps(["item"]);
</script>
