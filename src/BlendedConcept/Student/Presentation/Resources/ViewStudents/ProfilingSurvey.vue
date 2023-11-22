<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import debounce from "lodash/debounce";

import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

let page = usePage();

let props = defineProps(["profilingSurvey", "user"]);
const selectedOptions = ref([]);
const shortanswer = ref([]);
const validateSurvey = ref(true);

const questionsExist = computed(() => {
    return (
        props.profilingSurvey &&
        props.profilingSurvey.data &&
        props.profilingSurvey.data.questions
    );
});

const user_id = ref(props.user.id);

const form = useForm({
    results: null,
    shortanswer: null,
    type: "PROFILING",
    survey_id: props.profilingSurvey.data.id,
    user_id: user_id.value,
});

const addSurveyForm = ref(
    questionsExist.value ? props.profilingSurvey.data.questions : []
);

addSurveyForm.value.forEach((item) => {
    if (item.question_type != "SHORT_ANSWER") {
        selectedOptions.value[item.id] = [];
    } else {
        shortanswer.value[item.id] = {
            id: item.id,
            answer: "",
        };
    }
});

const onFormSubmit = () => {
    // Check if every item in selectedOptions has a value
    const isAllOptionsFilled = Object.values(selectedOptions.value).every(
        (options) => options.length > 0
    );

    // Check if every item in shortanswer has a value
    const isAllShortAnswerFilled = Object.values(shortanswer.value).every(
        (answer) => answer.answer !== ""
    );

    if (isAllOptionsFilled && isAllShortAnswerFilled) {
        // Convert the filteredSelectedOptions to JSON
        form.results = JSON.stringify(selectedOptions.value);
        form.shortanswer = JSON.stringify(shortanswer.value);

        form.post(route("surveyresponse.store"), {
            onSuccess: () => {
                SuccessDialog({
                    title: "You've successfully submitted the survey.",
                });
            },
            onError: (error) => {
                form.results = selectedOptions.value;
                form.shortanswer = shortanswer.value;
            },
        });
    } else {
        validateSurvey.value = false;
        setTimeout(() => {
            validateSurvey.value = true;
        }, 3000);
    }
};

const radioClick = (questionId, optionId) => {
    selectedOptions.value[questionId].push(optionId);
};

const checkboxClick = (questionId, optionId) => {
    const questionOptions = selectedOptions.value[questionId];

    const optionIndex = questionOptions.indexOf(optionId);

    if (optionIndex !== -1) {
        questionOptions.splice(optionIndex, 1);
    } else {
        questionOptions.push(optionId);
    }
};

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
            <VForm>
                <v-row>
                    <v-col
                        cols="12"
                        md="12"
                        class="d-flex justify-space-between align-center"
                    >
                        <div>
                            <h1 class="tiggie-title mb-4">
                                {{ props.profilingSurvey.data.title }}
                            </h1>
                            <span class="text-subtitle-1">{{
                                props.profilingSurvey.data.description
                            }}</span>
                        </div>
                    </v-col>
                    <VCol cols="12" v-for="(item, i) in addSurveyForm" :key="i">
                        <VCard
                            style="width: 60vw"
                            class="mt-4 question-card">
                            <VCardTitle class="tiggie-subtitle">
                                <div class="d-flex justify-space-between">
                                    <span class="question-text">
                                        <strong
                                            class="pppangram-bold question-label"
                                            >Question {{ i + 1 }} :
                                        </strong>
                                        {{ item.question }}
                                        {{ questionType(item.question_type) }}
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
                                                <VCheckbox
                                                    @click="
                                                        checkboxClick(
                                                            item.id,
                                                            option.id
                                                        )
                                                    "
                                                    :value="option.id"
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
                            <VRow no-gutters justify="start" v-else>
                                <VCol cols="12">
                                    <VTextarea
                                        v-model="shortanswer[item.id].answer"
                                        placeholder="Please Type here ...."
                                        auto-grow
                                        rows="5"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.answer"
                                    />
                                </VCol>
                            </VRow>
                        </VCard>
                    </VCol>
                    <v-col cols="12">
                        <div v-if="!validateSurvey" class="text-center">
                            <span class="error-message pppangram-bold"
                                >All Questions need to answer.</span
                            >
                        </div>
                        <div class="d-flex justify-center mt-5">
                            <Link
                                :href="
                                    route(
                                        'teacher_students.show',
                                        props.user.student.student_id
                                    )
                                "
                            >
                                <v-btn
                                    variant="flat"
                                    rounded
                                    class="mr-4 text-primary"
                                    width="200"
                                    color="rgba(55, 73, 233, 0.10)"
                                    >Cancel</v-btn
                                >
                            </Link>
                            <v-btn
                                @click="onFormSubmit"
                                variant="flat"
                                rounded
                                width="200"
                                color="primary"
                                class="text-white"
                                >Submit</v-btn
                            >
                        </div>
                    </v-col>
                </v-row>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.question-label {
    font-size: 25px !important;
}

.error-message {
    color: red !important;
}

.question-text {
    font-size: 25px !important;
}

.question-card {
    /* border: none; */
    box-shadow: none;
    background: #f7f7f9 !important;
}

.question-option {
    background: #f7f7f9 !important;
}

.question-option > VListItem {
    background: #f7f7f9 !important;
}
</style>
