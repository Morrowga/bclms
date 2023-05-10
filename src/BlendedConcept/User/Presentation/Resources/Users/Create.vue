<script setup>
// component
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { emailValidator, requiredValidator } from "@validators";

// get roles
let props = defineProps(["roles", "flash"]);
const isDialogVisible = ref(false);
// check passwor visible
const isPasswordVisible = ref(false);
let form = useForm({
  role: "Select",
  name: " ",
  password: "",
  contact_number: "",
  email: "",
  image: "",
  dob: "",
});

// submit create form
let handleSubmit = () => {
  form.post(route("users.store"), {
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
      <VBtn v-bind="props"> Add Users </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="User Particulars">
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
                  <VSelect
                    label="User Roles"
                    v-model="form.role"
                    :items="roles"
                    item-title="name"
                    item-value="id"
                    :error-messages="form?.errors?.role"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Name"
                    v-model="form.name"
                    class="w-100"
                    :error-messages="form?.errors?.name"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Contact Number"
                    v-model="form.contact_number"
                    class="w-100"
                    :error-messages="form?.errors?.contact_number"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Email"
                    v-model="form.email"
                    class="w-100"
                    :error-messages="form?.errors?.email"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Password"
                    v-model="form.password"
                    :rules="[requiredValidator]"
                    :type="isPasswordVisible ? 'text' : 'password'"
                    :error-messages="form?.errors?.password"
                    :append-inner-icon="
                      isPasswordVisible
                        ? 'mdi-eye-off-outline'
                        : 'mdi-eye-outline'
                    "
                    @click:append-inner="isPasswordVisible = !isPasswordVisible"
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
      </form>
    </VCard>
  </VDialog>
</template>
