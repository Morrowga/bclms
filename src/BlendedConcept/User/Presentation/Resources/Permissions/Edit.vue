<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import AppDrawerHeaderSection from "@core/components/AppDrawerHeaderSection.vue";
import { emailValidator, requiredValidator } from "@validators";
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  isDrawerOpen: {
    type: Boolean,
    required: true,
  },
  permission: {
    type: Object,
  },
});

const emit = defineEmits(["update:isDrawerOpen", "userData"]);

const isFormValid = ref(false);
const refForm = ref();
const form = useForm({
  name: "",
  description: "",
});
// 👉 drawer close
const closeNavigationDrawer = () => {
  emit("update:isDrawerOpen", false);

  nextTick(() => {
    refForm.value?.reset();
    refForm.value?.resetValidation();
  });
};

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit("userData", {
        name: form.name,
        description: form.description,
      });
      emit("update:isDrawerOpen", false);
      nextTick(() => {
        refForm.value?.reset();
        refForm.value?.resetValidation();
      });
    }
  });
};

const handleDrawerModelValueUpdate = (val) => {
  emit("update:isDrawerOpen", val);
};
onUpdated(() => {
  form.name = props.permission?.name;
  form.description = props.permission?.description;
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
      title="Edit Permission"
      @cancel="closeNavigationDrawer"
    />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm ref="refForm" v-model="isFormValid" @submit.prevent="onSubmit">
            <VRow>
              <!-- 👉 Full name -->
              <VCol cols="12">
                <VTextField
                  v-model="form.name"
                  :rules="[requiredValidator]"
                  label="Permission Name"
                />
              </VCol>
              <!-- 👉 Full name -->

              <VCol cols="12">
                <VTextarea
                  v-model="form.description"
                  :rules="[requiredValidator]"
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


