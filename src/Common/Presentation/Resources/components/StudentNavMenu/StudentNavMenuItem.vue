<script setup>
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";

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

const auth = computed(() => usePage().props.auth);
let isLinkActive = (currentRoute) => {
    return route()?.current()?.includes(currentRoute);
};
let goLink = (url) => {
    router.get(url);
};

// let hiddenByPermission = (item) => {
//     return !auth?.value?.data?.permissions?.includes(item?.access_module) &&
//         item?.access_module != "access_dashboard"
//         ? true
//         : false;
// };
</script>

<template>
    <v-btn
        variant="text"
        class="mx-2 text-none tiggie-menu-item-font-size"
        :class="isLinkActive(item.route_name) ? '' : ''"
        :color="isLinkActive(item.route_name) ? '' : ''"
        @click="goLink(item.url)"
        v-if="
            !auth?.data?.permissions?.includes(item?.access_module) &&
            item?.access_module != 'access_dashboard'
                ? false
                : true
        "
    >
        <v-icon
            :icon="item.icon.icon"
            class="ma-2"
            :color="isLinkActive(item.route_name) ? '#FF8015' : '#fff'"
        ></v-icon>
        <span
            class="ruddy-bold"
            :style="
                isLinkActive(item.route_name) ? 'color: #FF8015' : 'color:#fff'
            "
        >
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
