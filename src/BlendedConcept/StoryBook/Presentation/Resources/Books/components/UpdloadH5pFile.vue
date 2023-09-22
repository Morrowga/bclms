<script setup>
import UpdloadH5pGame from "./components/UpdloadH5pGame.vue"
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  isGameFileDialogVisible: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["submit", "update:isGameFileDialogVisible"]);

const h5pFile = ref(null);
const dragging = ref(false);

const handleGameFileChange = (event) => {
  const file = event.target.files[0];
  h5pFile.value = file;
};

const removeGameFile = () => {
  h5pFile.value = null;
};

const onDropGameFile = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  h5pFile.value = files[0];
};

const form = useForm({
  h5p: null,
});

const onFormSubmit = () => {
  h5p.game = h5pFile.value;
  emit("submit", form);
  emit("update:isGameFileDialogVisible", false);
};

const onFormReset = () => {
  emit("update:isGameFileDialogVisible", false);
};

const dialogVisibleUpdate = (val) => {
  emit("update:isGameFileDialogVisible", val);
};

const handleFileInputClick = () => {
  const fileInput = document.getElementById("game-file-input");
  fileInput.click();
};
</script>

<template>
  <VDialog
    :model-value="props.isGameFileDialogVisible"
    @update:model-value="dialogVisibleUpdate"
    width="500"
  >
    <!-- Dialog Content -->
    <div>
      <VCard>
        <VForm class="mt-6" ref="refForm" @submit.prevent="onFormSubmit">
          <VCardText>
            <p class="heading-upload-modal">Upload Game File</p>

            <span class="warning-text pppangram-normal"
              >Warnings: This will override the existing game file!</span
            >

            <div
              class="drop-zone coming-soon mt-4"
              @dragover.prevent
              @dragenter.prevent
              @dragleave="dragging = false"
              @drop.prevent="onDropGameFile"
            >
              <p
                v-if="!gameFile"
                class="pppangram-normal"
                @click="handleFileInputClick"
              >
                Drag & Drop <strong class="colorprimary">HTML5</strong> file
                here <br />
                or <br />
                Click to browser files
              </p>
              <div v-else>
                <p>File Name: {{ h5pFile.name }}</p>
                <button @click="removeGameFile" class="remove-button">
                  Remove
                </button>
              </div>
              <input
                id="game-file-input"
                type="file"
                style="display: none"
                @change="handleGameFileChange"
                :error-messages="form?.errors?.game"
              />
            </div>
          </VCardText>

          <VCardActions class="pt-3 justify-center">
            <VBtn
              color="secondary"
              text-color="white"
              variant="tonal"
              class="pl-16 pr-16"
              @click="onFormReset"
              height="50"
            >
              <span class="text-dark">Close</span>
            </VBtn>
            <VBtn
              type="submit"
              variant="tonal"
              class="pl-16 pr-16 submit-btn-color"
              height="50"
            >
              <span>Submit</span>
            </VBtn>
          </VCardActions>
        </VForm>
      </VCard>
    </div>
  </VDialog>
</template>
<style scoped>
.width-high {
  width: 50px !important;
  height: 50px !important;
}

.heading-upload-modal {
  margin: 0;
  font-size: 20px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
  color: var(--tiggie-blue, #4066e4);
}

.warning-text {
  color: red !important;
  font-size: 15px !important;
}

.submit-btn-color {
  background: #4066e4 !important;
  color: #fff !important;
}
.colorprimary {
  color: #4066e4 !important;
}
</style>
