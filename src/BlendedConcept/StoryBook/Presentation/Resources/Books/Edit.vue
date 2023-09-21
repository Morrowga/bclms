<script setup>
import { defineProps, ref, defineEmits, onUpdated } from "vue";
import { useForm } from "@inertiajs/vue3";
import Upload from "./components/Upload.vue";
import { SuccessDialog } from "@actions/useSuccess";
const props = defineProps({
  datas: {
    type: Object,
    default: null,
  },
});
let emit = defineEmits();
let dialog = ref(false);
const toggleDialog = () => {
  dialog.value = !dialog.value;
};
const form = useForm({
  id: "",
  name: "",
  tag_name: "",
  is_free: 0,
  description: "",
  tags: [],
  sub_learning_needs: [],
  themes: [],
  disability_type: [],
  devices: [],
  thumbnail_img: "",
  _method: "PUT",
});

const handleUpdate = () => {
  form.post(route("books.update", form.id), {
    onSuccess: () => {
      SuccessDialog({ title: props.flash?.successMessage });
      dialog.value = false;
    },
    onError: (error) => {
      console.log(error);
    },
  });
};

onUpdated(() => {
    (form.id = props.datas.id),
    (form.name = props.datas.name),
    (form.description = props.datas.description),
    (form.thumbnail_img = props.datas.thumbnail_img),
    (form.disability_type = props.datas.disability_type),
    (form.sub_learning_needs = props.datas.learningneeds),
    (form.themes = props.datas.themes),
    (form.disability_type = props.datas.disability_types),
    (form.devices = props.datas.devices)
});
</script>
<template>
  <div>
    <v-btn
      @click="toggleDialog"
      icon="mdi-edit"
      size="x-small"
      color="secondary"
    ></v-btn>
    <v-dialog v-model="dialog" width="100%" max-width="800" persistent>
      <v-card>
        <v-card-title class="pa-0">
          <div class="faded-image">
            <v-img
              :src="form.thumbnail_img"
              :aspect-ratio="16 / 9"
              fill
              alt="Faded Image"
            />
            <div class="faded-overlay"></div>
            <div class="book-title">
              <v-text-field v-model="form.name"></v-text-field>
            </div>
            <div class="edit-icon">
              <v-btn
                icon="mdi-image-area"
                size="x-small"
                color="secondary"
              ></v-btn>
              <v-btn
                icon="mdi-content-save"
                size="x-small"
                color="secondary"
                @click="handleUpdate"
              ></v-btn>
              <Upload />
            </div>
            <div class="close-btn">
              <v-btn
                @click="dialog = false"
                color="default"
                variant="elevated"
                icon="$close"
                :rounded="false"
              >
              </v-btn>
            </div>
          </div>
        </v-card-title>
        <v-card-text class="px-10 py-0 pb-5">
          <div class="paragraph">
            <v-textarea
              class="max-w-edit-book"
              variant="outlined"
              v-model="form.description"
            ></v-textarea>
          </div>
          <div class="learning pt-2">
            <span class="font-weight-black text-black">Learning Needs</span
            ><br />
            <div class="d-flex">
              <v-chip-group>
                <div
                  class="ps-relative"
                  v-for="learning_need in form.sub_learning_needs"
                  :key="learning_need.id"
                >
                  <v-chip size="small">{{ learning_need.name }}</v-chip>
                  <div class="delete-chip">
                    <span>-</span>
                  </div>
                </div>
              </v-chip-group>
              <v-btn
                class="ml-10"
                size="x-small"
                icon="mdi-plus"
                color="secondary"
              ></v-btn>
            </div>
          </div>
          <div class="themes pt-2">
            <span class="font-weight-black text-black">Themes</span><br />
            <div class="d-flex">
              <v-chip-group>
                <div
                  class="ps-relative"
                  v-for="theme in form.themes"
                  :key="theme.id"
                >
                  <v-chip size="small">
                    {{ theme.name }}
                  </v-chip>
                  <div class="delete-chip">
                    <span>-</span>
                  </div>
                </div>
              </v-chip-group>
              <v-btn
                class="ml-10"
                size="x-small"
                icon="mdi-plus"
                color="secondary"
              ></v-btn>
            </div>
          </div>

          <div class="disability pt-2">
            <span class="font-weight-black text-black">Disability Types</span
            ><br />
            <div class="d-flex">
              <v-chip-group>
                <div
                  class="ps-relative"
                  v-for="disability_type in form.disability_type"
                  :key="disability_type.id"
                >
                  <v-chip size="small">
                    {{ disability_type.name }}
                  </v-chip>
                  <div class="delete-chip">
                    <span>-</span>
                  </div>
                </div>
              </v-chip-group>
              <v-btn
                class="ml-10"
                size="x-small"
                icon="mdi-plus"
                color="secondary"
              ></v-btn>
            </div>
          </div>

          <div class="supported pt-2">
            <span class="font-weight-black text-black"
              >Supported Accessibility Devices</span
            ><br />
            <div class="d-flex">
              <v-chip-group>
                <div
                  class="ps-relative"
                  v-for="device in form.devices"
                  :key="device.id"
                >
                  <v-chip size="small">{{ device.name }}</v-chip>
                  <div class="delete-chip">
                    <span>-</span>
                  </div>
                </div>
              </v-chip-group>
              <v-btn
                class="ml-10"
                size="x-small"
                icon="mdi-plus"
                color="secondary"
              ></v-btn>
            </div>
          </div>
        </v-card-text>
        <v-card-actions class="d-flex justify-end">
          <span class="text-caption">Last updated on 14 Aug 2023 1:04Am</span>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped>
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
  max-width: 650px;
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
.close-btn .v-btn--icon {
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
.edit-icon {
  position: absolute;
  bottom: -5px;
  right: 40px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.v-input__control {
  height: auto !important;
}

:deep(.v-text-field input) {
  color: var(--graphite, #282828) !important;
  font-size: 35px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 108.333% */
  text-transform: capitalize !important;
  padding-top: 0;
  padding-bottom: 0;
}

.delete-chip {
  background: rgb(109, 120, 141);
  border-radius: 50%;
  width: 15px;
  height: 15px;
  color: #fff;
  text-align: center;
  position: absolute;
  right: 0;
  top: 0;
}
.delete-chip span {
  position: absolute;
  top: -6px;
  left: 0;
  bottom: 0;
  right: 0;
  color: #fff;
}
.max-w-edit-book {
  max-width: 650px !important;
}
</style>
