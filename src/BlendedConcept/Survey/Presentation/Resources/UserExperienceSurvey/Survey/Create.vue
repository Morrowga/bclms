<script setup>
import { ref } from "vue"
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from '@actions/useSuccess';
import SurveyAdd from "../components/SurveyAdd.vue"
import SurveySetting from "../components/SurveySetting.vue"

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
const items = [
    {
        text: 'Fast performance',
        icon: 'mdi-circle-small',
    },
    {
        text: 'User-friendly interface',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Rich customization options',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Seamless integration with other platforms',
        icon: 'mdi-circle-small',
    },
    {
        text: 'In-app customer support/chat',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Regular updates and improvements',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Personalization features',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Social sharing capabilities',
        icon: 'mdi-circle-small',
    },
    {
        text: 'Gamification elements (badges, rewards, etc.)',
        icon: 'mdi-circle-small',
    }
]


const isSurveryAdd = ref(false);
const isSurveySetting = ref(false);


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
                            <VBtn color="success" height="50" class="" @click="isSurveySetting = true">
                                <span class="text-white">Save</span>
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="12">
                    <VTextarea placeholder="Add survey description..." v-model="description" auto-grow rows="5" />
                </VCol>
                <Vcol cols="12">
                    <VCard style="width:81vw" class="mt-4">
                        <VCardTitle class="tiggie-subtitle">
                            Question 1 . Multiple Response
                        </VCardTitle>
                        <VCardSubTitle class="pl-4 tiggie-p">
                            Which of the following features do you find most valuable in the application? (Please select all
                            that apply)
                        </VCardSubTitle>
                        <VDivider />
                        <VCardText>
                            <VRow no-gutters justify="start">
                                <VCol cols="1">
                                    <h4 class="tiggie-subtitle">Options</h4>
                                </VCol>
                                <VCol cols="4" style="text-align: left;" class="mb-10">
                                    <VList>
                                        <VListItem v-for="(item, i) in items" :key="i" :value="item.text">
                                            <template #prepend>
                                                <VIcon :icon="item.icon" />
                                            </template>
                                            <VListItemTitle class="tiggie-p" v-text="item.text" />
                                        </VListItem>
                                    </VList>

                                </VCol>
                            </VRow>
                        </VCardText>
                    </VCard>

                </Vcol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4" class="text-center">
                    <VBtn
                    color="primary" icon="mdi-plus-thick"
                    @click="isSurveryAdd = true"
                    />
                </VCol>
            </VRow>

        </VContainer>
    </AdminLayout>

    <SurveyAdd v-model:isDialogVisible="isSurveryAdd" :user-data="user" :form="profileEdit"
        @submit="hanleSubmit" />
    <SurveySetting v-model:isDialogVisible="isSurveySetting" :user-data="user" :form="profileEdit"
        @submit="hanleSubmit" />
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
