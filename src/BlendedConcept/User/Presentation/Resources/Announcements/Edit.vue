<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import AppDrawerHeaderSection from "@core/components/AppDrawerHeaderSection.vue";
import { requiredValidator } from "@validators";
import { computed } from "vue";
import { useForm } from "@inertiajs/vue3";

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
  announcement: {
    type: Object,
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
//## end define props for toggle drawer

//## start variable section
const emit = defineEmits(["update:isDrawerOpen", "data"]);
const isFormValid = ref(false);
const refForm = ref();
const form = useForm({
  title: "",
  message: "",
  created_by: "",
  send_to: "",
});
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
        title: form.title,
        message: form.message,
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

//## start reative name and description when edit
onUpdated(() => {
  form.title = props.announcement?.title;
  form.message = props.announcement?.message;
  form.created_by = props.announcement?.created_by;
  form.send_to = props.announcement?.send_to;
});
//## end reative name and description when edit

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
      title="Edit Announcement"
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
                  v-model="form.title"
                  :rules="[requiredValidator]"
                  label="Title"
                />
              </VCol>

              <VCol cols="12">
                <VSelect
                  label="Announce By"
                  item-title="name"
                  item-value="id"
                  v-model="form.created_by"
                  :items="props.organizations"
                />
              </VCol>
              <VCol cols="12">
                <VSelect
                  label="Announce To"
                  v-model="form.send_to"
                  :items="props.users"
                  item-title="name"
                  item-value="id"
                />
              </VCol>

              <VCol cols="12">
                <VTextarea v-model="form.message" label="Message" />
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


