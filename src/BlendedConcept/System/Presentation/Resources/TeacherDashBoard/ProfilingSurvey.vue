<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { router } from "@inertiajs/core";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
let props = defineProps(["profilingSurvey"]);
const data = ref(props.profilingSurvey.data);
let page = usePage();
const cardValue = ref(0);
let user_id = computed(() => page.props.user_info.user_detail.id);

const isError = ref(false);
const form = useForm({
    results: null,
    shortanswer: null,
    type: "PROFILING",
    survey_id: data.value.id,
    user_id: user_id.value,
});

const selectedOptions = ref([]);
const shortanswer = ref([]);

const questionsExist = computed(() => {
    return data.value && data.value && data.value.questions;
});

const addSurveyForm = ref(questionsExist.value ? data.value.questions : []);

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

const current = ref(((cardValue.value + 1) / addSurveyForm.value.length) * 100)

const checkValue = () => {
    const allArraysHaveValues = selectedOptions.value.every(
        (options) => options.length > 0
    );

    if (allArraysHaveValues) {
        return true;
    } else {
        return false;
    }
};

const checkboxClick = (questionId, optionId) => {
    const questionOptions = selectedOptions.value[questionId];

    const optionIndex = questionOptions.indexOf(optionId);

    if (optionIndex !== -1) {
        questionOptions.splice(optionIndex, 1);
    } else {
        questionOptions.push(optionId);
    }

    //   console.log(selectedOptions.value);
};

const back = () => {
    cardValue.value = Math.max(cardValue.value - 1, 0)
    current.value = ((cardValue.value + 1) / addSurveyForm.value.length) * 100;
    console.log(cardValue.value);
}

const next = () => {
    cardValue.value = Math.min(cardValue.value + 1, addSurveyForm.value.length - 1)
    current.value = ((cardValue.value + 1) / addSurveyForm.value.length) * 100;
    console.log(cardValue.value);
}

const radioClick = (questionId, optionId) => {
    selectedOptions.value[questionId] = [optionId];
};

const onFormSubmit = () => {
    if (checkValue()) {
        isError.value = false;
        // Convert the filteredSelectedOptions to JSON
        form.results = JSON.stringify(selectedOptions.value);
        form.shortanswer = JSON.stringify(shortanswer.value);

        form.post(route("surveyresponse.store"), {
            onSuccess: () => {
                SuccessDialog({
                    title: "You've successfully submited profiling survey.",
                });
            },
            onError: (error) => {
                form.results = selectedOptions.value;
                form.shortanswer = shortanswer.value;
            },
        });
    } else {
        isError.value = true;
    }
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="text-center d-flex justify-center">
                <div class="surveylabel">
                    <h1 class="tiggie-label fs-30 text-white">User Profiling Survey</h1>
                </div>
            </div>
            <VCard class="profiling-card mt-10">
                <VCardText>
                    <div class="my-2">
                        <div class="d-flex justify-center margin-10">
                            <span><strong class="text-EC5F65">{{ cardValue + 1 }}</strong>/ {{ addSurveyForm.length }}</span>
                        </div>
                        <div class="d-flex justify-center">
                            <div class="width-25">
                                <v-progress-linear
                                    v-model="current"
                                    color="#EC5F65"
                                    height="10"
                                >
                                </v-progress-linear>
                            </div>
                        </div>
                        <v-carousel
                            :show-arrows="false"
                            hide-delimiters
                            v-model="cardValue"
                        >
                            <v-carousel-item
                                v-for="(question, i) in addSurveyForm"
                                :key="i"
                                class="d-flex align-center"
                            >
                                <v-sheet
                                :color="'#ffffff'"
                                tile
                                >
                                <div v-if="question.question_type == 'SINGLE_CHOICE'">
                                    <h4 class="tiggie-label mb-10 fs-24 text-center">
                                        {{ question.question }}
                                        <span class="text-candy-red">*</span>
                                    </h4>

                                    <VRow class="margin-10" align="center">
                                        <VCol cols="12" class="d-flex justify-center">
                                            <div
                                                v-for="(option, index) in question.options"
                                                :key="index"
                                            >
                                                <div
                                                    class="text-center mx-5"
                                                >
                                                    <p
                                                        class="tiggie-label-custome fs-20"
                                                        >{{ option.content }}</p
                                                    >
                                                    <div class="text-center d-flex justify-center">
                                                        <v-radio
                                                            class="custom-radio"
                                                            v-model="selectedOptions[question.id]"
                                                            :value="option.id"
                                                            @click="
                                                                radioClick(
                                                                    question.id,
                                                                    option.id
                                                                )
                                                            "
                                                        ></v-radio>
                                                    </div>
                                                </div>
                                            </div>
                                        </VCol>
                                    </VRow>
                                </div>
                                <div v-if="question.question_type == 'RATING'">
                                    <h4 class="tiggie-label fs-24 text-center">
                                        {{ question.question }}
                                        <span class="text-candy-red">*</span>
                                    </h4>

                                    <VRow class="margin-10" align="center">
                                        <VCol cols="3" class="text-center">
                                            <p class="tiggie-label-custome fs-20 font-weight-bold text-dark">
                                                Not satisfied at all
                                            </p>
                                        </VCol>
                                        <VCol cols="6">
                                            <VRow class="d-flex justify-center">
                                                <VCol
                                                    v-for="(option, index) in question.options"
                                                    :key="index"
                                                    cols="2"
                                                >
                                                    <div
                                                        class="text-center"
                                                    >
                                                        <VLabel
                                                            class="tiggie-label-custome fs-20"
                                                            >{{ option.content }}</VLabel
                                                        >
                                                        <VRadio
                                                            v-model="
                                                                selectedOptions[question.id]
                                                            "
                                                            :value="option.id"
                                                            @click="
                                                                radioClick(
                                                                    question.id,
                                                                    option.id
                                                                )
                                                            "
                                                        />
                                                    </div>
                                                </VCol>
                                            </VRow>
                                        </VCol>
                                        <VCol cols="2">
                                            <VLabel class="tiggie-label-custome fs-20 font-weight-bold text-dark">
                                                Extremely Satisfied
                                            </VLabel>
                                        </VCol>
                                    </VRow>
                                </div>
                                <div v-if="question.question_type == 'MULTIPLE_RESPONSE'">
                                    <h4 class="tiggie-label mt-5 fs-24 text-center">
                                        {{ question.question }}
                                        <span class="text-candy-red">*</span>
                                    </h4>

                                    <VRow class="mt-10" align="center">
                                        <VCol cols="12">
                                            <VRow class="d-flex justify-center">
                                                <VCol
                                                    v-for="(option, index) in question.options"
                                                    :key="index"
                                                    cols="2"
                                                >
                                                    <div
                                                        class="text-center"
                                                    >
                                                        <VLabel
                                                            class="tiggie-label-custome fs-20"
                                                            >{{ option.content }}</VLabel
                                                        >
                                                        <VCheckbox
                                                            class="v-checkbox"
                                                            @click="
                                                                checkboxClick(
                                                                    question.id,
                                                                    option.id
                                                                )
                                                            "
                                                            :value="option.id"
                                                        />
                                                    </div>
                                                </VCol>
                                            </VRow>
                                        </VCol>
                                    </VRow>
                                </div>
                                <div v-if="question.question_type == 'SHORT_ANSWER'">
                                    <VCardText>
                                        <h4 class="tiggie-label mt-16 mb-10 fs-24 text-center">
                                            {{ question.question }}
                                            <span class="text-candy-red">*</span>
                                        </h4>

                                        <VTextarea
                                            v-model="shortanswer[question.id].answer"
                                            placeholder="Please Type here ...."
                                            auto-grow
                                            rows="5"
                                            :rules="[requiredValidator]"
                                            :error-messages="form?.errors?.answer"
                                        />
                                    </VCardText>
                                </div>
                                <VCardActions>
                                <VRow justify="center" class="margin-10" v-if="cardValue === addSurveyForm.length - 1">
                                    <VCol cols="3">
                                        <PrimaryBtn
                                            :block="data.required"
                                            @click="onFormSubmit"
                                            :isLink="false"
                                            type="button"
                                            title="Submit"
                                        />
                                    </VCol>
                                </VRow>
                            </VCardActions>
                                </v-sheet>
                            </v-carousel-item>
                        </v-carousel>
                        <VCardText>
                            <div class="mt-5 text-center">
                                <span v-if="isError" class="error-text pppangram-bold"
                                    >You need to fill all surveys</span
                                >
                            </div>
                        </VCardText>
                        <div class="d-flex justify-center align-center">
                            <img src="/images/frontarrow.png" @click="back()" class="cursor-pointer" width="30" alt="">
                            <p class="mx-3 fs-20 mt-4">{{ cardValue + 1 }} / {{ addSurveyForm.length }}</p>
                            <img src="/images/backarrow.png" @click="next()" class="cursor-pointer" width="30"  alt="">
                        </div>
                    </div>
                </VCardText>
            </VCard>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
:deep(.tiggie-label-custome fs-20) {
    color: #282828 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 20px !important;
}

.error-text {
    color: red !important;
}

.surveylabel{
    border: 2px solid #3E67AF;
    padding: 5vh;
    width: 50%;
    position: absolute;
    background: #3E67AF;
    z-index: 1;
}

.profiling-card{
    border: 3px solid #3E67AF;
    overflow: hidden !important;
}

:deep(.v-radio) {
   display: flex;
   justify-content: center;
}

:deep(.v-checkbox) {
   display: flex;
   justify-content: center;
}


.margin-10{
    margin-top: 10vh;
}

.width-25{
    width: 25%;
}

.text-EC5F65{
    color: #EC5F65;
}

/* Hide the SVG icon when the radio button is checked */
:deep(.v-radio > div > div > svg) {
  padding: 18px;
  border-radius: 50%;
  color: #fff;
  background: #3749E9;
}

:deep(.v-checkbox > div > div > div > div >  svg) {
  padding: 18px;
  border-radius: 50%;
  color: #fff;
  background: #3749E9;
}

:deep(.v-radio > div > div) {
    border: 2px solid #ADADAD;
}
</style>
