<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";

import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";
let organization = ref(false);
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
    <div class="layout-navbar">
        <div
            class="navbar-content-container d-flex justify-space-between px-10 py-5"
        >
            <h1 class="text-h5 font-weight-bold leading-normal text-capitalize">
                {{ themeConfig.app.title }}
            </h1>
            <VBtn color="primary" class="b-0 text-white">
                <Link :href="route('login')" class="text-white"> Login </Link>
            </VBtn>
        </div>
    </div>
    <SystemErrorAlert
        :sytemErrorMessage="sytemErrorMessage"
        v-if="sytemErrorMessage"
    />

    <VDivider></VDivider>

    <div class="text-center mt-5">
        <p class="pppangram-bold plan-title">Plans</p>
        <VRow class="mt-10">
            <VCol cols="3"> </VCol>
            <VCol cols="6" class="text-left input-awine">
                <p class="plan-text pppangram-bold">
                    How many student accounts do you need ?
                </p>
                <VTextField
                    placeholder="eg 5 "
                    variant="plain"
                    density="compact"
                >
                    <template #append-inner>
                        <VIcon
                            icon="mdi-magnify"
                            size="26px"
                            height="26px"
                            class="abs-top"
                        >
                        </VIcon>
                    </template>
                </VTextField>
            </VCol>
            <VCol cols="3"> </VCol>
        </VRow>
    </div>

    <div class="mx-15">
        <table class="heavyTable">
            <thead>
                <tr>
                    <th>
                        <div class="th-emtpy-width"></div>
                    </th>
                    <th>
                        <div class="th-width">
                            <p class="th-text pppangram-bold mt-5">Free</p>

                            <p class="text-left ml-3 plan-mini-text textmargin">
                                ss<strong>0</strong> <br />
                                /month
                            </p>
                        </div>
                        <VBtn
                            class="th-btn mb-5"
                            color="#FC0"
                            variant="flat"
                            rounded
                            >Sign Up</VBtn
                        >
                    </th>
                    <th>
                        <div class="th-width">
                            <p class="th-text pppangram-bold mt-5">Base</p>

                            <p class="text-left plan-mini-text ml-3 mt-15">
                                Free <br />
                                for 1 month <br />
                                Then, starts of ss<strong>10</strong> <br />
                                /month
                            </p>
                        </div>
                        <VBtn
                            class="th-btn mb-5"
                            color="#FC0"
                            variant="flat"
                            rounded
                            >Sign Up</VBtn
                        >
                    </th>
                    <th>
                        <div class="th-width">
                            <p class="th-text pppangram-bold mt-5">Pro</p>

                            <p class="text-left plan-mini-text ml-3 mt-15">
                                Free <br />
                                for 1 month <br />
                                Then, starts of ss<strong>50</strong> <br />
                                /month
                            </p>
                        </div>
                        <VBtn
                            class="th-btn mb-5"
                            color="#FC0"
                            variant="flat"
                            rounded
                            >Sign Up</VBtn
                        >
                    </th>
                    <th>
                        <div class="th-width">
                            <p class="th-text pppangram-bold mt-5">Premium</p>

                            <p class="text-left plan-mini-text ml-3 mt-15">
                                Free <br />
                                for 1 month <br />
                                Then, starts of ss<strong>100</strong> <br />
                                /month
                            </p>
                        </div>
                        <VBtn
                            class="th-btn mb-5"
                            color="#FC0"
                            variant="flat"
                            rounded
                            >Sign Up</VBtn
                        >
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-left">
                    <td>Free Student Profile</td>
                    <td>1 Student</td>
                    <td>1 Student</td>
                    <td>1 Student</td>
                    <td>1 Student</td>
                </tr>
                <tr class="text-left">
                    <td>Additional Student Profile</td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Storage Space</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>1GB</td>
                    <td>5GB</td>
                </tr>
                <tr class="text-left">
                    <td>Free Library Access</td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Personalization</td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Customization</td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Full Library Access</td>
                    <td>
                        <VIcon icon="mdi-close"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Concument Access</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>NA</td>
                </tr>
                <tr class="text-left">
                    <td>Weekly Learning Progress Report</td>
                    <td>
                        <VIcon icon="mdi-close" size="lg"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
                <tr class="text-left">
                    <td>Dedicated Student Report</td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                    <td>
                        <VIcon icon="mdi-check"></VIcon>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";
.regiser-image {
    //   background: url("/public/images/signupnew.png") 100% no-repeat;
    height: 100vh;
    background-size: cover;
}
.th-btn {
    width: 90% !important;
    color: #fff;
}

.textmargin {
    margin-top: 12vh;
}

.textmargin1 {
    margin-top: 10vh;
}

.plan-mini-text {
    font-size: 12px !important;
}

.plan-title {
    color: var(--Text, #161616);
    font-size: 36px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 44px; /* 122.222% */
    text-transform: capitalize;
}

.heavyTable {
    width: 100%;
    height: 326px;
    border-collapse: collapse;
    border: 1px solid #38678f;
    margin: 50px auto;
    background: white;
    box-shadow: 0px 2px 10px 0px rgba(76, 78, 100, 0.22);
}

.heavyTable > thead > tr > th {
    border: 1px solid #bfc0c1 !important;
}

.heavyTable > thead {
    background: #fff !important;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.heavyTable > tbody > tr:nth-child(odd) {
    background: #bfc0c1 !important;
}

.heavyTable > tbody > tr > td:nth-child(1) {
    width: 35vh;
}

.heavyTable > tbody > tr > td {
    border: 1px solid rgb(0, 0, 0, 0.2) !important;
    padding: 10px;
}

.th-width {
    width: 100px;
    padding: 10px !important;
    height: 300px;
}

.td-width {
    width: 50px;
    padding: 10px !important;
    height: 300px;
}

.plan-text {
    color: var(--Graphite, #282828);
    font-size: 16px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 26px; /* 162.5% */
}

.th-text {
    color: var(--Graphite, #282828);
    text-align: center;
    /* H3 Pangram Bold */
    font-size: 40px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 32px; /* 80% */
}
// .primary {
//   color: #001a8f !important;
// }

:deep(.input-awine .v-text-field input) {
    border-radius: 100px !important;
    border: 1px solid #bfc0c1 !important;
    padding: 8px 16px 8px 20px !important;
    background: #fff !important;
}
.abs-top {
    position: absolute;
    right: 10px;
}
</style>
