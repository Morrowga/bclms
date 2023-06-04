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
  nickname: "",
  student_code: "",
  description: "",
  dob: "",
  grade: "",
  image: "",
  _method: "PUT",
});
let props = defineProps(["student", "flash"]);

// Update create form
let handleUpdate = (id) => {
  refForm.value.validate().then(({ valid }) => {
    if (valid) {
      form.post(route("students.update", { id: id }), {
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
  form.name = props.student.name;
  form.nickname = props.student.nickname;
  form.student_code = props.student.student_code;
  form.description = props.student.description;
  form.dob = props.student.dob;
  form.grade = props.student.grade;
  form.image = props?.student?.image[0]?.original_url || "";
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
        @submit.prevent="handleUpdate(props.student.id)"
      >
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
                    :error-messages="form?.errors?.student_code"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    type="text"
                    label="Description"
                    v-model="form.description"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.description"
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
              <ImageUpload
              v-model="form.image"
              :old_img="form.image"
              />
            </VCol>
          </VRow>
        </VCardText>
        <VCardActions>
          <VSpacer />
          <VBtn color="error" @click="isDialogVisible = false"> Close </VBtn>
          <VBtn type="submit" color="success"> Save </VBtn>
        </VCardActions>
      </VForm>
    </VCard>
  </VDialog>
</template>
