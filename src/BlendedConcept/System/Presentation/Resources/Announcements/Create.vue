<script setup>
import { useForm } from "@inertiajs/vue3";
const isDialogVisible = ref(false);
import { defineProps,ref } from "vue";
import { requiredValidator } from "@validators";
import { toastAlert } from "@Composables/useToastAlert";

let props = defineProps(["organizations", "users","flash"]);

const form = useForm({
  title: "",
  message: "",
  created_by: "",
  send_to: "",
  type: "",
});



const message_types = ["success", "error", "warning", "info"];
const refForm = ref("");


function handleSubmit() {
  form.post(route("announcements.store"), {
    onSuccess: () => {
      toastAlert({
        title: props.flash?.successMessage,
      });
      isDialogVisible.value = false;
    },
    onError: (error) => {},
  });
}
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="900" persistent>
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props"> Add Announcement </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Announcement Details">
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="isDialogVisible = false"
      />

      <VForm ref="refForm" @submit.prevent="handleSubmit">
        <VCardText>
          <VRow>
            <!-- 👉  title -->
            <VCol cols="6">
              <VTextField
                :error-messages="form?.errors?.title"
                v-model="form.title"
                label="Title"
              />
            </VCol>

            <!-- announce by -->
            <VCol cols="6">
              <VSelect
                :error-messages="form?.errors?.created_by"
                label="Announce By"
                item-title="name"
                item-value="id"
                v-model="form.created_by"
                :items="props.organizations"
              />
            </VCol>

            <!-- announce to -->
            <VCol cols="6">
              <VSelect
                :error-messages="form?.errors?.send_to"
                label="Announce To"
                v-model="form.send_to"
                :items="props.users"
                item-title="name"
                item-value="id"
              />
            </VCol>

            <!--  type -->
            <VCol cols="6">
              <VSelect
                label="Message Type"
                :error-messages="form?.errors?.type"
                v-model="form.type"
                :items="message_types"
                item-title="name"
                item-value="id"
              />
            </VCol>
            <!-- 👉  message -->
            <VCol cols="12">
              <VTextarea
                :error-messages="form?.errors?.message"
                v-model="form.message"
                label="Message"
              />
            </VCol>
            <!-- 👉 Submit and Cancel -->
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
      </VForm>
    </VCard>
  </VDialog>
</template>
