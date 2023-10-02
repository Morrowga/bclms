<script setup>
import { defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    isThumbnailDialogVisible: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    thumb: null,
});

const emit = defineEmits(["submit", "update:isThumbnailDialogVisible"]);

const thumbnail = ref(null);
const thumbnailFile = ref(null);
const dragging = ref(false);

const handleThumbnailChange = (event) => {
    const file = event.target.files[0];
    thumbnailFile.value = file;
    thumbnail.value = URL.createObjectURL(file);
};

const removeThumbnail = () => {
    thumbnail.value = null;
    thumbnailFile.value = null;
};

const onDropThumbnail = (event) => {
    event.preventDefault();
    dragging.value = false;
    const files = event.dataTransfer.files;
    thumbnail.value = URL.createObjectURL(files[0]);
    thumbnailFile.value = files[0];
};

const onFormSubmit = () => {
    form.thumb = thumbnailFile.value;
    emit("submit", form);
    emit("update:isThumbnailDialogVisible", false);
};

const onFormReset = () => {
    emit("update:isThumbnailDialogVisible", false);
};

const dialogVisibleUpdate = (val) => {
    emit("update:isThumbnailDialogVisible", val);
};

const handleFileInputClick = () => {
    const fileInput = document.getElementById("thumbnail-file-input");
    fileInput.click();
};
</script>

<template>
    <VDialog
        :model-value="props.isThumbnailDialogVisible"
        @update:model-value="dialogVisibleUpdate"
        width="500"
    >
        <!-- Dialog Content -->
        <div>
            <VCard>
                <VForm ref="refForm" @submit.prevent="onFormSubmit">
                    <VCardText>
                        <p class="heading-upload-modal">
                            Upload Book Thumbnail
                        </p>

                        <!-- <span class="warning-text pppangram-normal">Warnings: This will override the existing game thumbnail image!</span> -->

                        <div
                            class="drop-zone coming-soon mt-3"
                            @dragover.prevent
                            @dragenter.prevent
                            @dragleave="dragging = false"
                            @drop.prevent="onDropThumbnail"
                        >
                            <p
                                v-if="!thumbnail"
                                class="pppangram-normal"
                                @click="handleFileInputClick"
                            >
                                Drag & Drop
                                <strong class="colorprimary">.png/.jpg</strong>
                                file here <br />
                                or <br />
                                Click to browser files
                            </p>
                            <div v-else>
                                <v-img :src="thumbnail" alt="Thumbnail" cover />
                                <button
                                    @click="removeThumbnail"
                                    class="remove-button"
                                >
                                    Remove
                                </button>
                            </div>
                            <input
                                id="thumbnail-file-input"
                                type="file"
                                style="display: none"
                                @change="handleThumbnailChange"
                                :error-messages="form?.errors?.thumbnail"
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
        </div>
    </VDialog>
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
