<script setup>
// component
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import moment from "moment";
const isDialogVisible = ref(false);
// check passwor visible
const isPasswordVisible = ref(false);
const isFormValid = ref(false);
const refForm = ref();
// get current user and roles
let props = defineProps(["user", "roles"]);
let form = useForm({
  role: props?.user?.roles[0]?.name,
  name: props.user.name,
  password: "",
  contact_number: props.user.contact_number,
  email: props.user.email,
  image: props?.user?.image[0]?.original_url || "",
  _method: "put",
  dob: props.user.dob,
});
// Update create form
let handleUpdate = (id) => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      form.post(route("users.update", { id: id }), form, {
        onError: (error) => {
          alert("something was wrong");
        },
      });
      //## form.reset();
      refForm.value?.reset();
      refForm.value?.resetValidation();
      isDialogVisible.value = false;
    }
  });
};
onUpdated(() => {
  form.role = props?.user?.roles[0]?.name;
  form.name = props.user.name;
  form.contact_number = props.user.contact_number;
  form.email = props.user.email;
  form.image = props?.user?.image[0]?.original_url || "";
  form.dob =props.user.dob;
});
</script>
<template>
  <VDialog v-model="isDialogVisible" max-width="900" persistent>
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
        density="compact"
        icon="mdi-pencil"
        class="ml-2 bg-success"
        v-bind="props"
      >
      </VBtn>
    </template>
    <!-- Dialog Content -->
    <VCard title="User Particulars">
      <VForm
        @submit.prevent="handleUpdate(props.user.id)"
        ref="refForm"
        v-model="isFormValid"
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
                  <VSelect
                    label="User Roles"
                    v-model="form.role"
                    :items="roles"
                    :error-messages="form?.errors?.role_id"
                    :rules="[requiredValidator]"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Name"
                    v-model="form.name"
                    class="w-100"
                    :error-messages="form?.errors?.name"
                    :rules="[requiredValidator]"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Contact Number"
                    v-model="form.contact_number"
                    class="w-100"
                    :error-messages="form?.errors?.contact_number"
                    :rules="[requiredValidator]"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Email"
                    v-model="form.email"
                    class="w-100"
                    :error-messages="form?.errors?.email"
                    :rules="[requiredValidator]"
                  />
                </VCol>
                <VCol cols="12">
                  <AppDateTimePicker v-model="form.dob" label="Dob" />
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
          <VBtn color="error" @click="isDialogVisible = false"> Close </VBtn>
          <VBtn type="submit" color="success"> Save </VBtn>
        </VCardActions>
      </VForm>
    </VCard>
  </VDialog>
</template>
