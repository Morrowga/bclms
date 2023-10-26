<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import { onUpdated } from "vue";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import { ref } from "vue";

const props = defineProps(["dataPropsRow", "data"]);

const refForm = ref();
const isFormValid = ref(false);

const form = useForm({
    id: "",
    question: "",
    response: "",
    _method: "PUT",
});

onUpdated(() => {
    console.log("hello");
    form.id = props.dataPropsRow.id;
    form.question = props.dataPropsRow.question;
    console.log(form.question);
});

const isDialogVisible = ref(false);

const onFormSubmit = () => {
    form.post(route("answerSupportQuestion", { id: form.id }), {
        onSuccess: () => {
            isDialogVisible.value = false;
            form.reset();
            refForm.value?.reset();
            refForm.value?.resetValidation();
            SuccessDialog({ title: "" });
        },
        onError: (error) => {
            console.log(error, "something is unexcepted");
        },
    });
};
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn
                v-if="!data.has_responded"
                v-bind="props"
                class="clickLayNaw text-white"
                variant="plain"
            >
                Click Me
            </VBtn>
        </template>
        <VCard class="pt-10">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />
            <VCardItem class="text-left pl-16">
                <VCardTitle class="mb-2 tiggie-title">
                    Technical Support
                </VCardTitle>
                <VLabel class="tiggie-label">Question</VLabel>
                <p class="tiggie-p">
                    {{ props.dataPropsRow.question }}
                </p>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm
                    class=""
                    @submit.prevent="onFormSubmit"
                    ref="refForm"
                    v-model="isFormValid"
                >
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="11" md="11">
                                <VLabel class="tiggie-label">Answer</VLabel>
                                <VTextarea
                                    placeholder="Type here ...."
                                    :error-messages="form?.errors?.response"
                                    :rules="[requiredValidator]"
                                    v-model="form.response"
                                    auto-grow
                                    rows="5"
                                />
                            </VCol>
                            <VCol
                                cols="11"
                                class="d-flex flex-wrap justify-space-between gap-10"
                            >
                                <VBtn
                                    color="gray"
                                    text-color="white"
                                    height="58"
                                    class=""
                                    @click="isDialogVisible = false"
                                >
                                    <span class="text-white">Cancel</span>
                                </VBtn>

                                <VBtn
                                    type="submit"
                                    height="58"
                                    color="primary"
                                    class="primary"
                                >
                                    Send Answer
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VContainer>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>

<style scoped></style>
