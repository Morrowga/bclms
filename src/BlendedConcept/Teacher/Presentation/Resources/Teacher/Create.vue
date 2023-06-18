<script setup>
// component
import AppDateTimePicker from "@core/components/AppDateTimePicker.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import { useForm} from "@inertiajs/vue3";
import { ref } from "vue";
import { emailValidator, requiredValidator,integerValidator } from "@validators";
let props = defineProps(["roles", "flash"]);
const isDialogVisible = ref(false);
const isPasswordVisible = ref(false);

let form = useForm({
  role: 4, //teacher roles
  name: " ",
  password: "",
  contact_number: "",
  email: "",
  image: "",
  dob: "",
});

let handleSubmit = () => {
  form.post(route("c.teachers.store"), {
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
      <VBtn v-bind="props"> Add Teachers </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Teacher Particulars">
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
                    type="number"
                    label="Contact Number"
                    v-model="form.contact_number"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.contact_number"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    type="email"
                    label="Email"
                    v-model="form.email"
                    class="w-100"
                    :rules="[emailValidator]"
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
                  <AppDateTimePicker
                  :rules="[requiredValidator]"
                  v-model="form.dob"
                  label="Dob" />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="6">
              <ImageUpload v-model="form.image" />
            </VCol>
            <VCol cols="12" class="d-flex justify-center">
              <VBtn type="submit" class="me-3"> Submit </VBtn>
              <VBtn
                type="reset"
                variant="outlined"
                color="secondary"
                @click="isDialogVisible = false"
              >
                Cancel
              </VBtn>
            </VCol>
          </VRow>
        </VCardText>
      </form>
    </VCard>
  </VDialog>
</template>
