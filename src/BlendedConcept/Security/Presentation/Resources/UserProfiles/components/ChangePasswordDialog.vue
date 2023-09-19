<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { requiredValidator } from "@validators";
const props = defineProps({
    form: {
        type: Object,
        required: false,
        default: () => ({
            currentpassword: "",
            updatedpassword: "",
            password_confirmation: "",
        }),
    },
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["submit", "update:isDialogVisible"]);

const onFormSubmit = () => {
    emit("submit", { title: "You have succesfully updated your password" });
};

const onFormReset = () => {
    props.form.reset();
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
        <VCard class="">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Edit User Password
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label required"
                                    >Old Password</VLabel
                                >
                                <VTextField
                                    type="password"
                                    v-model="form.currentpassword"
                                    placeholder="Enter Current Password"
                                    class="w-100"
                                    :error-messages="
                                        props?.form?.errors?.currentpassword
                                    "
                                />
                            </VCol>

                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label required"
                                    >Password</VLabel
                                >
                                <VTextField
                                    type="password"
                                    placeholder="Enter new password"
                                    v-model="form.updatedpassword"
                                    class="w-100"
                                    :error-messages="
                                        props?.form?.errors?.updatedpassword
                                    "
                                />
                            </VCol>
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label required"
                                    >Confirm Password</VLabel
                                >
                                <VTextField
                                    type="password"
                                    placeholder="Enter new password again"
                                    v-model="form.password_confirmation"
                                    class="w-100"
                                    :error-messages="
                                        props?.form?.errors
                                            ?.password_confirmation
                                    "
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
