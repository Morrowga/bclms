<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import AppDrawerHeaderSection from "@core/components/AppDrawerHeaderSection.vue";
import { requiredValidator, emailValidator } from "@validators";
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
const permission_name = ref();
const permission_description = ref();

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
        name: permission_name.value,
        description: permission_description.value,
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
  return props.serverError.name == "" ? false : true;
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
      title="Add Permission"
      @cancel="closeNavigationDrawer"
    />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm ref="refForm" v-model="isFormValid" @submit.prevent="onSubmit">
            <VRow>
              <!-- 👉  name -->
              <VCol cols="12">
                <VTextField
                  :error="checkError"
                  :error-messages="serverError?.name"
                  @input="serverError.name = ''"
                  v-model="permission_name"
                  :rules="[requiredValidator]"
                  label="Permission Name"
                />
              </VCol>
              <!-- 👉  name -->
              <VCol cols="12">
                <VTextarea
                  v-model="permission_description"
                  label="Description"
                />
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


