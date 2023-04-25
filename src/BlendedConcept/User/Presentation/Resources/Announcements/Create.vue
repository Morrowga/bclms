<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import AppDrawerHeaderSection from "@core/components/AppDrawerHeaderSection.vue";
import { requiredValidator } from "@validators";
import { computed } from "vue";
//## start define props for toggle drawer
const props = defineProps({
  serverError: {
    type: Object,
    default: null,
  },
  isDrawerOpen: {
    type: Boolean,
    required: true,
  },
});
//##end define props for toggle drawer

//## start variable section
const emit = defineEmits(["update:isDrawerOpen", "data"]);
const isFormValid = ref(false);
const refForm = ref();
const announcement_title = ref();
const announcement_message = ref();

//## end variable section

//## start drawer close
const closeNavigationDrawer = () => {
  emit("update:isDrawerOpen", false);
  nextTick(() => {
    refForm.value?.reset();
    refForm.value?.resetValidation();
  });
};
//## end drawer close

//## start pass form data to parent
const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit("data", {
        title: announcement_title.value,
        message: announcement_message.value,
      });
      // emit("update:isDrawerOpen", false);
      nextTick(() => {
        // refForm.value?.reset();
        refForm.value?.resetValidation();
      });
    }
  });
};
//## end pass form data to parent

//## start toggle drawer
const handleDrawerModelValueUpdate = (val) => {
  emit("update:isDrawerOpen", val);
};
//## end toggle drawer

//## check error
const checkError = computed(() => {
  return props.serverError.title == "" ? false : true;
});
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="400"
    location="end"
    class="scrollable-content"
    :model-value="props.isDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Title -->
    <AppDrawerHeaderSection
      title="Add Announcement"
      @cancel="closeNavigationDrawer"
    />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm ref="refForm" v-model="isFormValid" @submit.prevent="onSubmit">
            <VRow>
              <!-- 👉  title -->
              <VCol cols="12">
                <VTextField
                  :error="checkError"
                  :error-messages="serverError?.title"
                  @input="serverError.title = ''"
                  v-model="announcement_title"
                  :rules="[requiredValidator]"
                  label="Title"
                />
              </VCol>
              <!-- 👉  message -->
              <VCol cols="12">
                <VTextarea v-model="announcement_message" label="Message" />
              </VCol>
              <!-- 👉 Submit and Cancel -->
              <VCol cols="12">
                <VBtn type="submit" class="me-3"> Submit </VBtn>
                <VBtn
                  type="reset"
                  variant="tonal"
                  color="secondary"
                  @click="closeNavigationDrawer"
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>


