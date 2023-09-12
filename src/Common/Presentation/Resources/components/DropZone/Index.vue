<script setup>

import { defineProps,ref,defineEmits } from 'vue';

const uploadedImages = ref([]);

const props = defineProps(['data_type'])


let emit = defineEmits("update:modelValue");
const handleDrop = (event) => {
    event.preventDefault();
    const files = event.dataTransfer.files;

    if (files.length > 0) {

      emit("update:modelValue", event.dataTransfer.files[0]);
        for (const file of files) {
            uploadedImages.value.push({
                file: file,
                src: URL.createObjectURL(file),
                name: file.name
            });
        }
    }
};

const removeUploadedItem = (index) => {
    emit("update:modelValue", null);
    uploadedImages.value.splice(index, 1);
}

</script>
<template>
    <VCardText>
        <p class="pppangram-bold ml-5" style="color: #000; font-size: 20px !important;"><strong
                style="color: #4066e4; font-size: 20px !important;">2</strong> {{ type }} Remaining</p>
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
            <div

            :class="props.data_type === 'user' ? 'import-card-text mt-6 mx-5' : 'imprt-path-text mt-6 mx-5'"
             @dragover.prevent @drop="handleDrop">
                <div class="text-center" v-if="props.data_type == 'user'">
                    <div class="mt-2">
                        <span class="import-fade-text">
                            Drag and Drop <span class="text-tiggie-blue text-lowercase px-1">.csv</span>File here
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

                <div class="text-center" v-if="props.data_type == 'pathway'">
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
            <input type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
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
    border: 2px dashed var(--gray, #BFC0C1);
    padding: 10px;
    border-spacing: 4px !important;
    /* Adjust the spacing between dashes */
    justify-content: center;
    align-items: center;
}

.imprt-path-text {
    border-radius: 10px;
    border: 2px dashed var(--gray, #BFC0C1);
    display: flex;
    width: 469px;
    height: 299px;
    padding: 56px 79px;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 17px;
    flex-shrink: 0
}

.image-container {
    background: #F6F6F6;
    border-radius: 15px;
    border: 1px solid var(--line, #E5E5E5);
    padding: 4px;
}

.import-fade-text {
    color: var(--secondary-2, rgba(86, 86, 96, 0.40));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important;
    /* 157.143% */
    text-transform: capitalize !important;
}

.importfile-title {
    color: var(--tiggie-blue, #4066E4);
    font-size: 25px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 42px;
    /* 140% */
    text-transform: capitalize;
}
</style>
