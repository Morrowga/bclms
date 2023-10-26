<script setup>
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import axios from "axios";
import { useForm, usePage } from "@inertiajs/vue3";
const props = defineProps({
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["submit", "update:isDialogVisible"]);

const options = ref([""]);

const HideOption = ref(false);

console.log(options.value);

const randomCombination = ref("");

const generateRandomCombination = () => {
    const characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let result = "";

    for (let i = 0; i < 4; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        result += characters.charAt(randomIndex);
    }

    randomCombination.value = result;
};

generateRandomCombination();

const form = useForm({
    id: randomCombination.value,
    question_type: null,
    question: "",
    options: options.value,
});

const addOption = () => {
    options.value.push("");
};

const removeOption = (index) => {
    options.value.splice(index, 1);
};
const refForm = ref(null); // Define refForm

const onFormSubmit = () => {
    form.options = options.value;
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            emit("submit", form);
            generateRandomCombination();
            form.id = randomCombination.value; // Assuming id should be cleared
            form.question_type = null;
            form.question = "";
            options.value = [""]; // Reset options as needed
            form.options = options.value;
            emit("update:isDialogVisible", false);
        }
    });
};

const onFormReset = () => {
    emit("update:isDialogVisible", false);
};
const dialogVisibleUpdate = (val) => {
    emit("update:isDialogVisible", val);
};

const items = ref([
    {
        title: "Single Choice",
        value: "SINGLE_CHOICE",
    },
    {
        title: "Multi Response",
        value: "MULTIPLE_RESPONSE",
    },
    {
        title: "Rating",
        value: "RATING",
    },
    {
        title: "Short Answer",
        value: "SHORT_ANSWER",
    },
]);

watch(
    () => form.question_type,
    (newValue, oldValue) => {
        if (newValue === "SHORT_ANSWER") {
            HideOption.value = true;
        } else {
            HideOption.value = false;
        }
    }
);
</script>

<template>
    <VDialog
        :width="$vuetify.display.smAndDown ? 'auto' : 600"
        :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate"
    >
        <VCard class="">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <!-- <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Add Survey Question
                </VCardTitle>
            </VCardItem> -->

            <VCardText>
                <!-- 👉 Form -->
                <VForm
                    class="mt-6"
                    ref="refForm"
                    @submit.prevent="onFormSubmit"
                >
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Question Type</VLabel
                                >
                                <!-- <VTextField /> -->
                                <VSelect
                                    v-model="form.question_type"
                                    :items="items"
                                    rounded="50%"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.question_type
                                    "
                                    placeholder="Select Question Type"
                                    density="compact"
                                />
                            </VCol>

                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Question</VLabel>
                                <VTextarea
                                    v-model="form.question"
                                    placeholder="Type here ...."
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.question"
                                    rows="5"
                                />
                            </VCol>
                            <VCol cols="12" md="12" v-if="!HideOption">
                                <VLabel class="tiggie-label">Options</VLabel>
                                <VRow>
                                    <VCol
                                        cols="12"
                                        v-for="(option, index) in options"
                                        :key="index"
                                    >
                                        <div class="option-container">
                                            <VIcon
                                                @click="removeOption(index)"
                                                icon="mdi-minus-circle"
                                                size="md"
                                                class="removeoption-btn"
                                            ></VIcon>
                                            <!-- <VBtn  size="sm" append-icon="mdi-minus-circle" rounded></VBtn> -->
                                            <VTextField
                                                v-model="options[index]"
                                                :rules="[requiredValidator]"
                                                :error-messages="
                                                    form?.errors?.options
                                                "
                                            />
                                        </div>
                                    </VCol>
                                </VRow>
                            </VCol>
                            <VCol cols="12" md="12" v-if="!HideOption">
                                <VBtn
                                    variant="outlined"
                                    style="
                                        border-radius: 5px;
                                        border: 1px dashed rgba(40, 40, 40, 0.5);
                                    "
                                    block
                                    @click="addOption"
                                >
                                    <span class="pppangram-bold typemore"
                                        >Type to add more options</span
                                    >
                                </VBtn>
                            </VCol>

                            <!-- 👉 Submit and Cancel -->
                            <VCol
                                cols="12"
                                class="d-flex flex-wrap justify-space-between gap-10 pt-8"
                            >
                                <VBtn
                                    color="gray"
                                    text-color="white"
                                    height="58"
                                    class="pl-16 pr-16"
                                    @click="onFormReset"
                                >
                                    <span class="text-white">Cancel</span>
                                </VBtn>

                                <VBtn
                                    type="submit"
                                    height="58"
                                    class="pl-16 pr-16"
                                >
                                    Save
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VContainer>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
<style scoped>
.a-survey-border {
    border-radius: 5px !important;
    border: 1px dashed rgba(40, 40, 40, 0.5) !important;
}

.typemore {
    color: rgba(40, 40, 40, 0.5) !important;
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}

.option-container {
    position: relative; /* Make the container a positioning context */
}
.removeoption-btn {
    position: absolute;
    right: -1%;
    top: -20%;
    width: 20px;
    cursor: pointer;
    z-index: 1;
    height: 20px;
    color: #000;
    border-radius: 50%; /* Makes the button circular */
    /* padding: 5px !important; */
    text-align: center;
}
</style>
