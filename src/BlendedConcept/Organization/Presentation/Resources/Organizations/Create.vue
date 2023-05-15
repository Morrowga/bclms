<script setup>
// component
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import { useForm} from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import { emailValidator, requiredValidator } from "@validators";

const isFormValid = ref(false);
const refForm = ref();
const isDialogVisible = ref(false);
let form = useForm({
  name: "",
  contact_person: "",
  contact_email: "",
  contact_number: "",
  price: "00",
  license: "user102",
  storage: "30GB",
  payment_period: "mm",
  // payment_type: "card",
  image: "",
});
let props = defineProps(["flash"]);

// submit create form
let handleSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      form.post(route("organizations.store"), {
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
    }
  });
};
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="900" persistent>
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props"> Add New </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard>
      <VCardTitle>
        <span class="text-xl">Organization Details</span>
      </VCardTitle>
      <VCardSubtitle>
        <span class="text-xs"
          >Updating user details will receive a privacy audit.</span
        >
      </VCardSubtitle>
      <VForm ref="refForm" v-model="isFormValid" @submit.prevent="handleSubmit">
        <DialogCloseBtn
          variant="text"
          size="small"
          @click="isDialogVisible = false"
        />
        <VCardText>
          <VRow>
            <VCol cols="6">
              <!-- Organization Details -->
              <VRow>
                <VCol cols="12">
                  <VTextField
                    label="Organization Name"
                    density="compact"
                    v-model="form.name"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.name"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Contact Person"
                    density="compact"
                    v-model="form.contact_person"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.contact_person"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Contact Email"
                    density="compact"
                    v-model="form.contact_email"
                    class="w-100"
                    :rules="[emailValidator]"
                    :error-messages="form?.errors?.contact_email"
                  />
                </VCol>
                <VCol cols="12">
                  <VTextField
                    label="Contact Number"
                    density="compact"
                    v-model="form.contact_number"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.contact_number"
                  />
                </VCol>
              </VRow>
              <!--  -->
              <!-- Organization Plan -->
              <VRow>
                <VCol cols="12">
                  <span class="text-xl">Organization Plan</span>
                </VCol>
                <VCol cols="6">
                  <VTextField
                    label="User License"
                    density="compact"
                    v-model="form.license"
                    class="w-100"
                    :error-messages="form?.errors?.license"
                    :rules="[requiredValidator]"
                  />
                </VCol>
                <VCol cols="6">
                  <VTextField
                    label="Storage"
                    density="compact"
                    v-model="form.storage"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.storage"
                  />
                </VCol>
                <VCol cols="6">
                  <VTextField
                    label="Price"
                    type="number"
                    density="compact"
                    v-model="form.price"
                    class="w-100"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.price"
                  />
                </VCol>
                <VCol cols="6">
                  <VTextField
                    label="Payment Period"
                    density="compact"
                    v-model="form.payment_period"
                    class="w-100"
                    :error-messages="form?.errors?.payment_period"
                  />
                </VCol>
                <!-- <VCol cols="6">
                  <VTextField
                    label="Payment Type"
                    density="compact"
                    v-model="form.payment_type"
                    class="w-100"
                    :error-messages="form?.errors?.payment_type"
                  />
                </VCol> -->
              </VRow>
              <!--  -->
            </VCol>
            <!-- Image Upload -->
            <VCol cols="6">
              <ImageUpload v-model="form.image" />
            </VCol>
            <!--  -->
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
