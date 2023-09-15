<script setup>
import { Link } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChangePlan from "./ChangePlan.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="6">
                    <VImg src="/images/teacherimg.png" />
                </VCol>
                <VCol cols="6">
                    <VText class="teacherprofile-title">Profile</VText>
                    <div class="d-flex justify-space-between mt-10">
                        <h1 class="tiggie-label fs-20">Personal Details</h1>
                        <VBtn variant="flat" rounded color="teal">
                            <Link :href="route('editteacher')">
                                <VIcon icon="mdi-pencil-outline"></VIcon>
                                <span>Edit</span>
                            </Link>
                        </VBtn>
                    </div>
                    <VRow>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">FullName</h6>
                            <p class="tiggie-p">Tyler Covington</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Work Email</h6>
                            <p class="tiggie-p">tyler.covington@work.sg</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Contact Number</h6>
                            <p class="tiggie-p">9123 4567</p>
                        </VCol>
                    </VRow>
                    <!-- contact user plan -->
                    <h1 class="teacherprofile-title">Subscription</h1>
                    <div class="d-flex justify-space-between mt-10">
                        <h1 class="tiggie-label fs-20">Personal Details</h1>
                        <ChangePlan />
                    </div>
                    <VRow>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Plan Name</h6>
                            <p class="tiggie-p">Base Plan</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">
                                Subscription Period
                            </h6>
                            <p class="tiggie-p">
                                2 August 2023 - 2 September 2023
                            </p>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="2">
                    <VBtn
                        color="#e9eff0"
                        variant="flat"
                        rounded
                        height="50"
                        class="pl-16 pr-16"
                    >
                        <span class="text-primary">Back</span>
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.teacherprofile-title {
    color: var(--text, #161616);
    /* H3 Ruddy */
    font-family: Ruddy;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    text-transform: capitalize !important;
}
</style>
