<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import SurveyAdd from "../components/SurveyAdd.vue";
import EditSurveyAdd from "../components/EditSurveyAdd.vue";

import SurveySetting from "../components/SurveySetting.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SurveyListQuestionComponent from "../components/SurveyListQuestionComponent.vue";

let form = useForm({
    isCustomization: false,
    isPresentation: false,
    isFullAccess: false,
    isConcurrentAccess: false,
    isWeeklyLearningReport: false,
    isDedicatedStudentReport: false,
});

let onFormSubmit = () => {
    SuccessDialog({ title: "Subscription plan added" });
};
const items = [
    {
        text: "Fast performance",
        icon: "mdi-circle-small",
    },
    {
        text: "User-friendly interface",
        icon: "mdi-circle-small",
    },
    {
        text: "Rich customization options",
        icon: "mdi-circle-small",
    },
    {
        text: "Seamless integration with other platforms",
        icon: "mdi-circle-small",
    },
    {
        text: "In-app customer support/chat",
        icon: "mdi-circle-small",
    },
    {
        text: "Regular updates and improvements",
        icon: "mdi-circle-small",
    },
    {
        text: "Personalization features",
        icon: "mdi-circle-small",
    },
    {
        text: "Social sharing capabilities",
        icon: "mdi-circle-small",
    },
    {
        text: "Gamification elements (badges, rewards, etc.)",
        icon: "mdi-circle-small",
    },
];

const isSurveryAdd = ref(false);
const isSurveySetting = ref(false);
const isSurveyEdit = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-between" no-gutters>
                <VCol cols="6">
                    <div class="tiggie-title mb-4 d-flex align-center">
                        Happiness Survey
                        <V-icon
                            icon="mdi-information-variant-circle"
                            size="30"
                        />
                    </div>
                </VCol>
                <VCol cols="6" class="text-end">
                    <VRow no-gutters>
                        <VCol cols="12" class="">
                            <VBtn
                                color="secondary"
                                text-color="white"
                                variant="tonal"
                                @click="isUserProfileEdit = true"
                                height="50"
                                class="mr-4"
                            >
                                <span class="text-dark">Back</span>
                            </VBtn>
                            <VBtn
                                color="primary"
                                height="50"
                                class=""
                                @click="isSurveySetting = true"
                            >
                                <span class="text-white">Settings</span>
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
                <Vcol cols="12">
                    <SurveyListQuestionComponent
                        title="Question 1 . Multiple Response"
                        subtitle=" Which of the following features do you find most valuable in the application? (Please select all that apply)"
                        :item="items"
                    />

                    <SurveyListQuestionComponent
                        title="Question 2   •   Single Choice"
                        subtitle="Which areas of the application do you think could be improved to enhance your overall happiness? (Please select all that apply.)"
                        :item="items"
                    />

                    <SurveyListQuestionComponent
                        title="Question 3   •   Multiple Response"
                        subtitle="Which areas of the application do you think could be improved to enhance your overall happiness? (Please select all that apply.)"
                        :item="items"
                    />

                    <SurveyListQuestionComponent
                        title="Question 4   •   Single Choice"
                        subtitle="How would you rate the application's performance compared to similar apps you have used? (Choose one option)"
                        :item="items"
                    />
                </Vcol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4" class="text-center">
                    <VBtn
                        color="primary"
                        icon="mdi-plus-thick"
                        @click="isSurveryAdd = true"
                    />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>

    <SurveyAdd
        v-model:isDialogVisible="isSurveryAdd"
        :user-data="user"
        :form="profileEdit"
        @submit="hanleSubmit"
    />
    <EditSurveyAdd
        v-model:isDialogVisible="isSurveyEdit"
        :user-data="user"
        :form="profileEdit"
        @submit="hanleSubmit"
    />
    <SurveySetting
        v-model:isDialogVisible="isSurveySetting"
        :user-data="user"
        :form="profileEdit"
        @submit="hanleSubmit"
    />
</template>

<style scoped>
/* .v-label.v-field-label {
    color: #4066E4 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
} */
</style>
