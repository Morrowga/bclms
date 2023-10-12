<script setup>
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";

const props = defineProps({
    item: {
        type: null,
        required: true,
    },
    childrenAtEnd: {
        type: Boolean,
        required: false,
        default: false,
    },
    isSubItem: {
        type: Boolean,
        required: false,
        default: false,
    },
});

defineOptions({ name: "HorizontalNavGroup" });

const auth = computed(() => usePage().props.auth);

const isGroupActive = ref(false);
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

// let hiddenByPermission = (sitem, item) => {
//     !auth?.value?.data?.permissions?.includes(sitem?.access_module) &&
//     item?.access_module != "access_dashboard"
//         ? true
//         : false;
// };
// let hiddenByPermissionOne = (item) => {
//     !auth?.value?.data?.permissions?.includes(item?.access_module) &&
//     item?.access_module != "access_dashboard"
//         ? true
//         : false;
// };
</script>

<template>
    <div class="text-center">
        <v-menu open-on-hover>
            <template v-slot:activator="{ props }">
                <v-list-item
                    v-bind="props"
                    :prepend-icon="item.icon.icon"
                    append-icon="mdi-chevron-down"
                    :title="item.title"
                    class="mx-2 text-none"
                    :class="isParentActive(item.children) ? '' : ''"
                    :color="
                        isParentActive(item.children) ? '#4066E4' : '#282828'
                    "
                    v-if="
                        !auth?.data?.permissions?.includes(
                            item?.access_module
                        ) && item?.access_module != 'access_dashboard'
                            ? false
                            : true
                    "
                >
                </v-list-item>
            </template>

            <v-list density="compact">
                <v-list-item
                    v-for="(sitem, sindex) in item.children"
                    :key="sindex"
                    :value="sitem"
                    @click="goLink(sitem)"
                    :variant="isLinkActive(sitem.route_name) ? 'tonal' : 'text'"
                    v-if="
                        !auth?.data?.permissions?.includes(
                            sitem?.access_module
                        ) && item?.access_module != 'access_dashboard'
                            ? false
                            : true
                    "
                >
                    <template v-slot:prepend>
                        <v-icon icon="mdi-circle-small"></v-icon>
                    </template>
                    <v-list-item-title>{{ sitem.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<style lang="scss">
.active-list {
    background-color: #ededff !important;
    color: #666cff !important;
}

.v-list-group--prepend {
    --parent-padding: var(--indent-padding) !important;
}
.layout-horizontal-nav {
    .nav-group {
        .nav-group-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .popper-content {
            z-index: 1;

            > div {
                overflow-x: hidden;
                overflow-y: auto;
            }
        }
    }
}
.bg-primary {
    background-color: red !important;
}
</style>
