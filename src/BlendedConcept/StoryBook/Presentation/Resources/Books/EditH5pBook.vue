<script setup>
import { defineProps, ref } from "vue";
import { SuccessDialog } from "@actions/useSuccess";
import { router } from "@inertiajs/core";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps(["book"]);
let iframeRef = ref("");
const toggleDialog = () => {
    dialog.value = !dialog.value;
};

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);
let isLoading = ref(false);
//this arrary describe as multiple select for each roles

const removeFromArray = (index) => {
    form.tags = form.tags.filter((tag, i) => i != index);
};
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
}
const backHome = () => {
    router.get(route("books.index"));
};
const saveToH5p = () => {
    const saveButton =
        iframeRef.value.contentWindow.document.getElementById("save-button");
    saveButton.click();
};
let onFormSubmit = () => {
    saveToH5p();
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 10000);
};
onMounted(() => {
    iframeRef.value.style.display = "none";
    iframeRef.value.addEventListener("load", () => {
        iframeRef.value.style.display = "flex";
        const cancelButton =
            iframeRef.value.contentWindow.document.querySelector(
                "#laravel-h5p-form > div > div > div > a"
            );

        const saveButton =
            iframeRef.value.contentWindow.document.getElementById(
                "save-button"
            );
        if (cancelButton && saveButton) {
            cancelButton.style.display = "none";
            saveButton.style.display = "none";
        } else {
            console.error("Buttons not found!");
        }
    });
});
</script>
<template>
    <AdminLayout>
        <VContainer class="book-create-container">
            <p class="heading">Edit Book Content</p>

            <VRow>
                <VCol cols="12" md="12">
                    <VLabel class="tiggie-label">Story Book Content</VLabel>

                    <iframe
                        :src="`${app_url}/admin/h5p/h5p/${props.book.h5p_id}/edit`"
                        frameborder="0"
                        scrolling="auto"
                        class="h5p-width"
                        ref="iframeRef"
                    ></iframe>
                </VCol>
                <VCol cols="12" md="12">
                    <div class="d-flex justify-center aligns-center w-100">
                        <div>
                            <VBtn
                                color="gray"
                                height="50"
                                class=""
                                width="200"
                                @click="backHome()"
                                :disabled="isLoading"
                                :loading="isLoading"
                            >
                                Cancel
                            </VBtn>

                            <VBtn
                                type="submit"
                                class="ml-10"
                                height="50"
                                width="200"
                                @click="onFormSubmit"
                                :disabled="isLoading"
                                :loading="isLoading"
                            >
                                Add
                            </VBtn>
                        </div>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}
.book-create-container {
    width: 75%;
}
.h5p-width {
    width: 100%;
    height: 1500px;
}
.faded-image {
    position: relative;
    display: inline-block;
    width: 100%;
}

.faded-image img {
    display: block;
    height: 270px;
    width: 100%;
    object-fit: fill;
    position: relative;
}

.faded-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%; /* Adjust this value to control the height of the fading effect */
    background: linear-gradient(
        to bottom,
        transparent,
        white
    ); /* Adjust the colors as needed */
}

.book-title {
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 40px;
}
.book-title span {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
}

.close-btn {
    position: absolute;
    top: 0;

    right: 0;
}
.v-btn--icon {
    border-radius: 10px;
    scale: 0.7;
}
.chip-1 {
    background: rgba(255, 166, 0, 0.464);
    color: #fff !important;
}
.chip-2 {
    background: rgba(217, 23, 13, 0.464);
    color: #fff !important;
}
.chip-3 {
    background: rgba(72, 255, 0, 0.464);
    color: #fff !important;
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
.coming-soon p {
    margin-bottom: 0;
}

:deep(.game-tag-add .v-field__append-inner svg) {
    width: 30px;
    height: 30px;
}

:deep(.game-name-input .v-input__details) {
    margin-top: 10px !important;
}

:deep(.disability-type-input .v-input__details) {
    margin-top: 10px !important;
}
.delete-chip {
    background: rgb(109, 120, 141);
    border-radius: 50%;
    width: 15px;
    height: 15px;
    color: #fff;
    text-align: center;
    position: absolute;
    right: -4px;
    top: -5px;
    cursor: pointer;
}
.delete-chip span {
    position: absolute;
    top: -6px;
    left: 0;
    bottom: 0;
    right: 0;
    color: #fff;
}
</style>
