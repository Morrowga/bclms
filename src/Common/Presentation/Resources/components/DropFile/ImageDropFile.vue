<script setup>
import { ref, defineProps, defineEmits } from "vue";
const emit = defineEmits();

const file = ref(null);
const thumbnail = ref(null);
const dragging = ref(false);
const old_image = ref("");
let memeName = ref("");
const props = defineProps({
    modelValue: {
        default: null,
    },
    memeType: {
        type: String,
        default: "",
    },
    id: {
        type: Number,
        default: 1,
    },
    old_photo: {
        type: String,
        default: "",
    },
});

const checkMemeType = (selectedFile) => {
    if (props.memeType == "image") {
        return (
            selectedFile &&
            (selectedFile.type === "image/jpeg" ||
                selectedFile.type === "image/png")
        );
    } else if (props.memeType == "video") {
        return selectedFile && selectedFile.type === "video/mp4";
    } else if (props.memeType == "zip") {
        return (
            selectedFile &&
            (selectedFile.type == "application/zip" ||
                selectedFile.type == "application/x-zip-compressed")
        );
    } else {
        return true;
    }
};

const handleFileChange = (event) => {
    const selectedFile = event.target.files[0];
    var parent = event.target.closest(".drop-zone");
    if (selectedFile) {
        thumbnail.value = URL.createObjectURL(selectedFile);
    }

    if (checkMemeType(selectedFile)) {
        file.value = selectedFile;
        emit("update:modelValue", file.value);
    } else {
        alert(`Please select a valid ${memeName.value} file.`);
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
        thumbnail.value = URL.createObjectURL(selectedFile);
    }
    if (checkMemeType(selectedFile)) {
        file.value = selectedFile;
        emit("update:modelValue", file.value);
    } else {
        alert(`Please select a valid ${memeName.value} file.`);
    }
};

const handleFileInputClick = () => {
    const fileInput = document.getElementById(`game-file-input${props.id}`);
    fileInput.click();
};

onMounted(() => {
    if (props.memeType == "image") {
        memeName.value = "PNG / JPEG";
    } else if (props.memeType == "video") {
        memeName.value = "MP4";
    } else if (props.memeType == "zip") {
        memeName.value = "ZIP";
    } else {
        memeName.value = "";
    }

    if (props.old_photo) {
        old_image.value = props.old_photo;
    }
});
</script>
<template>
    <div
        class="coming-soon mt-4"
        :class="`drop-zone${id}`"
        @dragover.prevent
        @dragenter.prevent
        @dragleave="dragging = false"
        @drop.prevent="onDropGameFile"
    >
        <p
            v-if="!file && !old_image"
            class="pppangram-normal"
            @click="handleFileInputClick"
        >
            Drag & Drop
            <strong class="colorprimary">{{ memeName }}</strong> file here
            <br />
            or <br />
            Click to browser files
        </p>
        <div v-else-if="old_image">
            <v-img :src="old_image" alt="Thumbnail" cover width="200" />
            <button type="button" @click="() => (old_image = '')">
                Remove
            </button>
        </div>
        <div v-else>
            <v-img
                v-if="memeType == 'image'"
                width="200"
                :src="thumbnail"
                alt="Thumbnail"
                cover
            />
            <p v-else>File Name: {{ file.name }}</p>
            <button type="button" @click="removeGameFile" class="remove-button">
                Remove
            </button>
        </div>
        <input
            :id="`game-file-input${id}`"
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
