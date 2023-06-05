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
let props = defineProps(["flash","students",'teachers']);
const isDialogVisible = ref(false);
const isPasswordVisible = ref(false);

let form = useForm({
  name: " ",
  start_date:"",
  teacher_id: "",
  description:"",
  students: null
});

let handleSubmit = () => {
  form.post(route("classrooms.store"), {
    onSuccess: () => {
      toastAlert({
        title: props.flash?.successMessage,
      });
      isDialogVisible.value = false;
    },
    onError: (error) => {
        alert("something was wrong");
    },
  });
};
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="900" persistent>
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props"> Add Class </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Classes Particulars">
      <form @submit.prevent="handleSubmit">
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
                    :error-messages="form?.errors?.description"
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
          <VBtn color="error" @click="isDialogVisible = false"> Close </VBtn>
          <VBtn type="submit" color="success"> Save </VBtn>
        </VCardActions>
      </form>
    </VCard>
  </VDialog>
</template>
