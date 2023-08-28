<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "title", "type"]);
const isDialogVisible = ref(false)
const selectedImage = ref(null);

const handleFileUpload = (event) => {
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    selectedImage.value = URL.createObjectURL(selectedFile);
  }
};

const fileInput = ref(null);

const openFileInput = () => {
  fileInput.value.click();
};
</script>
<template #activator="{ props }">
    <v-btn  @click="isDialogVisible = true"  prepend-icon="mdi-plus" varient="flat" class="menuchip" rounded>Add</v-btn>

    <VDialog
        v-model="isDialogVisible"
        width="1000"
    >
        <!-- Activator -->
        <!-- Dialog Content -->
        <VCard class="rolling-card">
        <VCardText>
            <div class="d-flex justify-space-between">
                <div>
                    <span class="ruddy-bold resource-create-title">Upload File</span>
                </div>
                <div class="mt-2">
                    <v-icon @click="isDialogVisible = false">mdi-close</v-icon>
                </div>
            </div>
            <div class="mt-5">
                <div>
                    <span class="input-label-resource">Filename <span class="star">*</span></span>
                    <VTextField class="textfield-round" />
                </div>
                <div class="mt-3">
                    <VCard class="upload-card-resource" @click="openFileInput">
                        <v-img v-if="selectedImage" class="image-resource" :src="selectedImage" cover></v-img>
                        <div v-else class="card-text">
                            <div class="text-center">
                            <div class="d-flex justify-center">
                                <img src="/images/Icons.png" width="100">
                            </div>
                            <div class="mt-2">
                                <span class="drag-text">
                                    Drag your item to upload
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="fade-text">
                                    PNG, GIF, WebP, MP4 or MP3. Maximum file size 100 Mb.
                                </span>
                            </div>
                        </div>
                        </div>
                    </VCard>
                    <div>
                        <input type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
                    </div>
                    <div class="mt-10 d-flex justify-center">
                        <v-btn varient="flat" color="#F6F6F6" class="cancel pppangram-bold" @click="isDialogVisible = false"  width="200" rounded>
                            Cancel
                        </v-btn>
                        <v-btn varient="flat" color="#3749E9" class="textcolor ml-2 pppangram-bold" width="200" rounded>
                            Save
                        </v-btn>
                    </div>
                </div>
            </div>

        </VCardText>
        <!-- <VCardActions>
            <VSpacer />
            <VBtn @click="isDialogVisible = false">
            I accept
            </VBtn>
        </VCardActions> -->
        </VCard>
    </VDialog>
</template>
<style scoped>
.resource-create-title{
    color: #161616 !important;
    /* H3 Ruddy */
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.image-resource{
    height: 300px;
}

.input-label-resource{
    color: #000 !important;
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}
.upload-card-resource{
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}


::v-deep #input-162 {
    border-radius: 100px !important;
}
</style>
