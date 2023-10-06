<script setup>
import { defineProps, ref, defineEmits } from "vue";

const uploadedImages = ref([]);
const modelValues = ref([]);
const props = defineProps({
    data_type: {
        type: String,
        default: "user",
    },
    hide_count: {
        type: Boolean,
        default: false,
    },
});

let emit = defineEmits("update:modelValue");
const handleFileUpload = (event) => {
    event.preventDefault();
    const files = event.target.files;
    if (files.length > 0) {
        // emit("update:modelValue", event.dataTransfer.files[0]);
        for (const file of files) {
            uploadedImages.value.push({
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
            modelValues.value.push(file);
        }
    }
    emit("update:modelValue", modelValues.value);
};
const handleDrop = (event) => {
    event.preventDefault();
    const files = event.dataTransfer.files;

    if (files.length > 0) {
        for (const file of files) {
            uploadedImages.value.push({
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
            modelValues.value.push(file);
        }
    }
    emit("update:modelValue", modelValues.value);
};

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
    modelValues.value.splice(index, 1);
    emit("update:modelValue", modelValues.value);
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
</script>
<template>
    <VCardText class="pa-0 file-drop">
        <p class="pppangram-bold ml-5 fs-20 t-black" :hidden="props.hide_count">
            <strong class="fs-20 l-blue">2</strong>
            {{ type }} Remaining
        </p>
        <div class="mt-3">
            <div
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
                        <p class="ml-3 mt-3">{{ truncatedText(image.name) }}</p>
                    </div>

                    <div class="mt-3 mr-3">
                        <VIcon
                            icon="mdi-close"
                            @click="removeUploadedItem(index)"
                        ></VIcon>
                    </div>
                </div>
            </div>
            <div class="coming-soon mt-4" @dragover.prevent @drop="handleDrop">
                <div
                    class="text-center"
                    v-if="props.data_type == 'user'"
                    @click="handleFileInputClick()"
                >
                    <!-- <div class="mt-2">
                        <span class="import-fade-text">
                            Drag and Drop
                            <span class="text-tiggie-blue text-lowercase px-1"
                                >.csv</span
                            >File here
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="import-fade-text"> or </span>
                    </div>
                    <div class="mt-2">
                        <span class="import-fade-text">
                            Click to browse files
                        </span>
                    </div> -->
                    <p v-if="!file" class="pppangram-normal">
                        Drag & Drop
                        <strong class="colorprimary"></strong> file here
                        <br />
                        or <br />
                        Click to browser files
                    </p>
                </div>

                <div
                    class="text-center"
                    v-if="props.data_type == 'pathway'"
                    @click="handleFileInputClick()"
                >
                    <div class="mt-2">
                        <span class="import-fade-text">
                            Drag and Drop to add
                        </span>
                        <div class="mt-2">
                            <span class="text-tiggie-blue">Books</span> Here
                        </div>
                    </div>
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
