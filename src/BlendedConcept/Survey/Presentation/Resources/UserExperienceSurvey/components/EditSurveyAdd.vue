<script setup>
import { useForm,usePage } from "@inertiajs/vue3";
const props = defineProps({
    form: {
        type: Object,
    },
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["submit", "update:isDialogVisible"]);

const options = ref(['']);

const addOption = () => {
    props.form.options.push('');
};

const removeOption = (index) => {
    props.form.options.splice(index, 1);
};

const onFormSubmit = () => {
    emit("submit", props.form);
    emit("update:isDialogVisible", false);
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
        value: "Single Choice",
    },
    {
        title: "Multi Response",
        value: "Multi Response",
    },
    {
        title: "Rating",
        value: "Rating",
    },
]);


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

            <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Edit Survey
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Question Type</VLabel
                                >
                                <!-- <VTextField /> -->
                                <VSelect
                                    v-model="props.form.question_type"
                                    :items="items"
                                    rounded="50%"
                                    placeholder="Select Question Type"
                                    density="compact"
                                />
                            </VCol>

                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Question</VLabel>
                                <VTextarea v-model="props.form.question"
                                    placeholder="Type here ...."
                                    rows="5"
                                />
                            </VCol>
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Options</VLabel>
                                    <VRow v-for="(option, index) in props.form.options" :key="index">
                                        <VCol cols="10">
                                            <VTextField v-model="props.form.options[index]" />
                                        </VCol>
                                        <VCol cols="2">
                                            <VBtn @click="removeOption(index)">-</VBtn>
                                        </VCol>
                                    </VRow>
                                </VCol>
                                <VCol cols="12" md="12">
                                    <VBtn
                                        variant="outlined"
                                        style="
                                        border-radius: 5px;
                                        border: 1px dashed rgba(40, 40, 40, 0.5);
                                        "
                                        block
                                        @click="addOption"
                                    >
                                        <span class="tiggie-p">Type to add more options</span>
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
.e-survey-border {
    border-radius: 5px;
    border: 1px dashed rgba(40, 40, 40, 0.5);
}
</style>
