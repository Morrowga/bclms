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
  name: "",
  contact_person: "",
  contact_email: "",
  contact_number: "",
  price: "00",
  license: "user102",
  storage: "30GB",
  payment_peroid: "mm",
  image: "",
  _method: "PUT",
});
let props = defineProps(["organization", "flash"]);

// Update create form
let handleUpdate = (id) => {
  refForm.value.validate().then(({ valid }) => {
    if (valid) {
      form.post(route("organizations.update", { id: id }), {
        onSuccess: (status) => {
          console.log(props.flash, "hello");
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
  form.name = props.organization.name;
  form.contact_person = props.organization.contact_person;
  form.contact_email = props.organization.contact_email;
  form.contact_number = props.organization.contact_number;
  form.price = props.organization.plan.price;
  form.license = props.organization.plan.teacher_license;
  form.storage = props.organization.plan.allocated_storage;
  form.payment_peroid = props.organization.plan.payment_peroid;
  form.image = props?.organization?.image[0]?.original_url || "";
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
        <span class="text-xl">Organization Details</span>
      </VCardTitle>
      <VCardSubtitle>
        <span class="text-xs">
          Updating user details will receive a privacy audit.
        </span>
      </VCardSubtitle>
      <VForm
        ref="refForm"
        v-model="isFormValid"
        @submit.prevent="handleUpdate(props.organization.id)"
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
                    label="Organization Name"
                    density="compact"
                    v-model="form.name"
                    class="w-100"
                    :error-messages="form?.errors?.name"
                    :rules="[requiredValidator]"
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
                    :rules="[requiredValidator,emailValidator]"
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
                    v-model="form.payment_peroid"
                    class="w-100"
                    :error-messages="form?.errors?.payment_peroid"
                  />
                </VCol>
              </VRow>
            </VCol>
            <VCol cols="6">
              <ImageUpload v-model="form.image" :old_img="form.image" />
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
