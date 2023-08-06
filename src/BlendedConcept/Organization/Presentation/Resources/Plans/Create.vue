<script setup>
import {ref} from "vue"
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
    isCustomization : false,
    isPresentation : false,
    isFullAccess : false,
    isConcurrentAccess : false,
    isWeeklyLearningReport : false,
    isDedicatedStudentReport : false,

})



</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around" :gutter="10">
                <VCol cols="6">
                    <span class="tiggie-title margin-buttom-18"> Add Subscription Plan</span>
                </VCol>
                <VCol cols="6"></VCol>
                <VCol cols="6">
                    <span class="tiggie-subtitle ">Basic Details</span>
                    <VRow gutters="5">
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Plan Name</VLabel>
                            <VTextField placeholder="Type here.." />
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Description</VLabel>
                            <VTextField placeholder="Type here..." />
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Price</VLabel>
                            <VTextField placeholder="Type here..." />
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-subtitle">Usage Allowance</span>
                    <VRow>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Number of Student Profile</VLabel>
                            <VTextField placeholder="Type here.." />
                        </VCol>
                        <VCol cols="8">
                            <VLabel class="tiggie-label">Storage space</VLabel>
                            <VTextField placeholder="Type here..." />
                        </VCol>
                        <VCol cols="8">
                            <VRow no-gutters>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Customization </VLabel>
                                    <VSwitch v-model="form.isCustomization" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Personalization</VLabel>
                                    <VSwitch v-model="form.isPresentation" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Full Library Access </VLabel>
                                    <VSwitch v-model="form.isFullAccess" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Concurrent Access</VLabel>
                                    <VSwitch v-model="form.isConcurrentAccess" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Weekly Learning Report </VLabel>
                                    <VSwitch v-model="form.isWeeklyLearningReport" inset/>
                                </VCol>
                                <VCol cols="6">
                                    <VLabel class="tiggie-label">Dedicated Student Report</VLabel>
                                    <VSwitch v-model="form.isDedicatedStudentReport" inset/>
                                </VCol>
                            </VRow>

                        </VCol>
                    </VRow>
                </VCol>

                <VCol cols="12" class="d-flex justify-center gap-10">
                                <Link :href="route('plans.index')" class="cancel-btn text-center" >
                                    Cancel
                                </Link>
                     <VBtn type="submit" class="finish-btn"> Finish </VBtn>

                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
