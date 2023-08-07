<script setup>
import { ref } from "vue"
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
    isCustomization: false,
    isPresentation: false,
    isFullAccess: false,
    isConcurrentAccess: false,
    isWeeklyLearningReport: false,
    isDedicatedStudentReport: false,

})



</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center" noGutters>
                <VCol cols="6">
                    <h4 class="tiggie-show-title  pr-10 margin-buttom-18">User Particulars </h4>
                </VCol>
                <VCol cols="6"></VCol>

                <VCol cols="6">
                    <img src="/images/defaults/avator.png" />
                </VCol>
                <VCol cols="5"></VCol>

                <VCol cols="6">
                    <VLabel class="tiggie-label">Organisation Name</VLabel>
                    <p class="tiggie-p">Blended Concept</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">User Role</VLabel>
                    <p class="tiggie-p">Organization Admin</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">Name</VLabel>
                    <p class="tiggie-p">Jordan Stevenson</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">Login Email</VLabel>
                    <p class="tiggie-p"> estelle.Bailey10@gmail.com </p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">User Email</VLabel>
                    <p class="tiggie-p">susanna.lind57@gmail.com</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">Login Password</VLabel>
                    <p class="tiggie-p"> *********</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">User Contact Number</VLabel>
                    <p class="tiggie-p">95159746</p>
                </VCol>
                <VCol cols="6">
                    <VLabel class="tiggie-label">Current User Status</VLabel>
                    <p class="tiggie-p text-primary"> ACTIVE</p>
                </VCol>

                <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                    <VBtn color="gray" text-color="white" height="50" class="pl-16 pr-16">
                        <Link :href="route('plans.index')" class="cancel-btn text-center">
                        Back
                        </Link>
                    </VBtn>
                    <VBtn type="submit" class="finish-btn pl-5 pr-5" height="50"> Set Inactive </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
