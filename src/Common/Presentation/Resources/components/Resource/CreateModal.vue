<script setup>
import { router } from "@inertiajs/core";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

let props = defineProps(["route", "title", "type"]);
const isDialogVisible = ref(false);
const selectedImage = ref(null);
const file = ref(null);
const validationError = ref(null);

const form = useForm({
    filename: null,
    file: null
})

const errorModal = ref(false);
const errorText = ref(null);

const disabled = ref(false);

const validateFile = (file) => {
  const fileInput = file;
  // Check file format (mime type)
  if (!fileInput.type.startsWith('video/')) {
    validationError.value = 'Please select a valid video file.';
    return false;
  }

  // Check file size (10MB limit)
  const maxSizeInBytes = 100 * 1024 * 1024; // 10MB
  if (fileInput.size > maxSizeInBytes) {
    validationError.value = 'File size exceeds the 100 MB limit.';
    return false;
  }

  // Reset error message if the file is valid
  validationError.value = null;
  return true;
};

const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile && validateFile(selectedFile)) {
        file.value = selectedFile
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};

const removeVideo = () => {
    selectedImage.value = null;
    file.value = null
}

const submitResource = () => {
    // disabled.value = true;
    form.file = file.value
    form.post(route("resource.store"), {
    onSuccess: () => {
        disabled.value = false;
      isDialogVisible.value = false;
      SuccessDialog({ title: "You've successfully saved a video." });
    },
    onError: (error) => {
        errorText.value = error?.file
        errorModal.value = true
    },
  });
}

const fileInput = ref(null);

const openFileInput = () => {
    fileInput.value.click();
};
</script>
<template #activator="{ props }">
    <div>
        <v-btn
            @click="isDialogVisible = true"
            prepend-icon="mdi-plus"
            varient="flat"
            class="menuchip"
            rounded
            >Add</v-btn
        >

        <VDialog v-model="isDialogVisible" width="1000">
            <!-- Activator -->
            <!-- Dialog Content -->
            <VForm @submit.prevent="submitResource">
                <VCard class="rolling-card">
                    <VCardText>
                        <div class="d-flex justify-space-between">
                            <div>
                                <span class="ruddy-bold resource-create-title"
                                    >Upload File</span
                                >
                            </div>
                            <div class="mt-2">
                                <v-icon @click="isDialogVisible = false"
                                    >mdi-close</v-icon
                                >
                            </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <span class="input-label-resource"
                                    >Filename <span class="star">*</span></span
                                >
                                <VTextField v-model="form.filename" class="textfield-round" />
                            </div>
                            <div class="mt-3">
                                <div v-if="selectedImage" class="video-resource">
                                    <video controls autoplay class="videoDiv">
                                        <!-- Set the video source to the selected video file -->
                                        <source :src="selectedImage" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="d-flex justify-center">
                                        <VBtn @click="removeVideo">Remove</VBtn>
                                    </div>
                                </div>
                                <VCard v-else
                                    class="upload-card-resource"
                                    @click="openFileInput"
                                >
                                    <!-- <v-img
                                        v-if="selectedImage"
                                        class="image-resource"
                                        :src="selectedImage"
                                        cover
                                    ></v-img> -->
                                    <div class="card-text">
                                        <div  v-if="validationError" class="text-center">
                                            <span class="error-message pppangram-bold">
                                                {{ validationError }}
                                            </span>
                                        </div>
                                        <div v-else class="text-center">
                                            <div class="d-flex justify-center">
                                                <img
                                                    src="/images/Icons.png"
                                                    width="100"
                                                />
                                            </div>
                                            <div class="mt-2">
                                                <span class="drag-text">
                                                    Drag your item to upload
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="fade-text">
                                                    PNG, GIF, WebP, MP4 or MP3.
                                                    Maximum file size 100 Mb.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </VCard>
                                <div>
                                    <input
                                        type="file"
                                        ref="fileInput"
                                        class="d-none"
                                        @change="handleFileUpload"
                                    />
                                </div>
                                <div class="mt-10 d-flex justify-center">
                                    <v-btn
                                        varient="flat"
                                        color="#F6F6F6"
                                        class="cancel pppangram-bold"
                                        @click="isDialogVisible = false"
                                        width="200"
                                        rounded
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        type="submit"
                                        varient="flat"
                                        color="#3749E9"
                                        :disabled="disabled"
                                        class="textcolor ml-2 pppangram-bold"
                                        width="200"
                                        rounded
                                    >
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
            </VForm>
        </VDialog>

        <VDialog v-model="errorModal" width="50%">
            <VCard class="rolling-card">
                <VCardText>
                    <span class="error_text">Upload Failed ! Because {{ errorText }}</span>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
<style scoped>

.error_text {
    color: red !important;
}

.resource-create-title {
    color: #161616 !important;
    /* H3 Ruddy */
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.image-resource {
    height: 300px;
}

.input-label-resource {
    color: #000 !important;
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}
.upload-card-resource {
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}

:deep(#input-162) {
    border-radius: 100px !important;
}

.error-message{
    color: red !important;
}

.videoDiv{
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
}
</style>
