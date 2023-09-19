<script setup>
import { defineProps, ref } from "vue";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm } from "@inertiajs/vue3";
import ImageUpload from "@mainRoot/components/DropZone/FileUpload.vue";
import {
  emailValidator,
  requiredValidator,
  integerValidator,
} from "@validators";
const props = defineProps([
  "learningneed",
  "themes",
  "disability_types",
  "devices",
]);
let dialog = ref(false);
const toggleDialog = () => {
  dialog.value = !dialog.value;
};

let refForm = ref();
const isFormValid = ref(false);

//this arrary describe as multiple select for each roles
const gameTag = ref("");
const form = useForm({
  name: "",
  tag_name: "",
  is_free: 0,
  description: "",
  tags: [],
  sub_learning_needs: [],
  themes: [],
  disability_type: [],
  devices: [],
  storybook_file: "",
  thumbnail_img: "",
  physical_resource_src: "",
});

let onFormSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      form.post(route("books.store"), {
        onSuccess: () => {
          SuccessDialog({ title: props.flash?.successMessage });
          dialog.value = false;
        },
        onError: (error) => {
            console.log(error)
        },
      });
    }
  });
};

const addToSublearningArray = (e) => {
  if (gameTag.value) {
    form.tags.push(gameTag.value);
    gameTag.value = "";
  }
};

const removeFromArray = (index) => {
  form.tags = form.tags.filter((tag, i) => i != index);
};
</script>
<template>
  <div>
    <v-dialog v-model="dialog" max-width="800">
      <template #activator="{ props }">
        <VBtn v-bind="props">Add New Book</VBtn>
      </template>

      <v-card>
        <v-card-text class="px-10 py-0 pb-5">
          <v-form
            class="mt-6"
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onFormSubmit"
          >
            <v-row>
              <v-col cols="12" md="6" class="pb-0">
                <v-label class="tiggie-label">Storybook Name</v-label>
                <VTextField
                  type="text"
                  class="tiggie-resize-input-text"
                  v-model="form.name"
                  placeholder="Text here"
                  :error-messages="form?.errors?.name"
                  :rules="[requiredValidator]"
                  density="compact"
                  height="48px"
                />
              </v-col>
              <VCol cols="12" md="6" class="game-tag-add">
                <VLabel class="tiggie-label">Tags</VLabel>
                <div class="d-flex my-4" v-if="form.tags.length > 0">
                  <div
                    class="ps-relative"
                    v-for="(tag, index) in form.tags"
                    :key="index"
                  >
                    <v-chip size="small" color="primary">{{ tag }}</v-chip>
                    <div class="delete-chip" @click="removeFromArray(index)">
                      <span>-</span>
                    </div>
                  </div>
                </div>
                <VTextField
                  v-model="gameTag"
                  :error-messages="form?.errors?.tags"
                  append-inner-icon="mdi-add-circle"
                  @click:append-inner="addToSublearningArray"
                >
                </VTextField>
              </VCol>
              <VCol cols="12" md="6">
                <div class="d-flex ">
                  <VLabel class="tiggie-label pr-5">Available for Free Users</VLabel>
                  <VCheckbox
                  v-model="form.is_free"/>
                </div>
              </VCol>
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Storybook Description</VLabel>
                  <v-textarea
                    v-model="form.description"
                    type="text"
                    rows="5"
                    density="compact"
                    :error-messages="form?.errors?.description"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="pb-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Learning Needs</VLabel>
                  <v-autocomplete
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Select devices"
                    density="compact"
                    v-model="form.sub_learning_needs"
                    :items="props.learningneed"
                    :error-messages="form?.errors?.sub_learning_needs"
                    item-title="name"
                    item-value="id"
                    multiple
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="pb-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Themes</VLabel>
                  <v-autocomplete
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Select devices"
                    density="compact"
                    v-model="form.themes"
                    :items="props.themes"
                    :error-messages="form?.errors?.themes"
                    item-title="name"
                    item-value="id"
                    multiple
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Disability Type</VLabel>
                  <v-autocomplete
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Select disability type"
                    density="compact"
                    :items="props.disability_types"
                    v-model="form.disability_type"
                    :error-messages="form?.errors?.disability_type"
                    item-title="name"
                    item-value="id"
                    multiple
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label"
                    >Supported Accessibility Devices</VLabel
                  >
                  <v-autocomplete
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Select devices"
                    density="compact"
                    :items="props.devices"
                    v-model="form.devices"
                    :error-messages="form?.errors?.devices"
                    item-title="name"
                    item-value="id"
                    multiple
                  />
                </v-col>
              </v-col>

              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Storybook File</VLabel>
                  <ImageUpload v-model="form.storybook_file" filename="H5P" />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Thumbnail Picture</VLabel>
                  <ImageUpload
                    v-model="form.thumbnail_img"
                    filename=".png/jpg"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="6">
                  <VLabel class="tiggie-label">Physical Resources</VLabel>
                  <ImageUpload
                    v-model="form.physical_resource_src"
                    filename=".pdf/docx"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="12">
                  <div class="d-flex justify-center aligns-center w-100">
                    <div>
                      <VBtn
                        color="gray"
                        height="50"
                        class=""
                        width="200"
                        @click="dialog = false"
                      >
                        Cancel
                      </VBtn>

                      <VBtn type="submit" class="ml-10" height="50" width="200">
                        Add
                      </VBtn>
                    </div>
                  </div>
                </v-col>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped>
/* .img-header {

} */
.faded-image {
  position: relative;
  display: inline-block;
  width: 100%;
}

.faded-image img {
  display: block;
  height: 270px;
  width: 100%;
  object-fit: fill;
  position: relative;
}

.faded-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 50%; /* Adjust this value to control the height of the fading effect */
  background: linear-gradient(
    to bottom,
    transparent,
    white
  ); /* Adjust the colors as needed */
}

.book-title {
  position: absolute;
  bottom: 0;
  width: 100%;
  left: 40px;
}
.book-title span {
  color: var(--graphite, #282828) !important;
  font-size: 35px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 108.333% */
  text-transform: capitalize !important;
}

.close-btn {
  position: absolute;
  top: 0;

  right: 0;
}
.v-btn--icon {
  border-radius: 10px;
  scale: 0.7;
}
.chip-1 {
  background: rgba(255, 166, 0, 0.464);
  color: #fff !important;
}
.chip-2 {
  background: rgba(217, 23, 13, 0.464);
  color: #fff !important;
}
.chip-3 {
  background: rgba(72, 255, 0, 0.464);
  color: #fff !important;
}
.coming-soon {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  width: 100%;
  height: 200px;
  border: 1px dashed black;
  border-radius: 10px;
}
.coming-soon p {
  margin-bottom: 0;
}

:deep(.game-tag-add .v-field__append-inner svg) {
  width: 30px;
  height: 30px;
}

:deep(.game-name-input .v-input__details) {
  margin-top: 10px !important;
}

:deep(.disability-type-input .v-input__details) {
  margin-top: 10px !important;
}
.delete-chip {
  background: rgb(109, 120, 141);
  border-radius: 50%;
  width: 15px;
  height: 15px;
  color: #fff;
  text-align: center;
  position: absolute;
  right: -4px;
  top: -5px;
  cursor: pointer;
}
.delete-chip span {
  position: absolute;
  top: -6px;
  left: 0;
  bottom: 0;
  right: 0;
  color: #fff;
}
</style>
