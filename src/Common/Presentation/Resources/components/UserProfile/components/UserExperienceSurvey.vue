<script setup>
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { useForm,usePage } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import { router } from "@inertiajs/core";

let page = usePage();

const props = defineProps({
    data: {
        type: Object,
    },
    hasSurvey: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:hasSurvey"]);

console.log(props.hasSurvey);

let user_id = computed(() => page.props.user_info.user_detail.id);
const isError = ref(false);

const form = useForm({
    results: null,
    shortanswer: null,
    type: 'USEREXP',
    survey_id: props.data.id,
    user_id: user_id.value
})

const selectedOptions = ref([]);
const  shortanswer = ref([]);

const questionsExist = computed(() => {
  return props.data && props.data && props.data.questions;
});

const closeModal = () => {
    console.log('asd');
    emit("update:hasSurvey", false);
};

const addSurveyForm = ref(questionsExist.value ? props.data.questions : []);

addSurveyForm.value.forEach((item) => {
    if(item.question_type != 'SHORT_ANSWER'){
        selectedOptions.value[item.id] = [];
    } else {
        shortanswer.value[item.id] = {
            "id": item.id,
            "answer" : ''
        };
    }
});

const checkValue = () => {
    const allArraysHaveValues = selectedOptions.value.every((options) => options.length > 0);

    if (allArraysHaveValues) {
        return true
    } else {
        return false
    }
}

const checkboxClick = (questionId, optionId) => {
  const questionOptions = selectedOptions.value[questionId];

  const optionIndex = questionOptions.indexOf(optionId);

  if (optionIndex !== -1) {
    questionOptions.splice(optionIndex, 1);
  } else {
    questionOptions.push(optionId);
  }

  console.log(selectedOptions.value);
};


const radioClick = (questionId, optionId) => {
    console.log(questionId);
  // Reset the selectedOptions array for this question
  selectedOptions.value[questionId] = [optionId];
  console.log(selectedOptions.value);
};


const logout = () => {
    const PREFIX =
        (localStorage.getItem("tenant") != "" || Object.is(localStorage.getItem('tenant',null)))
            ? `/${localStorage.getItem("tenant")}`
            : "";
    localStorage.removeItem("menu_title");

    if(localStorage.getItem("tenant") != "" || Object.is(localStorage.getItem('tenant',null)))
    {
        router.post('/logout');
    }

    else
    {
        router.post(`${PREFIX}/logout`);
    }

};

const onFormSubmit = () => {
    if(checkValue()){
        isError.value = false;
        form.results = JSON.stringify(selectedOptions.value);
        form.shortanswer = JSON.stringify(shortanswer.value);

        form.post(route("surveyresponse.store"), {
            onSuccess: () => {
                emit("update:hasSurvey", false);
                logout();
            },
            onError: (error) => {
                form.results = selectedOptions.value;
                form.shortanswer = shortanswer.value;
            }
        })
    } else {
        isError.value = true;
    }
}

const dialogVisibleUpdate = (val) => {
    emit("update:hasSurvey", val);
};
</script>

<template>
    <VDialog
    :model-value="props.hasSurvey"
    @update:model-value="dialogVisibleUpdate"
    width="70%" :persistent="props.data.required == true">
        <!-- Activator -->
        <!-- <template #activator="{ props }">
            <VBtn v-bind="props"> UserExperienceSurvey </VBtn>
        </template> -->
        <!-- Dialog Content -->
            <VCard class="pa-16">
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isDialogVisible = false"
                />

                <VCardTitle class="">
                    <h1 class="tiggie-label fs-40">{{ props.data.title}}</h1>
                </VCardTitle>

                <VCardText v-for="(question,i) in addSurveyForm" :key="i">
                    <div v-if="question.question_type == 'SINGLE_CHOICE'">
                        <h4 class="tiggie-label mt-10 mb-10 fs-24">
                        {{question.question}} <span class="text-candy-red">*</span>
                        </h4>

                        <VRow class="mt-10" align="center">
                            <VCol cols="12">
                                <VRow>
                                    <VCol v-for="(option,index) in question.options" :key="index" cols="6">
                                        <div class="d-flex flex-column justify-center">
                                            <VLabel class="tiggie-label-custome fs-20"
                                                >{{  option.content  }}</VLabel
                                            >
                                            <VRadio
                                            v-model="selectdOptions[question.id]"
                                            :value="option.id"
                                            @click="radioClick(question.id, option.id)"
                                            />
                                        </div>
                                    </VCol>
                                </VRow>
                            </VCol>
                        </VRow>
                    </div>
                    <div v-if="question.question_type == 'RATING'">
                        <h4 class="tiggie-label mt-5 fs-24">
                            {{ question.question }} <span class="text-candy-red">*</span>
                        </h4>

                        <VRow class="mt-10" align="center">
                            <VCol cols="3">
                                <VLabel class="tiggie-label-custome fs-20">
                                    Not likely at all
                                </VLabel>
                            </VCol>
                            <VCol cols="6">
                                <VRow>
                                    <VCol v-for="(option,index) in question.options" :key="index" cols="2">
                                        <div class="d-flex flex-column justify-center">
                                            <VLabel class="tiggie-label-custome fs-20"
                                                >{{ option.content }}</VLabel
                                            >
                                            <VRadio
                                            v-model="selectedOptions[question.id]"
                                            :value="option.id"
                                            @click="radioClick(question.id, option.id)"
                                            />
                                        </div>
                                    </VCol>
                                </VRow>
                            </VCol>
                            <VCol cols="2">
                                <VLabel class="tiggie-label-custome fs-20">
                                    Extremely Likely
                                </VLabel>
                            </VCol>
                        </VRow>
                    </div>
                    <div v-if="question.question_type == 'MULTIPLE_RESPONSE'">
                        <h4 class="tiggie-label mt-5 fs-24">
                            {{ question.question }} <span class="text-candy-red">*</span>
                        </h4>

                        <VRow class="mt-10" align="center">
                            <VCol cols="6">
                                <VRow>
                                    <VCol v-for="(option,index) in question.options" :key="index" cols="2">
                                        <div class="d-flex flex-column justify-center">
                                            <VLabel class="tiggie-label-custome fs-20"
                                                >{{ option.content }}</VLabel
                                            >
                                            <VCheckbox
                                            @click="checkboxClick(question.id, option.id)" :value="option.id" />
                                        </div>
                                    </VCol>
                                </VRow>
                            </VCol>
                        </VRow>
                    </div>
                    <div v-if="question.question_type == 'SHORT_ANSWER'">
                        <VCardText>
                            <h4 class="tiggie-label mt-16 mb-10 fs-24">
                                {{ question.question }}
                                <span class="text-candy-red">*</span>
                            </h4>

                            <VTextarea
                                v-model="shortanswer[question.id].answer"
                                :rules="[requiredValidator]" :error-messages="form?.errors?.answer"
                                placeholder="Please Type here ...."
                                auto-grow
                                rows="5"
                            />
                        </VCardText>
                    </div>
                </VCardText>
                <VCardText>
                    <div class="mt-5 text-center">
                        <span v-if="isError" class="error-text pppangram-bold">You need to fill all surveys</span>
                    </div>
                </VCardText>
                <VCardActions>
                    <VRow justify="center">
                        <VCol cols="3">
                            <SecondaryBtn type="button" @click="closeModal" title="Cancel"  />
                        </VCol>
                        <VCol :cols="'3'">
                            <PrimaryBtn
                            @click="onFormSubmit" :isLink="false"
                            type="button" title="Submit & Logout" />
                        </VCol>
                        <VCol :cols="'3'" v-if="!props.data.required">
                            <PrimaryBtn
                            @click="logout" :isLink="false"
                            type="button" title="Logout" />
                        </VCol>
                    </VRow>
                </VCardActions>
            </VCard>
    </VDialog>
</template>

<style scoped>
:deep(.tiggie-label-custome fs-20) {
    color: #282828 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 20px !important;
}

.error-text{
    color: red !important;
}

:deep(.v-radio) {
    font-size: 16px;
    /* Adjust the font size as needed */
    width: 32px;
    /* Adjust the width as needed */
    height: 32px;
    /* Adjust the height as needed */
}
</style>
