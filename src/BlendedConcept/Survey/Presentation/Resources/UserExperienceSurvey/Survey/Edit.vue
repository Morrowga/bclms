<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";
import SurveyAdd from "../components/SurveyAdd.vue";
import EditSurveyAdd from "../components/EditSurveyAdd.vue";
import EditSurveySetting from "../components/EditSurveySetting.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import SurveyListQuestionComponent from "../components/SurveyListQuestionComponent.vue";
import draggable from 'vuedraggable';

import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

let props = defineProps(['survey']);

const drag = ref(false);

let addNewQuestionForm = useForm({
    "survey_id" : props.survey.data.id,
    "question_type" : null,
    "question" : null,
    "options" : null
})

let form = useForm({
    title: props.survey.data.title,
    description: null,
    type: 'USEREXP',
    user_type: null,
    appear_on: null,
    start_date: null,
    end_date: null,
    required: null,
    repeat: null,
    questions: [],
    _method: "PUT"
})


const addSurveyForm = ref(props.survey.data.questions);
const editSurveyData = ref([]);
const isSurveryAdd = ref(false);
const isSurveySetting = ref(false);
const isEditSurveryAdd = ref(false);

function deleteSurveyForm(id) {
    const queryParams = { survey_id: props.survey.data.id };

    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(route("questions.destroy", id, queryParams), {
                onSuccess: () => {
                    reload('userexperiencesurvey.edit', props.survey.data.id);
                    SuccessDialog({ title: "You've successfully deleted a question." });
                },
            });
        },
    });
//   for (let i = 0; i < addSurveyForm.value.length; i++) {
//     if (addSurveyForm.value[i].id == id) {
//       addSurveyForm.value.splice(i, 1); // Remove the item at index i
//       break; // Exit the loop after removing the item
//     }
//   }
}

const handleEditSurveyFormSubmit = (data) => {
    let newOptions = [];
    if(data.question_type != 'SHORT_ANSWER'){
        data.options.forEach((item) => {
            newOptions.push(item);
        });
    }


    let updateData = useForm({
        "id": data.id,
        "survey_id": data.survey_id,
        "question_type": data.question_type,
        "question" : data.question,
        "order" : data.order,
        "options": data.question_type == 'SHORT_ANSWER' ? '' : JSON.stringify(newOptions)
    });

    updateData.put(route("questions.update", data.id), {
        onSuccess: () => {
            reload('userexperiencesurvey.edit', props.survey.data.id);
            SuccessDialog({ title: "You've successfully updated a question." });
        },
        onError: (error) => {
            form.setError("question_type", error?.question_type);
            form.setError("question", error?.question);
            form.setError("options", error?.options);
        },
    })
};

const openEditSurveyForm = (id) => {
    for (let i = 0; i < addSurveyForm.value.length; i++) {
        if (addSurveyForm.value[i].id == id) {
            let remodifyOptionsArray = [];

            addSurveyForm.value[i].options.forEach((item) => {
                remodifyOptionsArray.push(item.content);
            });

            editSurveyData.value = {
                "id": addSurveyForm.value[i].id,
                "survey_id": addSurveyForm.value[i].survey_id,
                "question_type": addSurveyForm.value[i].question_type,
                "question": addSurveyForm.value[i].question,
                "order": addSurveyForm.value[i].order,
                "options": remodifyOptionsArray
            }

            isEditSurveryAdd.value = true;
            break; // Exit the loop after removing the item
        }
    }
}

const handleModalSubmit = (data) => {
    addNewQuestionForm.question_type = data.question_type
    addNewQuestionForm.question = data.question
    addNewQuestionForm.options = JSON.stringify(data.options)
    addNewQuestionForm.post(route("questions.store"), {
        onSuccess: () => {
            reload('userexperiencesurvey.edit', props.survey.data.id);

            SuccessDialog({ title: "You've successfully created a new question." });
        },
        onError: (error) => {
            form.setError("question_type", error?.question_type);
            form.setError("question", error?.question);
            form.setError("options", error?.options);
        },
    })
};

const handleSettingModalSubmit = (data) => {
    form.user_type = JSON.stringify(data.user_type);
    form.appear_on = data.appear_on
    form.start_date = data.start_date
    form.end_date = data.end_date
    form.required = data.required
    form.description = props.survey.data.description
    form.repeat = data.repeat
    form.questions = addSurveyForm.value.length > 0 ? JSON.stringify(addSurveyForm.value) : null;
    form.post(route("userexperiencesurvey.update", props.survey.data.id), {
        onSuccess: () => {
            reload('userexperiencesurvey.index');
            SuccessDialog({ title: "You've successfully updated user experience survey." });
        },
        onError: (error) => {
            form.setError("title", error?.title);
            form.setError("description", error?.description);
        },
    })
};

const reload = (routeName, param) => {
    if(param != null){
        return new Promise((resolve) => {
            router.get(route(routeName, param), {
                onSuccess: () => {
                    resolve();
                },
            });
        });
    } else {
        return new Promise((resolve) => {
            router.get(route(routeName), {
                onSuccess: () => {
                    resolve();
                },
            });
        });
    }
};

const optionsWithText = (option) => {
    if (typeof option === "object" && option.content) {
        return option.content;
    } else if (typeof option === "string") {
        return option;
    } else {
        // Handle other cases if needed
        return "";
    }
}
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-between" no-gutters>
                <VCol cols="6">
                    <div class="tiggie-title mb-4 d-flex align-center">
                        {{props.survey.data.title}}
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
                <div v-if="addSurveyForm.length > 0">
                    <draggable v-model="addSurveyForm" :options="{ handle: '.drag-handle' }">
                        <template v-slot:item="{ element, index }">
                            <Vcol cols="12" :key="index">
                                <VCard style="width:81vw" class="mt-4 draggable-item"
                                >
                                    <VCardTitle class="tiggie-subtitle">
                                        <div class="d-flex justify-space-between">
                                            <div>
                                                Question {{ index + 1 }} . {{ element.question_type }}
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
                                                            <v-list-item-title class="px-5 cursor-pointer" @click="openEditSurveyForm(element.id)">Edit</v-list-item-title>
                                                            <v-spacer></v-spacer>
                                                            <v-list-item-title class="px-5 mt-2 cursor-pointer" @click="deleteSurveyForm(element.id)">Delete</v-list-item-title>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>
                                            </div>
                                        </div>
                                    </VCardTitle>
                                    <VCardSubTitle class="pl-4 tiggie-p" v-if="element.question_type != 'SHORT_ANSWER'">
                                        {{element.question}}
                                    </VCardSubTitle>
                                    <VCardSubTitle class="pl-4 tiggie-p shortanswer" v-else>
                                        {{element.question}}
                                    </VCardSubTitle>
                                    <VDivider v-if="element.question_type != 'SHORT_ANSWER'"/>
                                    <VCardText v-if="element.question_type != 'SHORT_ANSWER'">
                                        <VRow no-gutters justify="start">
                                            <VCol cols="1">
                                                <h4 class="tiggie-subtitle">Options</h4>
                                            </VCol>
                                            <VCol cols="4" style="text-align: left;" class="mb-10">
                                                <VList>
                                                    <VListItem v-for="(option, i) in element.options" :key="i">
                                                        <template #prepend>
                                                            <VIcon :icon="'mdi-circle-small'" />
                                                        </template>
                                                        <VListItemTitle class="tiggie-p">
                                                            {{ optionsWithText(option) }}
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


    <SurveyAdd v-model:isDialogVisible="isSurveryAdd"
        @submit="handleModalSubmit" />
    <EditSurveySetting v-model:isDialogVisible="isSurveySetting" :setting="props.survey.data"
        @submit="handleSettingModalSubmit" />
    <EditSurveyAdd v-model:isDialogVisible="isEditSurveryAdd" :form="editSurveyData"
        @submit="handleEditSurveyFormSubmit" />
</template>

<style scoped>
.draggable-item {
  cursor: grab;
  transition: transform 0.2s;
}
.draggable-item.is-dragging {
  cursor: grabbing;
  transform: scale(1.1);
}

.shortanswer{
    line-height: 3 !important;
}
</style>
