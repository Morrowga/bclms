<script setup>
import { defineProps, ref } from "vue";
import { SuccessDialog } from "@actions/useSuccess";
import {useForm} from "@inertiajs/inertia-vue3"
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
const props = defineProps(["learningneed","themes","disability_types","devices"]);
let dialog = ref(false);
const toggleDialog = () => {
  dialog.value = !dialog.value;
};


console.log(props.learningneed)

//this arrary describe as multiple select for each roles

const form = useForm({
   name : "",
   tag_name : "",
   is_free:"",
   description : "",
   tags : [],
   sub_learning_needs:[],
   themes:[],
   disability_type_id : [],
   devices : [],
   storybook_file : "",
   thumbnail_img : "",
   physical_resource_src : ""
});

console.log(props.learningneed)


let onFormSubmit = () => {
  SuccessDialog({ title: "Successfully Game added" });
  dialog.value = false;
};
</script>
<template>
  <div>
    <VBtn @click="toggleDialog()">Add New Book</VBtn>

    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-card-text class="px-10 py-0 pb-5">
          <v-form class="mt-6" @submit.prevent="onFormSubmit">
            <v-row>
              <v-col cols="12" md="6" class="pb-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Storybook Name</VLabel>
                  <VTextField
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Text here"
                    density="compact"

                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="pb-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Tags</VLabel>
                  <VTextField
                    type="text"
                    class="tiggie-resize-input-text"
                    placeholder="Type to add tag"
                    density="compact"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Storybook Description</VLabel>
                  <v-textarea type="text" rows="5" density="compact" />
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
                    :items="props.learningneed"
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
                    :items="[]"
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
                    :items="[]"
                  />
                </v-col>
              </v-col>

              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Storybook File</VLabel>
                  <div class="coming-soon">
                    <p>Drop And Drop</p>
                  </div>
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Thumbnail Picture</VLabel>
                  <div class="coming-soon">
                    <p>Drop And Drop</p>
                  </div>
                </v-col>
              </v-col>
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="6">
                  <VLabel class="tiggie-label">Physical Resources</VLabel>
                  <div class="coming-soon">
                    <p>Drop And Drop</p>
                  </div>
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
</style>
