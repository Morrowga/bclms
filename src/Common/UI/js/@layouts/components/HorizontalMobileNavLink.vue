<template>
  <v-list-item
    :prepend-icon="item.icon.icon"
    :title="item.title"
    :value="item.title"
  ></v-list-item>
</template>
<script setup>
defineProps(["item"]);
</script>