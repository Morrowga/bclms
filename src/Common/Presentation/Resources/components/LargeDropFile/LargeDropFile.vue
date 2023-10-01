<script setup>
import { ref, defineProps, defineEmits } from "vue";
const selectedImage = ref(null);
const profile = ref(null);
const dragging = ref(false);
const emit = defineEmits();

const props = defineProps({
    modelValue: {
        default: null,
    },
    old_photo: {
        default: "",
    },
});
const handleThumbnailChange = (event) => {
    const file = event.target.files[0];
    emit("update:modelValue", file);
    profile.value = URL.createObjectURL(file);
};

const onDropThumbnail = (event) => {
    event.preventDefault();
    dragging.value = false;
    const files = event.dataTransfer.files;
    profile.value = URL.createObjectURL(files[0]);
    emit("update:modelValue", files[0]);
};

const handleFileInputClick = () => {
    const fileInput = document.getElementById("file-input");
    fileInput.click();
};
const removeFile = () => {
    profile.value = null;
    emit("update:modelValue", null);
};
onMounted(() => {
    profile.value = props.old_photo;
});
</script>
<template>
    <div
        class="profile-drag"
        :class="!profile ? 'd-flex justify-center' : ''"
        @dragover.prevent
        @dragenter.prevent
        @dragleave="dragging = false"
        @drop.prevent="onDropThumbnail"
    >
        <div v-if="!profile" @click="handleFileInputClick">
            <div class="d-flex justify-center text-center">
                <v-img
                    src="/images/Icons.png"
                    width="80"
                    height="80"
                    aspect-ratio="16/9"
                ></v-img>
            </div>
            <p class="pppangram-bold mt-5">Drag your item to upload</p>
            <p class="mt-2 blur-p">
                PNG, GIF, WebP, MP4 or MP3. Maximum file size 100 Mb.
            </p>
        </div>
        <div v-else class="img-frame">
            <v-img :src="profile" class="profileimg" aspect-ratio="1" />
            <v-btn
                class="remove-img"
                icon="mdi-clear"
                size="x-small"
                color="secondary"
                @click="removeFile"
            ></v-btn>
        </div>
        <input
            id="file-input"
            type="file"
            style="display: none"
            @change="handleThumbnailChange"
        />
    </div>
</template>
<style lang="scss" scoped>
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.card-text {
    padding: 145px 80px;
    justify-content: center;
    align-items: center;
}

.fade-text {
    color: var(--secondary-2, rgba(86, 86, 96, 0.4));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important; /* 157.143% */
    text-transform: capitalize !important;
}

.cancel {
    border-radius: 23px !important;
    background: rgba(55, 73, 233, 0.1) !important;
    color: #3749e9 !important;
}

.input-label {
    color: var(--gray, #bfc0c1);
    /* Body Style Small */
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}

.star {
    color: var(--candy-red, #ff6262);
}

.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 32px !important; /* 160% */
}

.drag-text {
    color: var(--secondary, #565660);
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 24px !important; /* 150% */
}

.upload-card {
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.cloud {
    text-align: center;
}

.span-text {
    color: #000 !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.textcolor {
    color: #fff;
}

.classname {
    color: #000;
    font-size: 36px;
    font-style: normal;
    font-weight: bold;
    text-transform: capitalize;
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.blur-p {
    color: var(--Secondary2, rgba(86, 86, 96, 0.4));
    text-align: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px; /* 157.143% */
    text-transform: capitalize;
}

.profile-drag {
    align-items: center;
    text-align: center;
    width: 100%;
    background: #f7f7f7;
    height: 440px;
    border: 1px solid black;
    border-radius: 10px;
}
.profileimg {
    object-fit: contain !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
    margin-bottom: 0;
}
.img-frame {
    position: relative;
}

.remove-img {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
