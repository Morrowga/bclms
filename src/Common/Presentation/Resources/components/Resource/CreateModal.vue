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

const disabled = ref(false);

const validateFile = (file) => {
    const fileInput = file;

    const allowedFormats = [
        "video/mp4", "video/webm", "video/ogg",
        "image/jpeg", "image/jpg", "image/png", "image/gif", "image/bmp", "image/tiff", "image/tif", "image/svg+xml",
        "audio/mp3", "audio/mpeg", "audio/wav", "audio/ogg", "audio/m4a",
        "application/pdf", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "text/css", "text/csv", "text/plain", "text/rtf", "text/xml", "text/markdown", "text/vtt", "text/x-diff",
        "font/ttf", "font/otf", "font/woff", "font/woff2", "application/x-font-ttf", "application/font-woff", "application/font-woff2", "application/vnd.ms-fontobject", "font/opentype", "application/x-font-opentype", "application/x-font-truetype",
        "application/json", "application/javascript",
        "application/x-shockwave-flash",
        "application/vnd.oasis.opendocument.presentation", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text"
    ];

    if (!allowedFormats.includes(fileInput.type)) {
        validationError.value = 'Please select a valid file format.';
        return false;
    }

    // Check file size (100MB limit)
    const maxSizeInBytes = 100 * 1024 * 1024; // 100MB
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
    disabled.value = true;
    form.file = file.value
    form.post(route("resource.store"), {
    onSuccess: () => {
      disabled.value = false;
      isDialogVisible.value = false;
      SuccessDialog({ title: "You've successfully saved a video." });
    },
    onError: (error) => {
        disabled.value = false;
        isDialogVisible.value = false;
        SuccessDialog({ title: error?.file, icon: 'warning',color: '#ff6262', mainTitle: 'Failed!' });
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
                                <div v-if="selectedImage" class="resource-content">
                                    <!-- Render video if the uploaded file is a video type -->
                                    <video v-if="file?.type && file.type.startsWith('video/')" controls autoplay class="videoDiv">
                                        <source :src="selectedImage" :type="file.type">
                                        Your browser does not support the video tag.
                                    </video>
                                    
                                    <!-- Render audio if the uploaded file is an audio type -->
                                    <audio v-else-if="file?.type && file.type.startsWith('audio/')" controls class="audioPlayer">
                                        <source :src="selectedImage" :type="file.type">
                                        Your browser does not support the audio tag.
                                    </audio>
                                    
                                    <!-- Render image if the uploaded file is an image type -->
                                    <img v-else-if="file?.type && (file.type.startsWith('image/'))" :src="selectedImage" class="image-resource" alt="Uploaded Image" />

                                    <!-- TODO: Add other preview elements for different file types like PDF, DOCX, etc. if required -->

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
    Allowed formats: Images (PNG, JPG, JPEG, GIF, BMP, TIFF, SVG, WebP), Videos (MP4, WebM, OGG), Audios (MP3, M4A, WAV, OGG), Documents (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ODT, ODS, ODP), Text (TXT, RTF, MD, CSV, XML, VTT, CSS, JS, JSON, DIFF), Fonts (TTF, OTF, WOFF, WOFF2), SWF. Maximum file size: 100MB.
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
