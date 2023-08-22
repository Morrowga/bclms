<script setup>

import BcDropDownMenu from "@mainRoot/components/BCDropDownMenu/BCDropDownMenu.vue";
import NavMenuItem from "@mainRoot/components/NavMenuItems/NavMenuItem.vue";
import StudentNavMenuItem from "@mainRoot/components/StudentNavMenu/StudentNavMenuItem.vue";

const props = defineProps({
    navItems: {
        type: null,
        required: true,
    },
    current_user_role: {
        type: String,
        required: false,
    },
});

const resolveNavItemComponentStudent = (item) => {
    if ("children" in item) return BcDropDownMenu;

    return StudentNavMenuItem;
}
</script>

<template>
    <Component
    :is="resolveNavItemComponentStudent(item)"
    v-for="(item, index) in navItems"
    :key="index"
    :item="item"
    />
</template>

<style lang="scss">
.nav-items {
    display: flex;
    flex-wrap: wrap;
}
</style>
