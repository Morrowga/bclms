<script setup>
import { ref, defineProps, defineEmits } from "vue";
const { emit } = defineEmits();

const file = ref(null);
const dragging = ref(false);
const props = defineProps({
    modelValue: {
        default: null,
    },
});

const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        file.value = selectedFile;
        emit("update:modelValue", file.value);
    } else {
        alert("Please select a valid JPG or PNG file.");
    }
};

const removeGameFile = () => {
    file.value = null;
    emit("update:modelValue", null);
};

const onDropGameFile = (event) => {
    event.preventDefault();
    dragging.value = false;
    const files = event.dataTransfer.files;
    const selectedFile = files[0];
    if (selectedFile) {
        file.value = selectedFile;
        emit("update:modelValue", file.value);
    } else {
        alert("Please select a valid JPG or PNG file.");
    }
};

const handleFileInputClick = () => {
    const fileInput = document.getElementById("game-file-input");
    fileInput.click();
};
</script>
<template>
    <div
        class="drop-zone coming-soon mt-4"
        @dragover.prevent
        @dragenter.prevent
        @dragleave="dragging = false"
        @drop.prevent="onDropGameFile"
    >
        <p v-if="!file" class="pppangram-normal" @click="handleFileInputClick">
            Drag & Drop
            <strong class="colorprimary">JPG/PNG</strong> file here
            <br />
            or <br />
            Click to browser files
        </p>
        <div v-else>
            <p>File Name: {{ file.name }}</p>
            <button @click="removeGameFile" class="remove-button">
                Remove
            </button>
        </div>
        <input
            id="game-file-input"
            type="file"
            style="display: none"
            @change="handleFileChange"
        />
    </div>
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

.submit-btn-color {
    background: #4066e4 !important;
    color: #fff !important;
}
.colorprimary {
    color: #4066e4 !important;
}
</style>
