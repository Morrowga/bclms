<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { SuccessDialog } from '@actions/useSuccess';
import SurveyAdd from "../components/SurveyAdd.vue"
import SurveySetting from "../components/SurveySetting.vue"
import EditSurveyAdd from "../components/EditSurveyAdd.vue"

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

let form = useForm({
    title: 'Untitled Survey',
    description: null,
    type: 'USERREXP',
    user_type: null,
    appear_on: null,
    start_date: null,
    end_date: null,
    required: null,
    repeat: null,
    questions: []
})

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
            editSurveyData.value = addSurveyForm.value[i]
            console.log(editSurveyData.value)
            isEditSurveryAdd.value = true;
            break; // Exit the loop after removing the item
        }
    }
}

const handleModalSubmit = (data) => {
    addSurveyForm.value.push({
        "id": data.id,
        "question_type": data.question_type,
        "question": data.question,
        "options": data.options
    })
};
const handleSettingModalSubmit = (data) => {
    form.user_type = data.user_type
    form.appear_on = data.appear_on
    form.start_date = data.start_date
    form.end_date = data.end_date
    form.required = data.required
    form.repeat = data.repeat
    console.log(addSurveyForm.value.length);
    form.questions = addSurveyForm.value.length > 0 ? JSON.stringify(addSurveyForm.value) : null;
    console.log(form);
    form.post(route("userexperiencesurvey.store"), {
        onSuccess: () => {
            SuccessDialog({ title: "You've successfully created user experience survey." });
        },
        onError: (error) => {
            form.setError("title", error?.title);
            form.setError("description", error?.description);
            form.setError("questions", error?.questions);
            // form.setError("icon", error?.icon);
            // form.setError("message", error?.message);
        },
    })
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-between" no-gutters>
                <VCol cols="6">
                    <div class="tiggie-title mb-4 d-flex align-center">
                        <VTextField v-model="form.title"
                        :rules="[requiredValidator]" :error-messages="form?.errors?.title"
                        placeholder="Enter Survey Title" height="50" density="compact" />
                        <V-icon icon="mdi-information-variant-circle" class="ml-3" size="30" />
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
                                            route(
                                                'userexperiencesurvey.index'
                                            )
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
                    <VTextarea placeholder="Add survey description..."
                    :rules="[requiredValidator]" :error-messages="form?.errors?.description"
                    v-model="form.description" auto-grow rows="5" />
                </VCol>
                <div v-if="addSurveyForm.length > 0">
                    <Vcol cols="12" v-for="(item, i) in addSurveyForm" :key="i">
                        <VCard style="width:81vw" class="mt-4">
                            <VCardTitle class="tiggie-subtitle">
                                <div class="d-flex justify-space-between">
                                    <div>
                                        Question {{ i + 1 }} . {{ item.question_type }}
                                    </div>
                                    <div>
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <div class="cursor-pointer"
                                                v-bind="props"
                                                >
                                                ...
                                                </div>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title class="px-5 cursor-pointer" @click="openEditSurveyForm(item.id)">Edit</v-list-item-title>
                                                    <v-spacer></v-spacer>
                                                    <v-list-item-title class="px-5 mt-2 cursor-pointer" @click="deleteSurveyForm(item.id)">Delete</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </div>
                                </div>
                            </VCardTitle>
                            <VCardSubTitle class="pl-4 tiggie-p">
                                {{item.question}}
                            </VCardSubTitle>
                            <VDivider />
                            <VCardText>
                                <VRow no-gutters justify="start">
                                    <VCol cols="1">
                                        <h4 class="tiggie-subtitle">Options</h4>
                                    </VCol>
                                    <VCol cols="4" style="text-align: left;" class="mb-10">
                                        <VList>
                                            <VListItem v-for="(option, i) in item.options" :key="i">
                                                <template #prepend>
                                                    <VIcon :icon="'mdi-circle-small'" />
                                                </template>
                                                <VListItemTitle class="tiggie-p">
                                                    {{ option }}
                                                </VListItemTitle>
                                            </VListItem>
                                        </VList>
                                    </VCol>
                                </VRow>
                            </VCardText>
                        </VCard>
                    </Vcol>
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

    <SurveyAdd v-model:isDialogVisible="isSurveryAdd"
        @submit="handleModalSubmit" />
    <SurveySetting v-model:isDialogVisible="isSurveySetting"
        @submit="handleSettingModalSubmit" />
    <EditSurveyAdd v-model:isDialogVisible="isEditSurveryAdd" :form="editSurveyData"
        @submit="handleEditSurveyFormSubmit" />
</template>

<style>
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
