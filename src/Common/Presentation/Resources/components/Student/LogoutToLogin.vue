<script setup>
import { initialAbility } from "@/plugins/casl/ability";
import { useAppAbility } from "@/plugins/casl/useAppAbility";
import { usePage, Link } from "@inertiajs/vue3";
import { computed, defineEmits } from "vue";
import { router } from "@inertiajs/core";
const ability = useAppAbility();
const userData = computed(() => usePage().props.auth);
// console.log(userData);
// const logout = () => {
//     const PREFIX =
//         localStorage.getItem("tenant") != ""
//             ? `/${localStorage.getItem("tenant")}`
//             : "";
//     localStorage.removeItem("menu_title");
//     router.post(`${PREFIX}/logout`);
// };
const emit = defineEmits();
const logout = () => {
    router.post("/logout");
};

</script>

<template>
    <VAvatar
        @click="logout"
        class="cursor-pointer studentpro mr-5"
        color="primary"
        variant="tonal"
    >
        <VIcon icon="mdi-power" class="studenticon" />
    </VAvatar>
</template>

<style scoped>
.my-menu {
    margin-top: 0;
    contain: initial;
    overflow: visible;
}

.studenticon {
    color: #fff;
}

.studentpro {
    background: #ff6162;
}
.my-menu::before {
    position: fixed;
    content: "";
    top: 0;
    right: 10px;
    transform: translateY(-100%);
    width: 10px;
    height: 13px;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 13px solid rgb(var(--v-theme-surface));
}
.menu-profile {
    position: relative;
}
</style>
