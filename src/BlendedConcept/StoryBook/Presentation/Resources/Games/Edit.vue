<script setup>
import { defineProps, ref, defineEmits } from "vue";
import { useForm } from "@inertiajs/vue3";
import UploadGameFile from "./components/UploadGameFile.vue";
import UploadThumbnail from "./components/UploadThumbnail.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { format } from "date-fns";

const props = defineProps({
  datas: {
    type: Object,
    required: true,
  },
  disabilitytypes: {
    type: Object,
    requird: true,
  },
});
let emit = defineEmits();
let dialog = ref(false);
let gameFileDialog = ref(false);
let thumbnailDialog = ref(false);
let tags = ref([]);
let types = ref([]);
let systemDisabilityTypes = ref([]);
const getGameFile = ref(null);
const getThumbFile = ref(null);

props.datas.tags.forEach((item) => {
  tags.value.push(item.name);
});

props.datas.disability_types.forEach((item) => {
  types.value.push({
    id: item.id,
    name: item.name,
  });
});

props.disabilitytypes.forEach((item) => {
  systemDisabilityTypes.value.push({
    id: item.id,
    name: item.name,
  });
});

const toggleDialog = () => {
  dialog.value = !dialog.value;
};
const formSubmit = useForm({
  name: props.datas.name,
  description: props.datas.description,
  disability_type_id: null,
  devices: [],
  tags: tags.value,
  game: null,
  thumb: null,
  num_gold_coins: props.datas.num_gold_coins,
  num_silver_coins: props.datas.num_silver_coins,
  _method: "PUT",
});

const handleGameFileModalSubmit = (data) => {
  getGameFile.value = data.game;
};

const handleThumbnailModalSubmit = (data) => {
  getThumbFile.value = data.thumb;
};

let updateformSubmit = () => {
  let typeIds = [];
  types.value.forEach((item) => {
    typeIds.push(item.id);
  });

  formSubmit.game = getGameFile.value;
  formSubmit.thumb = getThumbFile.value;
  formSubmit.disability_type_id = typeIds;
  console.log(formSubmit);
  formSubmit.post(route("games.update", props.datas.id), {
    onSuccess: () => {
      dialog.value = false;
    },
    onError: (error) => {},
  });
};

const removeFromArray = (disabilityId) => {
  types.value = types.value.filter((item) => item.id !== disabilityId);
};

const addToArray = (disability) => {
  types.value.push(disability);
};

const isInGameDisabilityTypes = (disabilityId) => {
  return types.value.some((type) => type.id === disabilityId);
};

const formatDate = (dateString) => {
  // Parse the date string into a Date object
  const date = new Date(dateString);
  // Format the date using date-fns
  return format(date, "d MMM yyyy h:mm  a"); // Customize the format string as needed
};
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
      <VForm @submit.prevent="updateformSubmit">
        <v-card>
          <v-card-title class="pa-0">
            <div class="faded-image">
              <img
                :src="'/images/teacherbanner.png'"
                class="img-header"
                alt="Faded Image"
              />
              <div class="faded-overlay"></div>
              <div class="book-title">
                <!-- <span>Boj Giggly Park Adventure</span> -->
                <v-text-field v-model="formSubmit.name"></v-text-field>
              </div>
              <div class="edit-icon">
                <v-btn
                  @click="thumbnailDialog = true"
                  icon="mdi-image-area"
                  size="x-small"
                  color="secondary"
                ></v-btn>
                <v-btn
                  type="submit"
                  icon="mdi-content-save"
                  size="x-small"
                  color="secondary"
                ></v-btn>
                <v-btn
                  @click="gameFileDialog = true"
                  icon="mdi-upload"
                  size="x-small"
                  color="secondary"
                ></v-btn>
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
                class="max-w-600"
                variant="outlined"
                v-model="formSubmit.description"
              ></v-textarea>
            </div>
            <br />
            <div class="disability">
              <span class="font-weight-black text-black">Disability Types</span
              ><br />
              <div class="d-flex mt-3">
                <v-chip-group>
                  <div
                    class="ps-relative"
                    v-for="(disabilityType, index) in systemDisabilityTypes"
                    :key="index"
                  >
                    <v-chip size="small">
                      {{ disabilityType.name }}
                    </v-chip>
                    <div
                      class="delete-chip"
                      v-if="isInGameDisabilityTypes(disabilityType.id)"
                    >
                      <span @click="removeFromArray(disabilityType.id)">-</span>
                    </div>
                    <div class="add-chip" v-else>
                      <span @click="addToArray(disabilityType)">+</span>
                    </div>
                  </div>
                </v-chip-group>
              </div>
            </div>
            <br />
            <div class="supported">
              <span class="font-weight-black text-black"
                >Supported Accessibility Devices</span
              ><br />
              <div class="d-flex">
                <v-chip-group>
                  <div class="ps-relative">
                    <v-chip size="small">Mouse/Keyboard</v-chip>
                    <div class="delete-chip">
                      <span>-</span>
                    </div>
                  </div>
                  <div class="ps-relative">
                    <v-chip size="small">Switch-Single</v-chip>
                    <div class="delete-chip">
                      <span>-</span>
                    </div>
                  </div>
                  <div class="ps-relative">
                    <v-chip size="small">Switch-Double</v-chip>
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
            <span class="text-caption"
              >Last updated on {{ formatDate(datas.updated_at) }}</span
            >
          </v-card-actions>
        </v-card>
      </VForm>
    </v-dialog>
  </div>
  <UploadGameFile
    v-model:isGameFileDialogVisible="gameFileDialog"
    @submit="handleGameFileModalSubmit"
  />
  <UploadThumbnail
    v-model:isThumbnailDialogVisible="thumbnailDialog"
    @submit="handleThumbnailModalSubmit"
  />
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
  cursor: pointer;
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

.add-chip {
  background: rgb(109, 120, 141);
  border-radius: 50%;
  width: 15px;
  height: 15px;
  cursor: pointer;
  color: #fff;
  text-align: center;
  position: absolute;
  right: 0;
  top: 0;
}
.add-chip span {
  position: absolute;
  top: -6px;
  left: 0;
  bottom: 0;
  right: 0;
  color: #fff;
}
</style>
