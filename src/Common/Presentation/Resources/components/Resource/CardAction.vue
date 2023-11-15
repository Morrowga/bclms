<script setup>
import { router } from "@inertiajs/core";
import EditModal from "@mainRoot/components/Resource/EditModal.vue";
import { isConfirmedDialog } from "@actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { FlashMessage } from "@actions/useFlashMessage";

let props = defineProps({
    data: {
        type: Object,
    },
    current_user: {
        type: Object,
    },
    check_type: {
        type: Boolean,
    },
});

const isEditDialogVisible = ref(false);
const selectedImage = ref(props.data.video_url);
const file = ref(null);
const validationError = ref(null);
let flash = computed(() => usePage().props.flash);
const mimeType = ref(props.data.mime_type);

const form = useForm({
    filename: props.data.name,
    file: null,
    user_id: props.data.model_id,
    _method: "PUT",
});

const validateFile = (file) => {
    const fileInput = file;
    // Check file format (mime type)
    if (
        !fileInput.type.startsWith("video/") &&
        !fileInput.type.startsWith("image/")
    ) {
        validationError.value = "Please select a valid video or image file.";
        return false;
    }

    // Check file size (10MB limit)
    const maxSizeInBytes = 100 * 1024 * 1024; // 100MB
    if (fileInput.size > maxSizeInBytes) {
        validationError.value = "File size exceeds the 100MB limit.";
        return false;
    }

    // Reset error message if the file is valid
    validationError.value = null;
    return true;
};

const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile && validateFile(selectedFile)) {
        mimeType.value = selectedFile.type;
        file.value = selectedFile;
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};

const removeVideo = () => {
    selectedImage.value = null;
    file.value = null;
    mimeType.value = null;
};

const updateResource = () => {
    form.file = file.value;
    form.post(route("resource.update", props.data.id), {
        onSuccess: () => {
            isEditDialogVisible.value = false;
            FlashMessage({ flash });
        },
        onError: (error) => {
            SuccessDialog({
                title: error?.file,
                icon: "warning",
                color: "#ff6262",
                mainTitle: "Failed!",
            });
        },
    });
};

const deleteOnclick = () => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete("/resource/" + props.data.id, {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
            });
        },
    });
};

const publish = () => {
    const publishForm = useForm({});
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,publish it!",
        icon: "success",
        onConfirm: () => {
            publishForm.post(
                "/resource/request-publish/" +
                    props.data.id +
                    "?size=" +
                    props.data.size,
                {
                    onSuccess: () => {
                        FlashMessage({ flash });
                    },
                }
            );
        },
    });
};

const copyLink = () => {
    const linkToCopy = props.data.video_url;

    const inputElement = document.createElement("input");
    inputElement.value = linkToCopy;

    document.body.appendChild(inputElement);

    inputElement.select();
    inputElement.setSelectionRange(0, 99999);

    document.execCommand("copy");

    document.body.removeChild(inputElement);
    // props.data.video_url
};

const downloadImage = () => {
    const linkToDownload = props.data.video_url;

    const anchorElement = document.createElement("a");
    anchorElement.href = linkToDownload;
    anchorElement.download = props.data.file_name; // You can change the default downloaded file name here

    document.body.appendChild(anchorElement);

    anchorElement.click();

    document.body.removeChild(anchorElement);
};

const fileInput = ref(null);

const openFileInput = () => {
    fileInput.value.click();
};

onMounted(() => {
    // console.log(props.data);
});
</script>
<template #activator="{ props }">
    <div>
        <span class="resourcemenu mt-2 ml-10">
            <span
                style="
                    color: #000;
                    background: #ffcc01;
                    border-radius: 50%;
                    padding: 5px 10px 13px 10px;
                "
                >...</span
            >

            <v-menu activator="parent">
                <v-list>
                    <v-list-item
                        @click="downloadImage"
                        v-if="mimeType.startsWith('image/')"
                    >
                        <v-list-item-title>Download Image</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="copyLink">
                        <v-list-item-title>Copy Link</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="isEditDialogVisible = true">
                        <v-list-item-title>Edit</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="deleteOnclick">
                        <v-list-item-title>Delete</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="publish()" v-if="props.check_type">
                        <v-list-item-title
                            >Publish to Organization</v-list-item-title
                        >
                    </v-list-item>
                </v-list>
            </v-menu>
        </span>
        <VDialog v-model="isEditDialogVisible" width="1000">
            <VForm @submit.prevent="updateResource">
                <VCard class="rolling-card">
                    <VCardText>
                        <div class="d-flex justify-space-between">
                            <div>
                                <span class="ruddy-bold resource-create-title"
                                    >Edit File</span
                                >
                            </div>
                            <div class="mt-2">
                                <v-icon @click="isEditDialogVisible = false"
                                    >mdi-close</v-icon
                                >
                            </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <span class="input-label-resource"
                                    >Filename <span class="star">*</span></span
                                >
                                <VTextField
                                    v-model="form.filename"
                                    class="textfield-round"
                                />
                            </div>
                            <div class="mt-3">
                                <div
                                    v-if="selectedImage"
                                    class="video-resource"
                                >
                                    <video
                                        v-if="
                                            selectedImage &&
                                            mimeType.startsWith('video/')
                                        "
                                        controls
                                        autoplay
                                        class="videoDiv"
                                    >
                                        <!-- Set the video source to the selected video file -->
                                        <source
                                            :src="selectedImage"
                                            type="video/mp4"
                                        />
                                        Your browser does not support the video
                                        tag.
                                    </video>
                                    <img
                                        v-else-if="
                                            selectedImage &&
                                            mimeType.startsWith('image/')
                                        "
                                        :src="selectedImage"
                                        class="image-resource"
                                        alt="Uploaded Image"
                                    />
                                    <div class="d-flex justify-center">
                                        <VBtn @click="removeVideo">Remove</VBtn>
                                    </div>
                                </div>
                                <VCard
                                    v-else
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
                                        <div
                                            v-if="validationError"
                                            class="text-center"
                                        >
                                            <span
                                                class="error-message pppangram-bold"
                                            >
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
                                        @click="isEditDialogVisible = false"
                                        width="200"
                                        rounded
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        type="submit"
                                        varient="flat"
                                        color="#3749E9"
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
                </VCard>
            </VForm>
        </VDialog>
    </div>
</template>
<style>
.uploadedchip {
    display: flex;
    background: #e5e5e5;
    border-radius: 15px;
    align-items: center;
    width: 100%;
    padding: 16px 10px 16px 16px;
    gap: 15px;
    height: 74px;
    /* display: block; */
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

.resourcemenu {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute !important;
    z-index: 1 !important;
    cursor: pointer;
    color: #000 !important;
    right: 3%;
}

.error_text {
    color: red !important;
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

.videoDiv {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
}
</style>
