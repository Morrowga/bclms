<script setup>
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
const auth = computed(() => usePage().props.auth);
let props = defineProps(["item"]);
let isLinkActive = (currentRoute) => {
    return route()?.current()?.includes(currentRoute);
};
let goLink = (url) => {
    router.get(url);
};
</script>
<template>
    <v-list-item
        :prepend-icon="item.icon.icon"
        :title="item.title"
        :value="item.title"
        :class="isLinkActive(item.route_name) ? 'bg-primary' : ''"
        :color="isLinkActive(item.route_name) ? '#fff' : ''"
        @click="goLink(item.url)"
        v-if="
            !auth?.data?.permissions?.includes(item?.access_module) &&
            item?.access_module != 'access_dashboard'
                ? false
                : true
        "
    ></v-list-item>
</template>
