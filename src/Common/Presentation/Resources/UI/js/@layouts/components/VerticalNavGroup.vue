<template>
    <v-list-group :value="item.title">
        <template v-slot:activator="{ props }">
            <v-list-item
                v-if="
                    !auth?.data?.permissions?.includes(item?.access_module) &&
                    item?.access_module != 'access_dashboard'
                        ? false
                        : true
                "
                v-bind="props"
                :prepend-icon="item.icon.icon"
                :title="item.title"
                class="mx-2 text-none"
                :class="isParentActive(item.children) ? '' : ''"
                :color="isParentActive(item.children) ? '#4066E4' : '#282828'"
            ></v-list-item>
        </template>

        <v-list>
            <v-list-item
                v-for="(sitem, sindex) in filterItem"
                :key="sindex"
                :value="sitem"
                @click="goLink(sitem)"
                prepend-icon="mdi-circle-small"
                :variant="isLinkActive(sitem.route_name) ? 'tonal' : 'text'"
            >
                <v-list-item-title>{{ sitem.title }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-list-group>
</template>
<script setup>
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
import { defineEmits } from "vue";

const auth = computed(() => usePage().props.auth);
let props = defineProps(["item"]);
const emit = defineEmits(["open_menu"]);
let isLinkActive = (currentRoute) => {
    return route()?.current()?.includes(currentRoute);
};
const isParentActive = (routeList) => {
    return routeList.find((item) =>
        route()?.current()?.includes(item.route_name)
    );
};
const goLink = (pitem) => {
    emit("open_menu", pitem.title);
    if (pitem?.isNativeLink) {
        window.location.href = pitem.url;
    } else {
        router.get(pitem.url);
    }
};
// if (item?.isNativeLink) {
//     window.location.href = item.url;
// } else {
//     router.get(item.url);
// }
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
<style scoped lang="scss">
.active-list {
    background-color: #ededff !important;
    color: #666cff !important;
}
.v-list-group--prepend {
    --parent-padding: var(--indent-padding) !important;
}
</style>
