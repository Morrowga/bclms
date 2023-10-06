<script setup>
const isDialogVisible = ref(true);
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

const props = defineProps({
    data: {
        type: Object,
    },
});

const selectedOptions = ref([]);

const questionsExist = computed(() => {
  return props.data && props.data && props.data.questions;
});

const addSurveyForm = ref(questionsExist.value ? props.data.questions : []);

addSurveyForm.value.forEach((item) => {
  selectedOptions.value[item.id] = [];
});

const radioClick = (questionId, optionId) => {
    console.log(questionId);
  // Reset the selectedOptions array for this question
  selectedOptions.value[questionId] = [optionId];
  console.log(selectedOptions.value);
};

</script>

<template>
    <VDialog v-model="isDialogVisible" width="70%">
        <!-- Activator -->
        <!-- <template #activator="{ props }">
            <VBtn v-bind="props"> UserExperiencSurvey </VBtn>
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
                        <VCol cols="6">
                            <VRow>
                                <VCol v-for="(option,index) in question.options" :key="index" cols="2">
                                    <div class="d-flex flex-column justify-center">
                                        <VLabel class="tiggie-label-custome fs-20"
                                            >{{  option.content  }}</VLabel
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
            </VCardText>

            <VCardText>
                <h4 class="tiggie-label mt-16 mb-4 s-24">
                    Did you encounter any difficulties while using TiggieKids ?
                    If yes, please specify.
                    <span class="text-candy-red">*</span>
                </h4>
                <VRow class="mb-4">
                    <VCol cols="6" class="d-flex">
                        <v-radio label="Yes" value="yes" class="ma-0"></v-radio>
                    </VCol>
                    <VCol cols="6" class="d-flex">
                        <v-radio label="No" value="no" class="ma-0"></v-radio>
                    </VCol>
                </VRow>
                <!-- <VTextarea
                    placeholder="Please Type here ...."
                    auto-grow
                    rows="5"
                /> -->
            </VCardText>

            <!-- <VCardText>
                <h4 class="tiggie-label mt-16 fs-24">
                    How likely are you to recommend TiggieKids to a friend or
                    colleague? <span class="text-candy-red">*</span>
                </h4>

                <VRow class="mt-10" align="center">
                    <VCol cols="3">
                        <VLabel class="tiggie-label-custome fs-20">
                            Not likely at all
                        </VLabel>
                    </VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel class="tiggie-label-custome fs-20"
                                        >1</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel class="tiggie-label-custome fs-20"
                                        >2</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel class="tiggie-label-custome fs-20"
                                        >3</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel class="tiggie-label-custome fs-20"
                                        >4</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel class="tiggie-label-custome fs-20"
                                        >5</VLabel
                                    >
                                    <VRadio value="1" size="20" />
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
            </VCardText> -->

            <VCardText>
                <h4 class="tiggie-label mt-16 mb-10 fs-24">
                    Is there any additional feedback you's like to provide about
                    your experience with TiggieKids ?
                    <span class="text-candy-red">*</span>
                </h4>
                <VTextarea
                    placeholder="Please Type here ...."
                    auto-grow
                    rows="5"
                />
            </VCardText>

            <VCardActions>
                <VRow justify="center">
                    <VCol cols="3">
                        <SecondaryBtn title="Cancel" />
                    </VCol>
                    <VCol cols="3">
                        <PrimaryBtn title="Submit" />
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

:deep(.v-radio) {
    font-size: 16px;
    /* Adjust the font size as needed */
    width: 32px;
    /* Adjust the width as needed */
    height: 32px;
    /* Adjust the height as needed */
}
</style>
