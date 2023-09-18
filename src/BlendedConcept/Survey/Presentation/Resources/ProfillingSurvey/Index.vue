<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";
import SurveyAdd from "./components/SurveyAdd.vue";
import EditSurveyAdd from "./components/EditSurveyAdd.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

let props = defineProps(['survey']);

let addNewQuestionForm = useForm({
    "survey_id" : props.survey.data.id,
    "question_type" : null,
    "question" : null,
    "options" : null,
    "type": "profiling"
})

const questionsExist = computed(() => {
  return props.survey && props.survey.data && props.survey.data.questions;
});

const addSurveyForm = ref(questionsExist.value ? props.survey.data.questions : []);
const editSurveyData = ref([]);
const isSurveryAdd = ref(false);
const isEditSurveryAdd = ref(false);

function deleteSurveyForm(id) {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete('questions/' + id + '?type=profiling', {
                onSuccess: () => {
                    reload('profilling_survey.index');
                    SuccessDialog({ title: "You've successfully deleted a question." });
                },
            });
        },
    });
}

const handleEditSurveyFormSubmit = (data) => {
    console.log(data);
    let newOptions = [];
    data.options.forEach((item) => {
        newOptions.push(item);
    });

    let updateData = useForm({
        "id": data.id,
        "survey_id": data.survey_id,
        "question_type": data.question_type,
        "question" : data.question,
        "options": JSON.stringify(newOptions),
        "type": "profiling"
    });

    updateData.put(route("questions.update", data.id), {
        onSuccess: () => {
            reload('profilling_survey.index');
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
            reload('profilling_survey.index');

            SuccessDialog({ title: "You've successfully created a new question." });
        },
        onError: (error) => {
            form.setError("question_type", error?.question_type);
            form.setError("question", error?.question);
            form.setError("options", error?.options);
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
            <v-row>
                <v-col
                    cols="12"
                    md="12"
                    class="d-flex justify-space-between align-center"
                >
                    <div>
                        <h1 class="tiggie-title mb-4">{{props.survey.data.title}}</h1>
                        <span class="text-subtitle-1"
                            >{{props.survey.data.description}}</span
                        >
                    </div>
                    <div>
                        <VBtn @click="isSurveryAdd = true">Add New</VBtn>
                    </div>
                </v-col>
                <Vcol cols="12" v-for="(item, i) in addSurveyForm" :key="i">
                    <VCard style="width:81vw" class="mt-4 draggable-item"
                    >
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
                                                {{ optionsWithText(option) }}
                                            </VListItemTitle>
                                        </VListItem>
                                    </VList>
                                </VCol>
                            </VRow>
                        </VCardText>
                    </VCard>
                </Vcol>
                <!-- <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 2:</span
                    >
                    <span class="text-h6 t-black">
                        How would you rate the student's overall level of
                        independence in daily activities? (Choose one option)
                        *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly independent - The student can complete most activities with minimal assistance"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderately independent - The student requires some support but can handle many activities independently"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Partially independent - The student needs significant assistance in several activities"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly dependent - The student relies heavily on others for daily activities"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 3:</span
                    >
                    <span class="text-h6 t-black">
                        In the academic setting, what specific challenges does
                        the student face due to their special needs? (Please
                        select all that apply) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with reading or comprehension"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Challenges with writing or fine motor skills
"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Trouble with focus and attention"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Social interaction difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Sensory sensitivities or sensory processing issues"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Communication challenges"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Physical mobility limitations"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Emotional regulation or self-regulation difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with organization and time management"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 4:</span
                    >
                    <span class="text-h6 t-black">
                        How does the student respond to changes in their routine
                        or unexpected situations? (Choose one option) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Adapts well - The student shows flexibility and copes effectively with changes"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderate response - The student may experience some initial discomfort but can adjust with support"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Difficulty adapting - The student struggles with changes and may need significant reassurance and guidance"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Severe response - The student becomes highly distressed and requires intensive support to navigate changes"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12"> </v-col> -->
            </v-row>
        </VContainer>
        <SurveyAdd v-model:isDialogVisible="isSurveryAdd"
        @submit="handleModalSubmit" />
        <EditSurveyAdd v-model:isDialogVisible="isEditSurveryAdd" :form="editSurveyData"
            @submit="handleEditSurveyFormSubmit" />
    </AdminLayout>
</template>
<style scoped></style>
