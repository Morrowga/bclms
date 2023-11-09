<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import NavBarNotifications from "@/layouts/components/NavBarNotifications.vue";
// import NavbarThemeSwitcher from "@/layouts/components/NavbarThemeSwitcher.vue";
import UserProfile from "@mainRoot/components/UserProfile/UserProfile.vue";

import { HorizontalNav } from "@layouts/components";
import navItems from "@/navigation/horizontal";

let props = defineProps({
    site_data: {
        type: Object,
        default: null,
    },
    is_drawer: {
        type: Boolean,
        default: false,
    },
});
let emit = defineEmits();
let organisation = ref("");
let page = usePage();
let toggle = () => {
    emit("openDrawer");
};
onMounted(() => {
    organisation.value = page.props.user_info?.user_detail?.organisation_id
        ? true
        : false;
});
</script>
<template>
    <v-app-bar elevation="0">
        <!-- mobile side navigation -->
        <div class="left-padd d-none d-lg-flex"></div>

        <v-app-bar-nav-icon
            variant="text"
            @click="toggle"
            class="d-flex d-lg-none"
        ></v-app-bar-nav-icon>

        <Link
            v-if="!is_drawer"
            href="/home"
            class="d-none d-lg-flex align-center"
        >
            <v-img
                v-if="organisation"
                src="/images/logoschool.png"
                width="200"
                height="200"
            />
            <v-img v-else src="/images/logohome.png" width="200" height="200" />
        </Link>
        <VSpacer />
        <div class="d-none d-lg-flex">
            <HorizontalNav :nav-items="navItems" />
        </div>

        <VSpacer />
        <Link :href="route('techsupports')" class="align-center">
            <VBtn icon color="secondary">
                <v-icon style="font-size: 23px !important"
                    >mdi-chat-question-outline</v-icon
                >
            </VBtn>
        </Link>
        <NavBarNotifications class="me-3" />

        <UserProfile v-if="!is_drawer" class="d-none d-md-flex pe-3" />

        <UserProfile v-if="!is_drawer" class="d-flex d-md-none pe-3" />

        <UserProfile v-if="is_drawer" class="d-flex pe-3" />
        <div class="right-padd d-none d-lg-flex"></div>
    </v-app-bar>
</template>
<style scoped>
.character-img img {
    object-fit: contain;
    height: 62px;
    margin-top: 11px;
}
.app-bar-style-bc-padd {
    padding: 0 171px !important;
}
</style>
