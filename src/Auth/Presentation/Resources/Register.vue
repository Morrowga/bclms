<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";

import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";
let organisation = ref(false);
let isAlertVisible = ref(true);
const items = [
    "California",
    "Colorado",
    "Florida",
    "Georgia",
    "Texas",
    "Wyoming",
];
const isPasswordVisible = ref(false);
let agreed = ref("");
let props = defineProps(["ErrorMessage"]);
</script>

<template>
    <div>
        <div class="layout-navbar">
            <div
                class="navbar-content-container d-flex justify-space-between px-10 py-5"
            >
                <h1
                    class="text-h5 font-weight-bold leading-normal text-capitalize"
                >
                    {{ themeConfig.app.title }}
                </h1>
                <VBtn color="primary" class="b-0 text-white">
                    <Link :href="route('login')" class="text-white">
                        Login
                    </Link>
                </VBtn>
            </div>
        </div>
        <SystemErrorAlert
            :sytemErrorMessage="sytemErrorMessage"
            v-if="sytemErrorMessage"
        />

        <VDivider></VDivider>

        <div class="text-center mt-10">
            <p class="ruddy-bold signup-title">Sign Up For B2C Account</p>
            <VRow class="mt-10">
                <VCol cols="4"> </VCol>
                <VCol cols="4" class="text-left">
                    <VTextField
                        class="mt-3 custom-label-color"
                        label="Name *"
                        placeholder=""
                        density="compact"
                        variant="solo"
                    />
                    <VTextField
                        class="mt-5 custom-label-color"
                        label="Email *"
                        placeholder=""
                        density="compact"
                        variant="solo"
                    />
                    <VTextField
                        class="mt-5 custom-label-color"
                        label="Contact Number *"
                        placeholder=""
                        density="compact"
                        variant="solo"
                    />
                    <VTextField
                        class="mt-5 custom-label-color"
                        label="Password *"
                        placeholder=""
                        density="compact"
                        variant="solo"
                        :type="isPasswordVisible ? 'text' : 'password'"
                        :append-inner-icon="
                            isPasswordVisible
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                        "
                        @click:append-inner="
                            isPasswordVisible = !isPasswordVisible
                        "
                    />
                    <VTextField
                        class="mt-5 custom-label-color"
                        label="Confirm Password *"
                        placeholder=""
                        :type="isPasswordVisible ? 'text' : 'password'"
                        :append-inner-icon="
                            isPasswordVisible
                                ? 'mdi-eye-off-outline'
                                : 'mdi-eye-outline'
                        "
                        @click:append-inner="
                            isPasswordVisible = !isPasswordVisible
                        "
                        density="compact"
                        variant="solo"
                    />
                    <div class="mt-5">
                        <v-checkbox
                            label="I agree to the terms and services"
                        ></v-checkbox>
                    </div>
                    <VBtn
                        block
                        @click="router.get(route('registerplan'))"
                        variant="flat"
                        class="primary mt-5"
                        rounded
                    >
                        Sign up
                    </VBtn>
                </VCol>
                <VCol cols="4"> </VCol>
            </VRow>
        </div>
    </div>
</template>

<style lang="scss">
@use "@styles/@core/template/pages/page-auth.scss";
.regiser-image {
    //   background: url("/public/images/signupnew.png") 100% no-repeat;
    height: 100vh;
    background-size: cover;
}

.signup-title {
    color: var(--Text, #161616);
    /* H3 Ruddy */
    font-size: 30px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 52px; /* 130% */
    text-transform: capitalize;
}

.custom-label-color .v-label {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}
// .primary {
//   color: #001a8f !important;
// }
</style>
