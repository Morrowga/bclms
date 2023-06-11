<script setup>
// component
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import {
emailValidator,
requiredValidator,
integerValidator,
} from "@validators";
let props = defineProps(["flash",'tenant']);
const isDialogVisible = ref(false);
const isPasswordVisible = ref(false);

let form = useForm({
name: " ",
nickname: "",
student_code: "",
description: "",
dob: "",
grade: "",
image: "",
});

let handleSubmit = () => {

form.post(route(`${props?.tenant}students.store`), {
    onSuccess: () => {
        toastAlert({
            title: props.flash?.successMessage,
        });
        isDialogVisible.value = false;
    },
    onError: (error) => {
        //   alert("something was wrong");
    },
});
};
</script>

<template>
<VDialog v-model="isDialogVisible" max-width="900" persistent>
    <!-- Dialog Activator -->
    <template #activator="{ props }">
        <VBtn v-bind="props"> Add Students </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Student Particulars">
        <form @submit.prevent="handleSubmit">
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />
            <VCardText>
                <VRow>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="12">
                                <VTextField
                                    label="Name"
                                    v-model="form.name"
                                    class="w-100"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.name"
                                />
                            </VCol>
                            <VCol cols="12">
                                <VTextField
                                    type="text"
                                    label="Nick Name"
                                    v-model="form.nickname"
                                    class="w-100"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.nickname"
                                />
                            </VCol>
                            <VCol cols="12">
                                <VTextField
                                    type="text"
                                    label="Student Code"
                                    v-model="form.student_code"
                                    class="w-100"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.student_code
                                    "
                                />
                            </VCol>
                            <VCol cols="12">
                                <VTextField
                                    type="text"
                                    label="Description"
                                    v-model="form.description"
                                    class="w-100"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.description
                                    "
                                />
                            </VCol>
                            <VCol cols="12">
                                <VTextField
                                    type="text"
                                    label="Grade"
                                    v-model="form.grade"
                                    class="w-100"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.grade"
                                />
                            </VCol>
                            <VCol cols="12">
                                <AppDateTimePicker
                                    :rules="[requiredValidator]"
                                    v-model="form.dob"
                                    label="Dob"
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="6">
                        <ImageUpload v-model="form.image" />
                    </VCol>
                </VRow>
            </VCardText>
            <VCardActions>
                <VSpacer />
                <VBtn color="error" @click="isDialogVisible = false">
                    Close
                </VBtn>
                <VBtn type="submit" color="success"> Save </VBtn>
            </VCardActions>
        </form>
    </VCard>
</VDialog>
</template>
