<script setup>
import ImageUpload from "@Composables/ImageUpload.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import { toastAlert } from "@Composables/useToastAlert";
const isFormValid = ref(false);
const refForm = ref();
const isDialogVisible = ref(false);
let form = useForm({
    name: " ",
    start_date: "",
    teacher_id: "",
    description: "",
    students: null,
    _method: "PUT",
});
let props = defineProps(["classroom", "flash",'students','teachers']);

// Update create form
let handleUpdate = (id) => {
    refForm.value.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("c.classrooms.update", { id: id }), {
                onSuccess: (status) => {
                    toastAlert({
                        title: props.flash?.successMessage,
                    });
                    isDialogVisible.value = false;
                },
            });
        }
    });
};

onUpdated(() => {
    form.name = props.classroom.name;
    form.teacher_id = props.classroom.teacher.id;
    form.description = props.classroom.description ?? "Something here";
    form.students = props.classroom.students.map((item)=> item.id);
});
</script>

<template>
    <VDialog v-model="isDialogVisible" max-width="900" persistent>
        <template #activator="{ props }">
            <VBtn
                v-bind="props"
                density="compact"
                icon="mdi-pencil"
                class="ml-2"
                color="secondary"
                variant="text"
            >
            </VBtn>
        </template>
        <VCard>
            <VCardTitle>
                <span class="text-xl">Student Details</span>
            </VCardTitle>
            <VCardSubtitle>
                <span class="text-xs">
                    Updating user details will receive a privacy audit.
                </span>
            </VCardSubtitle>
            <VForm
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="handleUpdate(props.classroom.id)"
            >
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isDialogVisible = false"
                />

                <VCardText>
                    <VRow>
                        <VCol cols="12">
                            <VRow>
                                <VCol cols="6">
                                    <VTextField
                                        label="Name"
                                        v-model="form.name"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.name"
                                    />
                                </VCol>
                                <VCol cols="6">
                                    <VSelect
                                        label="Teacher In Charge"
                                        v-model="form.teacher_id"
                                        :items="props.teachers"
                                        item-title="name"
                                        item-value="id"
                                        :error-messages="form?.errors?.teacher"
                                    />
                                </VCol>
                                <VCol cols="6">
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
                                <VCol cols="6">
                                    <VSelect
                                        label="Student Lists"
                                        v-model="form.students"
                                        :items="props.students"
                                        item-title="name"
                                        item-value="id"
                                        chips
                                        multiple
                                        :error-messages="form?.errors?.students"
                                    />
                                </VCol>
                            </VRow>
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
            </VForm>
        </VCard>
    </VDialog>
</template>
