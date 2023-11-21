<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { format } from "date-fns";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
const props = defineProps(["surveyresponse", 'user']);
const selectedValue = ref(null);
const questions = ref([]);

const formatDate = (dateString) => {
    // Parse the date string into a Date object
    const date = new Date(dateString);
    // Format the date using date-fns
    return format(date, "dd/M/yyyy, hh:mm:ss a"); // Customize the format string as needed
};

if(props.surveyresponse.data.responses?.length > 0){
    props.surveyresponse.data.responses.forEach((item) => {
        console.log(item);
        if(item.question.question_type == 'SINGLE_CHOICE'){
            let questionWithAnswerOptionId = {
                ...item.question,
                answer_option_id: item.options?.length > 0 ? item.options[0].id : null,
                response_date: formatDate(item.response_datetime)
            };

            questions.value.push(questionWithAnswerOptionId);
        } else if(item.question.question_type == 'SINGLE_CHOICE'){
            let questionWithAnswerOptionId = {
                ...item.question,
                answer_option_id: item.options?.length > 0 ? item.options[0].id : null,
                response_date: formatDate(item.response_datetime)
            };

            questions.value.push(questionWithAnswerOptionId);
        } else if(item.question.question_type == 'MULTIPLE_RESPONSE') {
            let multipleOptionArray = [];
            if(item.options?.length > 0){
                    item.options.forEach((option) => {
                    multipleOptionArray.push(option.id);
                })
            }

            let questionWithAnswerOptionId = {
                ...item.question,
                answer_option_id: multipleOptionArray,
                response_date: formatDate(item.response_datetime)
            };
            questions.value.push(questionWithAnswerOptionId);
        } else if(item.question.question_type == 'SHORT_ANSWER'){
            let questionWithAnswerOptionId = {
                ...item.question,
                answer_option_id: item.answer,
                response_date: formatDate(item.response_datetime)
            };

            questions.value.push(questionWithAnswerOptionId);
        }
    });
}

const addSurveyForm = ref(
    questions.value.length > 0 ? questions.value : []
);

console.log(questions.value);

const questionType = (questionType) => {
    if (questionType === "SINGLE_CHOICE" || questionType === "Rating") {
        return "[Choose one option]";
    } else if (questionType === "MULTIPLE_RESPONSE") {
        return "[Please select all that apply]";
    }
};

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="4">
                    <h1 class="tiggie-title">
                        {{ props.surveyresponse.data.title }}
                    </h1>
                </VCol>
                <VCol cols="4" class="mt-2">
                    <span class="survey_name font-weight-bold text-black text-capitalize">
                        {{ props.user.full_name }}
                    </span>
                </VCol>

                <v-spacer></v-spacer>

                <div v-if="addSurveyForm.length > 0">
                    <VCol cols="12" v-for="(item, i) in addSurveyForm" :key="i">
                        <VCard style="width: 81vw" class="mt-4 question-card">
                            <VCardTitle class="tiggie-subtitle">
                                <div class="d-flex justify-space-between">
                                    <span class="question-text mt-2">
                                        <strong
                                            class="pppangram-bold question-label"
                                            >Question {{ i + 1 }} :
                                        </strong>
                                        {{ item.question }}
                                    </span>
                                    <span class="pppangram responseDate">
                                        <VIcon icon="mdi-clock" class="mr-2 mb-1"></VIcon>{{  item.response_date  }}
                                    </span>
                                </div>
                            </VCardTitle>
                            <VRow
                                no-gutters
                                justify="start"
                                v-if="
                                    item.question_type === 'MULTIPLE_RESPONSE'
                                "
                            >
                                <VCol
                                    cols="12"
                                    v-for="(option, i) in item.options"
                                    :key="i"
                                    style="text-align: left"
                                >
                                    <VList class="question-option">
                                        <VListItem>
                                            <template #prepend>
                                                <v-checkbox
                                                    @click="
                                                        checkboxClick(
                                                            item.id,
                                                            option.id
                                                        )
                                                    "
                                                    v-model="item.answer_option_id"
                                                    :value="option.id"
                                                    :disabled="true"
                                                />
                                            </template>
                                            <VListItemTitle class="tiggie-p">
                                                <span>{{
                                                    option.content
                                                }}</span>
                                            </VListItemTitle>
                                        </VListItem>
                                    </VList>
                                </VCol>
                            </VRow>
                            <VRow
                                no-gutters
                                justify="start"
                                v-else-if="
                                    item.question_type === 'SINGLE_CHOICE' ||
                                    item.question_type === 'RATING'
                                "
                            >
                                <VCol
                                    cols="12"
                                    v-for="(option, i) in item.options"
                                    :key="i"
                                    style="text-align: left"
                                >
                                    <VList class="question-option">
                                        <VListItem>
                                            <template #prepend>
                                                <VRadio
                                                    :value="option.id"
                                                    @click="
                                                        radioClick(
                                                            item.id,
                                                            option.id
                                                        )
                                                    "
                                                    v-model="item.answer_option_id"
                                                    :disabled="true"
                                                />
                                            </template>
                                            <VListItemTitle class="tiggie-p">
                                                <span>{{
                                                    option.content
                                                }}</span>
                                            </VListItemTitle>
                                        </VListItem>
                                    </VList>
                                </VCol>
                            </VRow>
                            <VRow no-gutters justify="start" v-else-if="
                                    item.question_type === 'SHORT_ANSWER'
                            ">
                                <VCol cols="12">
                                    <p class="mx-5">{{item.answer_option_id}}</p>
                                </VCol>
                            </VRow>
                        </VCard>
                    </VCol>
                </div>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.survey_name {
    font-size: 26px !important;
}

.responseDate{
    font-size: 15px !important;
    opacity: 0.4;
}

.question-card{
    box-shadow: 2px 7px 6px rgb(0,0,0,0.3) !important;
}
</style>
