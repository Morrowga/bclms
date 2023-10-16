<script setup>
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";

const auth = computed(() => usePage().props.auth);
let props = defineProps(["item"]);
let isLinkActive = (currentRoute) => {
    return route()?.current()?.includes(currentRoute);
};
let isParentActive = (routeList) => {
    return routeList?.find((item) =>
        route()?.current()?.includes(item.route_name)
    );
};
let goLink = (item) => {
    if (item?.isNativeLink) {
        window.location.href = item.url;
    } else {
        router.get(item.url);
    }
};
const filterItem = computed(() =>
    props.item.children.filter((sitem) => {
        if (
            !auth?.value?.data?.permissions?.includes(sitem?.access_module) &&
            props.item?.access_module != "access_dashboard"
        ) {
            return false;
        }
        return true;
    })
);
</script>
<template>
    <v-list-group :value="item.title">
        <template v-slot:activator="{ props }">
            <v-list-item
                v-bind="props"
                :prepend-icon="item.icon.icon"
                :title="item.title"
                :class="isParentActive(item.children) ? 'bg-primary' : ''"
                :color="isParentActive(item.children) ? '#fff' : ''"
                v-if="
                    !auth?.data?.permissions?.includes(item?.access_module) &&
                    item?.access_module != 'access_dashboard'
                        ? false
                        : true
                "
            ></v-list-item>
        </template>
        <v-list-item
            v-for="(sitem, sindex) in filterItem"
            :key="sindex"
            :value="sitem.title"
            @click="goLink(sitem)"
            :class="isLinkActive(sitem.route_name) ? 'active-list' : ''"
        >
            <v-list-item-title>
                {{ sitem.title }}
            </v-list-item-title>
        </v-list-item>
    </v-list-group>
</template>

<style scoped>
.active-list {
    background-color: #ededff !important;
    color: #666cff !important;
}
</style>
