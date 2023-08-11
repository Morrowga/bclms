<script setup>
import BcDropDownMenu from "@mainRoot/components/BCDropDownMenu/BCDropDownMenu.vue";
import NavMenuItem from "@mainRoot/components/NavMenuItems/NavMenuItem.vue";

const props = defineProps({
    navItems: {
        type: null,
        required: true,
    },
});
const resolveNavItemComponent = (item) => {
    if ("children" in item) return BcDropDownMenu;

    return NavMenuItem;
};
</script>

<template>
    <Component
        :is="resolveNavItemComponent(item)"
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
