<script setup>
import { ref } from "vue"
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
const isDialogVisible = ref(false)
import { SuccessDialog } from "@actions/useSuccess";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    question: "",
});
const props = defineProps(["flash"])
const isFormValid = ref(false);
const refForm = ref();

const handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route('techsupport'), {
                onSuccess: () => {
                    isDialogVisible.value = false;
                    form.reset();
                    refForm.value?.reset();
                    refForm.value?.resetValidation();
                    SuccessDialog({ title: "" });
                },
                onError: (error) => {
                    console.log(error)
                },
            })
        }
    });

}

</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn color="primary" variant="flat" rounded v-bind="props">
                <VIcon icon="mdi-plus" class="text-white"></VIcon>
                <span class="text-white">Ask</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard>
            <DialogCloseBtn variant="text" size="small" @click="isDialogVisible = false" />

            <VForm class="mt-6" ref="refForm" v-model="isFormValid" @submit.prevent="handleSubmit">
                <VCardText>
                    <h4 class="tiggie-subtitle">Describe your issue to our Technical Support Team</h4>
                    <VTextarea
                        v-model="form.question"
                        placeholder="Enter question" :rules="[requiredValidator]"
                        :error-messages="form?.errors?.question" />
                </VCardText>
                <VCardActions>
                    <VRow class="text-center">
                        <VCol cols="6" class="text-end">
                            <VBtn type="submit" color="teal" variant="tonal" class="px-10">
                                Send
                            </VBtn>
                        </VCol>
                        <VCol cols="6" class="text-start">
                            <VBtn color="graphic" variant="tonal" class="px-10">
                                Cancel
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCardActions>

            </VForm>

        </VCard>
    </VDialog>
</template>
