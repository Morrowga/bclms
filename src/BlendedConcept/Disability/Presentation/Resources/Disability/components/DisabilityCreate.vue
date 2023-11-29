<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import { requiredValidator } from "@validators";
const props = defineProps({});
const form = useForm({
    name: "",
    description: "",
});
const isDialogVisible = ref(false);
const isFormValid = ref(false);
let refForm = ref();
let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("disability_type.store"), {
                onSuccess: ({ props }) => {
                    let success = props.flash?.successMessage;
                    if (success !== null) {
                        SuccessDialog({ title: success });
                        form.reset();
                    } else {
                        SuccessDialog({
                            title: props.flash?.errorMessage,
                            mainTitle: "Error!",
                            color: "#ff6262",
                            icon: "error",
                        });
                    }
                    isDialogVisible.value = false;
                },
                onError: (error) => {},
            });
        }
    });
};

const onFormReset = () => {
    isDialogVisible.value = false;
};

const dialogVisibleUpdate = (val) => {};
</script>

<template>
    <div>
        <VBtn @click="isDialogVisible = true">
            <span class="text-uppercase text-white pl-4 pr-4"> Add </span>
        </VBtn>
        <VDialog v-model="isDialogVisible" max-width="600">
            <VCard class="pa-sm-9 pa-5">
                <!-- 👉 dialog close btn -->
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="onFormReset"
                />

                <VCardItem class="text-left">
                    <VCardTitle class="te mb-2 tiggie-title">
                        Add Disabilities
                    </VCardTitle>
                </VCardItem>

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm
                        class="mt-6"
                        ref="refForm"
                        v-model="isFormValid"
                        @submit.prevent="handleSubmit"
                    >
                        <VRow>
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Disability Type</VLabel
                                >
                                <VTextField
                                    type="text"
                                    class="tiggie-resize-input-text"
                                    v-model="form.name"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>

                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Description</VLabel
                                >
                                <VTextarea
                                    placeholder="Type here ...."
                                    v-model="form.description"
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

                                <VBtn
                                    type="submit"
                                    height="58"
                                    class="pl-16 pr-16"
                                >
                                    Submit
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
