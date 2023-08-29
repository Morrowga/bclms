<script setup>
import { ref } from "vue"
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from '@actions/useSuccess';

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
    isCustomization: false,
    isPresentation: false,
    isFullAccess: false,
    isConcurrentAccess: false,
    isWeeklyLearningReport: false,
    isDedicatedStudentReport: false,

})

let onFormSubmit = () => {
    SuccessDialog({ title: "Subscription plan added" })
}

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="6">
                        <span class="tiggie-title margin-buttom-18"> Add Subscription Plan</span>
                        <p>Adding subscription for <span class="text-primary">Blended Concept</span></p>
                    </VCol>
                    <VCol cols="6"></VCol>
                    <VCol cols="6">
                        <VRow gutters="5">
                            <VCol cols="8">
                                <VLabel class="tiggie-label">No. of Teachers</VLabel>
                                <VTextField placeholder="Type here.." density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">No. of Students</VLabel>
                                <VTextField placeholder="Type here..." density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Storage Size</VLabel>
                                <VTextField placeholder="Type here..." density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Start Date</VLabel>
                                <AppDateTimePicker v-model="date" density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">End Date</VLabel>
                                <AppDateTimePicker v-model="date" density="compact" />
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="6">
                        <span class="tiggie-subtitle">Usage Allowance</span>
                        <VRow>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Payment Amount</VLabel>
                                <VTextField placeholder="Type here.." density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Payment Date</VLabel>
                                <AppDateTimePicker v-model="date" density="compact" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Payment Receipt</VLabel>
                                <VFileInput label="File input" prepend-icon="mdi-camera-outline" />

                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                        <Link :href="route('plans.index')" class="text-black">
                        <VBtn color="gray" height="50" class="" width="200">
                            Cancel
                        </VBtn>
                        </Link>
                        <VBtn type="submit" class="" height="50" width="200"> Finish </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
