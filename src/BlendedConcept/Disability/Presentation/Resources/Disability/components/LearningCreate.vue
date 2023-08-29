<script setup>
import { Link } from "@inertiajs/inertia-vue3";
const props = defineProps({
    form: {
        type: Object,
    },
    userData: {
        type: Object,
        required: false,
        default: () => ({
            learning_need: "",
            sub_learning: [],
            description: "",
        }),
    },
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["submit", "update:isDialogVisible"]);

const userData = ref(structuredClone(toRaw(props.userData)));
const isUseAsBillingAddress = ref(false);
const items = [
    "Self Care",
    "Mobility",
    "Community",
    "Self Management",
    "Self Awareness",
    "Social Awareness",
    "Sentence Structure",
    "Grammer",
    "Communication",
    "Operation",
    "Problem Solving",
    "Data Analysis",
];
watch(props, () => {
    userData.value = structuredClone(toRaw(props.userData));
});

const onFormSubmit = () => {
    // emit('submit', userData.value)
    emit("submit", { title: "You have succesfully edited your profiled" });
};

const onFormReset = () => {
    userData.value = structuredClone(toRaw(props.userData));
    emit("update:isDialogVisible", false);
};

const dialogVisibleUpdate = (val) => {
    emit("update:isDialogVisible", val);
};
</script>

<template>
    <VDialog
        :width="$vuetify.display.smAndDown ? 'auto' : 600"
        :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate"
    >
        <VCard class="pa-sm-9 pa-5">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <VCardItem class="text-left">
                <VCardTitle class="te mb-2 tiggie-title">
                    Add Learning Need
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VRow>
                        <!-- 👉 Contact -->
                        <VCol cols="12" md="6">
                            <VLabel class="tiggie-label required"
                                >Learning Need Type</VLabel
                            >
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                v-model="userData.learning_need"
                            />
                        </VCol>
                        <VCol cols="12" md="6"></VCol>
                        <!-- 👉 Contact -->
                        <VCol cols="12" md="6">
                            <VLabel class="tiggie-label"
                                >Sub Learning Type</VLabel
                            >
                            <v-select
                                v-model="userData.sub_learning"
                                :items="items"
                                chips
                                multiple
                            ></v-select>
                        </VCol>
                        <VCol cols="12" md="6"></VCol>
                        <!-- 👉 Contact -->
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">Description</VLabel>
                            <VTextarea
                                placeholder="Type here ...."
                                v-model="userData.description"
                                auto-grow
                                rows="5"
                            />
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
                                Cancel
                            </VBtn>

                            <VBtn type="submit" height="58" class="pl-16 pr-16">
                                Submit
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
