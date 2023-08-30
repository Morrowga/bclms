<script setup>
import { ref } from "vue"
const isDialogVisible = ref(false)
import FileUpload from 'primevue/fileupload';

let props = defineProps(["type"]);

const items = [
    'Blended Concepted',
    'Blended Center',
    'Bentlee School of Hope',
    'Korbbe Collibe Home',
];
const uploadedImages = ref([]);
const fileInput = ref(null);

console.log(props.type);

const handleDrop = (event) => {
  event.preventDefault();
  const files = event.dataTransfer.files;

  if (files.length > 0) {
    for (const file of files) {
        uploadedImages.value.push({
        file: file,
        src: URL.createObjectURL(file),
        name: file.name
      });
    }
  }
};
// const openFileInput = () => {
//   fileInput.value.click();
// };


// const handleFileUpload = (event) => {
//   const files = event.target.files;

//   if (files.length > 0) {
//     for (const file of files) {
//         uploadedImages.value.push({
//         file: file,
//         src: URL.createObjectURL(file),
//         name: file.name
//       });
//     }
//   }

//   fileInput.value.value = '';
// };

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
}
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" color="primary" variant="flat" width="164px">
                <span class="text-white">Next</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex justify-center">
            <!-- <VCardTitle>

            </VCardTitle> -->
            <!-- <VCardText>
                <p class="tiggie-p"> <span class="text-primary pr-2">2</span>teachers remaining</p>
            </VCardText> -->
            <VCardText>
                <p class="importfile-title pppangram-bold ml-5 mt-5">
                    Upload {{props.type}}
                    <VIcon icon="mdi-file-download" class="ml-10" color="primary" size="30px" />
                </p>
                <p class="pppangram-bold ml-5" style="color: #000; font-size: 20px !important;"><strong style="color: #4066e4; font-size: 20px !important;">2</strong> {{type}} Remaining</p>
                <div class="mt-3">
                    <div class="image-container mt-2 mx-4" v-for="(image, index) in uploadedImages" :key="index">
                        <div class="d-flex justify-space-between">
                            <div class="d-flex">
                                <img :src="image.src" class="import-file-img mt-2 ml-3">
                                <p class="ml-3 mt-3">{{ image.name }}</p>
                            </div>

                            <div class="mt-3 mr-3">
                                <VIcon icon="mdi-close" @click="removeUploadedItem(index)"></VIcon>
                            </div>
                        </div>
                    </div>
                    <div class="import-card-text mt-6 mx-5" @dragover.prevent @drop="handleDrop" >
                        <div class="text-center">
                            <div class="mt-2">
                                <span class="import-fade-text">
                                    Drag and Drop HTML5 Files here
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="import-fade-text">
                                    or
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="import-fade-text">
                                    Click to browse files
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- <input type="file" ref="fileInput" style="display: none" @change="handleFileUpload"> -->
                </div>
            </VCardText>

            <VCardActions class="d-flex justify-center gap-5 ml-5 mt-5">
                <VBtn color="gray" variant="flat" width="164px" @click="isDialogVisible = false">
                    <span class="text-white">Cancel</span>
                </VBtn>
                <VBtn color="primary" variant="flat" width="164px">
                    <span class="text-white">Next</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<style scoped>
@import"primevue/resources/themes/lara-light-indigo/theme.css";


.import-file-img{
    width: 40px;
    height: 40px;
}

.import-card-text{
    cursor: pointer;
    border-radius: 10px;
    border: 2px dashed var(--gray, #BFC0C1);
    padding: 10px;
    border-spacing: 4px !important; /* Adjust the spacing between dashes */
    justify-content: center;
    align-items: center;
}

.image-container{
    background: #F6F6F6;
    border-radius: 15px;
    border: 1px solid var(--line, #E5E5E5);
    padding: 4px;
}

.import-fade-text{
    color: var(--secondary-2, rgba(86, 86, 96, 0.40));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important; /* 157.143% */
    text-transform: capitalize !important;
}
.importfile-title{
    color: var(--tiggie-blue, #4066E4);
    font-size: 25px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 42px; /* 140% */
    text-transform: capitalize;
}
</style>
