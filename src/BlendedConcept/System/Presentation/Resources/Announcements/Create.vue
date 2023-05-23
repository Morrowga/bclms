<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import AppDrawerHeaderSection from "@core/components/AppDrawerHeaderSection.vue";
import { requiredValidator } from "@validators";
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
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
  users: {
    type: Array,
    default: [],
  },
  organizations: {
    type: Array,
    default: [],
  },
});
//##end define props for toggle drawer

//## start variable section
const emit = defineEmits(["update:isDrawerOpen", "data"]);
const isFormValid = ref(false);
const refForm = ref();
const form = useForm({
  title: "",
  created_by: "",
  send_to: "",
  message: "",
  type: "",
});

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
      emit("data", form);
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
const message_types = ["success", "error", "warning", "info"];
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
                  :error-messages="serverError?.title"
                  v-model="form.title"
                  label="Title"
                />
              </VCol>

              <!-- announce by -->
              <VCol cols="12">
                <VSelect
                  :error-messages="serverError?.created_by"
                  label="Announce By"
                  item-title="name"
                  item-value="id"
                  v-model="form.created_by"
                  :items="props.organizations"
                />
              </VCol>

              <!-- announce to -->
              <VCol cols="12">
                <VSelect
                  :error-messages="serverError?.send_to"
                  label="Announce To"
                  v-model="form.send_to"
                  :items="props.users"
                  item-title="name"
                  item-value="id"
                />
              </VCol>

              <!--  type -->
              <VCol cols="12">
                <VSelect
                  label="Message Type"
                  :error-messages="serverError?.type"
                  v-model="form.type"
                  :items="message_types"
                  item-title="name"
                  item-value="id"
                />
              </VCol>
              <!-- 👉  message -->
              <VCol cols="12">
                <VTextarea
                  :error-messages="serverError?.message"
                  v-model="form.message"
                  label="Message"
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
