<script setup>
import { defineProps, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import {
  emailValidator,
  requiredValidator,
  integerValidator,
} from "@validators";
const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
  disabilityTypes: {
    type: Object,
  },
  devices: {
    type: Object,
  },
});
console.log(props.devices);
let dialog = ref(false);
const gameTag = ref("");
const gameFile = ref(null);
const thumbnail = ref(null);
const dragging = ref(false);
const thumbnailFile = ref(null);

const form = useForm({
  name: null,
  description: null,
  tags: [],
  disability_type_id: [],
  devices: [],
  game: null,
  thumb: null,
  num_gold_coins: 0,
  num_silver_coins: 0,
});

const handleGameFileChange = (event) => {
  const file = event.target.files[0];
  gameFile.value = file;
};

const removeGameFile = () => {
  gameFile.value = null;
};

const handleThumbnailChange = (event) => {
  const file = event.target.files[0];
  thumbnailFile.value = file;
  thumbnail.value = URL.createObjectURL(file);
};

const removeThumbnail = () => {
  thumbnail.value = null;
  thumbnailFile.value = null;
};

const onDropGameFile = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  gameFile.value = files[0];
};

const onDropThumbnail = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  thumbnail.value = URL.createObjectURL(files[0]);
  thumbnailFile.value = files[0];
};

const toggleDialog = () => {
  dialog.value = !dialog.value;
};

let onFormSubmit = () => {
  console.log(form);
  form.game = gameFile.value;
  form.thumb = thumbnailFile.value;
  form.post(route("games.store"), {
    onSuccess: () => {
      // SuccessDialog({ title: "You've successfully updated a question." });
    },
    onError: (error) => {
      form.setError("name", error?.name);
      form.setError("description", error?.description);
      form.setError("game", error?.game);
      form.setError("thumb", error?.thumb);
      form.setError("disability_type_id", error?.disability_type_id);
      form.setError("tags", error?.tags);
      form.setError("devices", error?.devices);
    },
  });
  // SuccessDialog({ title: "Successfully Game added" });
  dialog.value = false;
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
    <VBtn @click="toggleDialog()">Add New Game</VBtn>

    <v-dialog v-model="dialog" max-width="800">
      <v-card>
        <v-card-text class="px-10 py-0 pb-5">
          <v-form class="mt-6" @submit.prevent="onFormSubmit">
            <v-row>
              <v-col cols="12" md="6" class="pb-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Game Name</VLabel>
                  <VTextField
                    type="text"
                    v-model="form.name"
                    class="tiggie-resize-input-text game-name-input"
                    placeholder="Text here"
                    density="compact"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.name"
                  />
                </v-col>
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
              <v-col cols="12" md="12" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Game Description</VLabel>
                  <v-textarea
                    type="text"
                    v-model="form.description"
                    rows="5"
                    density="compact"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.description"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Disability Type</VLabel>
                  <v-autocomplete
                    v-model="form.disability_type_id"
                    :items="props.disabilityTypes"
                    multiple
                    type="text"
                    item-value="id"
                    item-title="name"
                    class="tiggie-resize-input-text disability-type-input"
                    placeholder="Select disability type"
                    density="compact"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.disability_type_id"
                  />
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label"
                    >Supported Accessibility Devices</VLabel
                  >
                  <v-autocomplete
                    v-model="form.devices"
                    :items="props.devices"
                    multiple
                    type="text"
                    item-value="id"
                    item-title="name"
                    class="tiggie-resize-input-text"
                    placeholder="Select devices"
                    density="compact"
                    :rules="[requiredValidator]"
                    :error-messages="form?.errors?.devices"
                  />
                </v-col>
              </v-col>

              <v-col cols="12" md="6" class="py-0 mt-5">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Game File</VLabel>
                  <div
                    class="drop-zone coming-soon"
                    @dragover.prevent
                    @dragenter.prevent
                    @dragleave="dragging = false"
                    @drop.prevent="onDropGameFile"
                  >
                    <p v-if="!gameFile">Drag & Drop game file</p>
                    <div v-else>
                      <p>File Name: {{ gameFile.name }}</p>
                      <button @click="removeGameFile" class="remove-button">
                        Remove
                      </button>
                    </div>
                    <input
                      type="file"
                      style="display: none"
                      @change="handleGameFileChange"
                      :error-messages="form?.errors?.game"
                    />
                  </div>
                </v-col>
              </v-col>
              <v-col cols="12" md="6" class="py-0 mt-5">
                <v-col cols="12" md="12">
                  <VLabel class="tiggie-label">Thumbnail Picture</VLabel>
                  <div
                    class="drop-zone coming-soon"
                    @dragover.prevent
                    @dragenter.prevent
                    @dragleave="dragging = false"
                    @drop.prevent="onDropThumbnail"
                  >
                    <input
                      type="file"
                      style="display: none"
                      @change="handleThumbnailChange"
                    />
                    <p v-if="!thumbnail">Drag & Drop thumbnail</p>
                    <div v-else>
                      <v-img :src="thumbnail" alt="Thumbnail" cover />
                      <button @click="removeThumbnail" class="remove-button">
                        Remove
                      </button>
                    </div>
                    <div
                      :rules="[requiredValidator]"
                      :error-messages="form?.errors?.game"
                    ></div>
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
