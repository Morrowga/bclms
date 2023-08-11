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

const tableData = [
  {
    action: 'Collapse',
    icon: 'mdi-chevron-up',
    details: 'Collapse card content using collapse action.',
  },
  {
    action: 'Refresh Content',
    icon: 'mdi-refresh',
    details: 'Refresh your card content using refresh action.',
  },
  {
    action: 'Remove Card',
    icon: 'mdi-close',
    details: 'Remove card from page using remove card action',
  },
]

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-between" no-gutters>
                <VCol cols="6">
                    <div class="tiggie-title mb-4 d-flex align-center">
                        <VTextField label="Search User Experience Surveys" height="50" density="compact" />
                        <V-icon icon="mdi-information-variant-circle" size="30" />
                    </div>
                </VCol>
                <VCol cols="6" class="text-end">
                    <VRow no-gutters>
                        <VCol cols="12" class="">
                            <VBtn color="secondary" text-color="white" variant="tonal" @click="isUserProfileEdit = true"
                                height="50" class="mr-4">
                                <span class="text-dark">Back</span>
                            </VBtn>
                            <VBtn color="success" height="50" class="">
                                <span class="text-white">Save</span>
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="12">
                    <VTextarea placeholder="Add survey description..." v-model="description" auto-grow rows="5" />
                </VCol>
                <Vcol cols="12">
                    <VCard>
                        <VCardTitle>
                            Question 1  Multiple Response
                        </VCardTitle>
                        <VCardSubTitle>
                            Which of the following features do you find most valuable in the application? (Please select all that apply)
                        </VCardSubTitle>
                        <VCardText>
                          <VDivider/>
                        </VCardText>
                    </VCard>

                </Vcol>
            </VRow>

        </VContainer>
    </AdminLayout>
</template>

<style>
.v-label.v-field-label {
    color: #4066E4 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}
</style>
