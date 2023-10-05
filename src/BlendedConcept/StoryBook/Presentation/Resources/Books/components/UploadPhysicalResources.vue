<script setup>
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

const props = defineProps({
    isPhysicalDialog: {
        type: Boolean,
        default: false,
    },
    physical_resources: {
        type: Array,
        default: [],
    },
    book_id: {
        default: null,
    },
});
const emit = defineEmits(["update:isPhysicalDialog"]);
const uploadedImages = ref([]);
const oldImages = ref([]);
const form = useForm({
    physical_resources: [],
    delete_physical_resources: [],
    _method: "PUT",
});
const handleFileUpload = (event) => {
    event.preventDefault();
    const files = event.target.files;
    if (files.length > 0) {
        // emit("update:modelValue", event.dataTransfer.files[0]);
        for (const file of files) {
            uploadedImages.value.push({
                id: null,
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
            form.physical_resources.push(file);
        }
    }
};
const handleDrop = (event) => {
    event.preventDefault();
    const files = event.dataTransfer.files;

    if (files.length > 0) {
        for (const file of files) {
            uploadedImages.value.push({
                id: null,
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
            form.physical_resources.push(file);
        }
    }
};

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
    form.physical_resources.splice(index, 1);
};
const removeOldUploadedItem = (index, id) => {
    form.delete_physical_resources.push(id);
    oldImages.value.splice(index, 1);
    console.log(form.delete_physical_resources);
};
const handleFileInputClick = () => {
    const fileInput = document.getElementById("file-input");
    fileInput.click();
};
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 30) {
            return text;
        } else {
            return text?.substring(0, 30) + "...";
        }
    }
};
const dialogVisibleUpdate = (val) => {
    emit("update:isPhysicalDialog", val);
};
const onFormSubmit = () => {
    form.post(route("books.update_physical_resources", props.book_id), {
        onSuccess: () => {
            SuccessDialog({ title: "Updated Successfully" });
            emit("update:isPhysicalDialog", false);
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
const onFormReset = () => {
    emit("update:isPhysicalDialog", false);
};

onMounted(() => {
    for (const file of props.physical_resources) {
        oldImages.value.push({
            id: file.id,
            file: null,
            src: file.url,
            name: file.file_name,
        });
    }
});
</script>

<template>
    <VDialog
        :model-value="props.isPhysicalDialog"
        @update:model-value="dialogVisibleUpdate"
        width="500"
    >
        <!-- Dialog Content -->

        <VCard>
            <VForm ref="refForm" @submit.prevent="onFormSubmit">
                <VCardText class="pa-0 file-drop">
                    <div class="mt-3">
                        <div
                            id="old"
                            class="image-container mt-2 mx-4"
                            v-for="(image, index) in oldImages"
                            :key="index"
                        >
                            <div class="d-flex justify-space-between">
                                <div class="d-flex">
                                    <img
                                        :src="image.src"
                                        class="import-file-img mt-2 ml-3"
                                    />
                                    <p class="ml-3 mt-3">
                                        {{ truncatedText(image.name) }}
                                    </p>
                                </div>

                                <div class="mt-3 mr-3">
                                    <VIcon
                                        icon="mdi-close"
                                        @click="
                                            removeOldUploadedItem(
                                                index,
                                                image.id
                                            )
                                        "
                                    ></VIcon>
                                </div>
                            </div>
                        </div>
                        <div
                            id="new"
                            class="image-container mt-2 mx-4"
                            v-for="(image, index) in uploadedImages"
                            :key="index"
                        >
                            <div class="d-flex justify-space-between">
                                <div class="d-flex">
                                    <img
                                        :src="image.src"
                                        class="import-file-img mt-2 ml-3"
                                    />
                                    <p class="ml-3 mt-3">
                                        {{ truncatedText(image.name) }}
                                    </p>
                                </div>

                                <div class="mt-3 mr-3">
                                    <VIcon
                                        icon="mdi-close"
                                        @click="removeUploadedItem(index)"
                                    ></VIcon>
                                </div>
                            </div>
                        </div>
                        <div
                            class="coming-soon mt-4"
                            @dragover.prevent
                            @drop="handleDrop"
                        >
                            <div
                                class="text-center"
                                @click="handleFileInputClick()"
                            >
                                <p class="pppangram-normal">
                                    Drag & Drop
                                    <strong class="colorprimary"></strong>
                                    file here
                                    <br />
                                    or <br />
                                    Click to browser files
                                </p>
                            </div>
                        </div>
                        <input
                            id="file-input"
                            type="file"
                            ref="fileInput"
                            class="d-none"
                            multiple="multiple"
                            @change="handleFileUpload"
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
    </VDialog>
</template>
<style scoped>
.import-file-img {
    width: 40px;
    height: 40px;
}

.import-card-text {
    cursor: pointer;
    border-radius: 10px;
    border: 2px dashed var(--gray, #bfc0c1);
    padding: 10px;
    border-spacing: 4px !important;
    /* Adjust the spacing between dashes */
    justify-content: center;
    align-items: center;
}

.imprt-path-text {
    border-radius: 10px;
    border: 2px dashed var(--gray, #bfc0c1);
    display: flex;
    width: 469px;
    height: 299px;
    padding: 56px 79px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 17px;
    flex-shrink: 0;
}

.image-container {
    background: #f6f6f6;
    border-radius: 15px;
    border: 1px solid var(--line, #e5e5e5);
    padding: 4px;
}

.import-fade-text {
    color: var(--secondary-2, rgba(86, 86, 96, 0.4));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important;
    /* 157.143% */
    text-transform: capitalize !important;
}

.importfile-title {
    color: var(--tiggie-blue, #4066e4);
    font-size: 25px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 42px;
    /* 140% */
    text-transform: capitalize;
}
.file-drop {
    height: 100%;
    padding: 30px !important;
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
</style>
