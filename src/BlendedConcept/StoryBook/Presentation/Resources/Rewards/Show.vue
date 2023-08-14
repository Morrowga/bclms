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
        <section>
            <VContainer>
                <VRow justify="center" :gutter="5">
                    <VCol cols="6">
                        <span class="tiggie-show-title  margin-buttom-18 pr-4">Reward Particulars</span>
                    </VCol>
                    <VCol cols="6"></VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Name</VLabel>
                                <p class="tiggie-p">Tiggy OMG</p>
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Stars Required</VLabel>
                                <p class="tiggie-p">10</p>
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Number of Student Profile</VLabel>
                                <p class="tiggie-p">1</p>
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Storage space</VLabel>
                                <p class="tiggie-p">1GB</p>
                            </VCol>
                            <VCol cols="8">
                                <VRow no-gutters>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Customization </VLabel>
                                        <p class="tiggie-p">No</p>
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Personalization</VLabel>
                                        <p class="tiggie-p">Yes</p>
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Full Library Access </VLabel>
                                        <p class="tiggie-p">No</p>
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Concurrent Access</VLabel>
                                        <p class="tiggie-p">No</p>
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Weekly Learning Report </VLabel>
                                        <p class="tiggie-p">No</p>
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label">Dedicated Student Report</VLabel>
                                        <p class="tiggie-p">No</p>
                                    </VCol>
                                </VRow>

                            </VCol>
                        </VRow>
                    </VCol>

                    <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                        <Link :href="route('plans.index')" class="text-black">
                        <VBtn color="gray" height="50" class="" width="200">
                            Cancel
                        </VBtn>
                        </Link>
                        <VBtn type="submit" class="" height="50" width="200"> Edit </VBtn>
                    </VCol>
                </VRow>
            </VContainer>
        </section>
    </AdminLayout>
</template>
