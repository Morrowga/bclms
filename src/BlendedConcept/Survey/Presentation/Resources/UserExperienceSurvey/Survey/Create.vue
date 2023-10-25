<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";
import SurveyAdd from "../components/SurveyAdd.vue";
import SurveySetting from "../components/SurveySetting.vue";
import EditSurveyAdd from "../components/EditSurveyAdd.vue";
import draggable from "vuedraggable";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
const drag = ref(false);

let form = useForm({
    title: "Untitled Survey",
    description: null,
    type: "USEREXP",
    user_type: null,
    appear_on: null,
    start_date: null,
    end_date: null,
    required: null,
    repeat: null,
    questions: [],
    // date_created: null,
});

const addSurveyForm = ref([]);
const editSurveyData = ref([]);
const isSurveryAdd = ref(false);
const isSurveySetting = ref(false);
const isEditSurveryAdd = ref(false);

// let onFormSubmit = () => {
//     SuccessDialog({ title: "Subscription plan added" })
// }

function deleteSurveyForm(id) {
    for (let i = 0; i < addSurveyForm.value.length; i++) {
        if (addSurveyForm.value[i].id == id) {
            addSurveyForm.value.splice(i, 1); // Remove the item at index i
            break; // Exit the loop after removing the item
        }
    }
}

const handleEditSurveyFormSubmit = (data) => {
    console.log(data);
};

const openEditSurveyForm = (id) => {
    for (let i = 0; i < addSurveyForm.value.length; i++) {
        if (addSurveyForm.value[i].id == id) {
            editSurveyData.value = addSurveyForm.value[i];
            console.log(editSurveyData.value);
            isEditSurveryAdd.value = true;
            break; // Exit the loop after removing the item
        }
    }
};

const handleModalSubmit = (data) => {
    addSurveyForm.value.push({
        id: data.id,
        question_type: data.question_type,
        question: data.question,
        options: data.question_type == "SHORT_ANSWER" ? [] : data.options,
    });
    console.log(addSurveyForm.value);
};
const handleSettingModalSubmit = (data) => {
    form.user_type = JSON.stringify(data.user_type);
    form.appear_on = data.appear_on;
    form.start_date = data.start_date;
    form.end_date = data.end_date;
    form.required = data.required;
    form.repeat = data.repeat;
    console.log(addSurveyForm.value.length);
    form.questions =
        addSurveyForm.value.length > 0
            ? JSON.stringify(addSurveyForm.value)
            : null;
    form.post(route("userexperiencesurvey.store"), {
        onSuccess: () => {
            SuccessDialog({
                title: "You've successfully created user experience survey.",
            });
        },
        onError: (error) => {
            if (error.questions) {
                isSurveySetting.value = false;
                SuccessDialog({
                    title: error.questions,
                    mainTitle: "Error!",
                    color: "#ff6262",
                    icon: "error",
                });
            }
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-between" no-gutters>
                <VCol cols="6">
                    <div class="tiggie-title mb-4 d-flex align-center">
                        <VTextField
                            v-model="form.title"
                            :rules="[requiredValidator]"
                            :error-messages="form?.errors?.title"
                            placeholder="Enter Survey Title"
                            height="50"
                            density="compact"
                        />
                        <V-icon
                            icon="mdi-information-variant-circle"
                            class="ml-3"
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
                                @click="
                                    () =>
                                        router.get(
                                            route('userexperiencesurvey.index')
                                        )
                                "
                                height="50"
                                class="mr-4"
                            >
                                <span class="text-dark">Back</span>
                            </VBtn>
                            <VBtn
                                color="success"
                                height="50"
                                class=""
                                @click="isSurveySetting = true"
                            >
                                <span class="text-white">Save</span>
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="12" class="mt-4">
                    <VTextarea
                        placeholder="Add survey description..."
                        :rules="[requiredValidator]"
                        :error-messages="form?.errors?.description"
                        v-model="form.description"
                        auto-grow
                        rows="5"
                    />
                </VCol>
                <div v-if="addSurveyForm.length > 0">
                    <draggable
                        v-model="addSurveyForm"
                        @start="drag = true"
                        @end="drag = false"
                        item-key="id"
                    >
                        <template #item="{ element, index }">
                            <Vcol cols="12" :key="index">
                                <VCard style="width: 81vw" class="mt-4">
                                    <VCardTitle class="tiggie-subtitle">
                                        <div
                                            class="d-flex justify-space-between"
                                        >
                                            <div>
                                                Question {{ index + 1 }} .
                                                {{ element.question_type }}
                                            </div>
                                            <div>
                                                <v-menu>
                                                    <template
                                                        v-slot:activator="{
                                                            props,
                                                        }"
                                                    >
                                                        <div
                                                            class="cursor-pointer"
                                                            v-bind="props"
                                                        >
                                                            ...
                                                        </div>
                                                    </template>
                                                    <v-list>
                                                        <v-list-item>
                                                            <v-list-item-title
                                                                class="px-5 cursor-pointer"
                                                                @click="
                                                                    openEditSurveyForm(
                                                                        element.id
                                                                    )
                                                                "
                                                                >Edit</v-list-item-title
                                                            >
                                                            <v-spacer></v-spacer>
                                                            <v-list-item-title
                                                                class="px-5 mt-2 cursor-pointer"
                                                                @click="
                                                                    deleteSurveyForm(
                                                                        element.id
                                                                    )
                                                                "
                                                                >Delete</v-list-item-title
                                                            >
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </div>
                                        </div>
                                    </VCardTitle>
                                    <VCardSubTitle
                                        class="pl-4 tiggie-p"
                                        v-if="
                                            element.question_type !=
                                            'SHORT_ANSWER'
                                        "
                                    >
                                        {{ element.question }}
                                    </VCardSubTitle>
                                    <VCardSubTitle
                                        class="pl-4 tiggie-p shortanswer"
                                        v-else
                                    >
                                        {{ element.question }}
                                    </VCardSubTitle>
                                    <VDivider
                                        v-if="
                                            element.question_type !=
                                            'SHORT_ANSWER'
                                        "
                                    />
                                    <VCardText
                                        v-if="
                                            element.question_type !=
                                            'SHORT_ANSWER'
                                        "
                                    >
                                        <VRow no-gutters justify="start">
                                            <VCol cols="1">
                                                <h4 class="tiggie-subtitle">
                                                    Options
                                                </h4>
                                            </VCol>
                                            <VCol
                                                cols="4"
                                                style="text-align: left"
                                                class="mb-10"
                                            >
                                                <VList>
                                                    <VListItem
                                                        v-for="(
                                                            option, i
                                                        ) in element.options"
                                                        :key="i"
                                                    >
                                                        <template #prepend>
                                                            <VIcon
                                                                :icon="'mdi-circle-small'"
                                                            />
                                                        </template>
                                                        <VListItemTitle
                                                            class="tiggie-p"
                                                        >
                                                            {{ option }}
                                                        </VListItemTitle>
                                                    </VListItem>
                                                </VList>
                                            </VCol>
                                        </VRow>
                                    </VCardText>
                                </VCard>
                            </Vcol>
                        </template>
                    </draggable>
                </div>
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
        @submit="handleModalSubmit"
    />
    <SurveySetting
        v-model:isDialogVisible="isSurveySetting"
        @submit="handleSettingModalSubmit"
    />
    <EditSurveyAdd
        v-model:isDialogVisible="isEditSurveryAdd"
        :form="editSurveyData"
        @submit="handleEditSurveyFormSubmit"
    />
</template>

<style>
.shortanswer {
    line-height: 3 !important;
}
/* .v-label.v-field-label {
    color: #4066E4 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
} */
.align-text-left {
    text-align: left !important;
}
</style>
