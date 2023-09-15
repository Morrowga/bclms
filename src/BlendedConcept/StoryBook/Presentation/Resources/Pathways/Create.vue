<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
import { SuccessDialog } from "@actions/useSuccess";

import AddBook from "./components/AddBook.vue";
const props = defineProps(["data_type"]);

function showBook() {
    isShowBook.value = !isShowBook.value;
}
let switchBtn = ref("");
const selectedImage = ref(null);
let draggedImageIndex = null;
const uploadedImages = ref([]);

let datas = [
    {
        id: 1,
        image: "/images/image1.png",
        title: "Book 1",
    },
    {
        id: 2,
        image: "/images/image2.png",
        title: "Book 2",
    },
    {
        id: 3,
        image: "/images/image3.png",
        title: "Book 3",
    },
    {
        id: 4,
        image: "/images/image4.png",
        title: "Book 4",
    },
    {
        id: 5,
        image: "/images/image5.png",
        title: "Book 5",
    },
];

const handleDrop = (event) => {
    event.preventDefault();
    const selectedFile = event.dataTransfer.files[0];
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};
const addPathway = () => {
    SuccessDialog({ title: "You have successfully created Pathway" });
};

function startDrag(index) {
    console.log(index);
    // Store the index of the dragged image
    draggedImageIndex = index;
}

function handleDropp(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        for (const file of files) {
            uploadedImages.value.push({
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
        }
    } else {
        const droppedImage = datas[draggedImageIndex];

        // Check if the dropped item is an image card
        if (droppedImage) {
            // Add the dropped image to the uploadedImages array
            uploadedImages.value.push({
                file: "",
                src: "http://bc-lms.test" + droppedImage.image,
                name: droppedImage.title,
            });

            draggedImageIndex = null;
        }
    }
}

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="6">
                    <h1 class="tiggie-title">Add Pathway</h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <Link :href="route('pathways.index')">
                        <VBtn
                            color="secondary"
                            text-color="white"
                            density="compact"
                            variant="tonal"
                            class="pl-16 pr-16"
                            height="30"
                        >
                            <span class="text-dark">Back</span>
                        </VBtn>
                    </Link>
                    <VBtn height="30" class="ml-4" @click="addPathway">
                        Add Pathway
                    </VBtn>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12">
                    <VRow>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Path Name</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Description</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4"> </VCol>

                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Number Of Gold Coins for Completion</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>

                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Number Of Silver Coins for Replay</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Must Complete Books In Order</VLabel
                            >
                            <VSwitch v-model="switchBtn"> </VSwitch>
                        </VCol>
                        <VCol cols="12" sm="6" md="6" class="py-4">
                            <h1 class="tiggie-title required">Current Flow</h1>
                            <VCardText>
                                <p class="pppangram-bold ml-5 fs-20 t-black">
                                    <strong class="fs-20 l-blue">2</strong>
                                    {{ type }} Remaining
                                </p>
                                <div class="mt-3">
                                    <div
                                        class="image-container mt-2 mx-4"
                                        v-for="(image, index) in uploadedImages"
                                        :key="index"
                                    >
                                        <div
                                            class="d-flex justify-space-between"
                                        >
                                            <div class="d-flex">
                                                <img
                                                    :src="image.src"
                                                    class="import-file-img mt-2 ml-3"
                                                />
                                                <p class="ml-3 mt-3">
                                                    {{ image.name }}
                                                </p>
                                            </div>

                                            <div class="mt-3 mr-3">
                                                <VIcon
                                                    icon="mdi-close"
                                                    @click="
                                                        removeUploadedItem(
                                                            index
                                                        )
                                                    "
                                                ></VIcon>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="imprt-path-text mt-6 mx-5"
                                        @dragover.prevent
                                        @drop="handleDropp"
                                    >
                                        <div class="text-center">
                                            <div class="mt-2">
                                                <span class="import-fade-text">
                                                    Drag and Drop to add
                                                </span>
                                                <div class="mt-2">
                                                    <span
                                                        class="text-tiggie-blue"
                                                        >Books</span
                                                    >
                                                    Here
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </VCardText>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" class="pt-0">
                    <div class="d-flex justify-space-between align-center">
                        <h1 class="tiggie-title required">Book Library</h1>
                        <div class="search-field">
                            <v-text-field
                                variant="solo"
                                placeholder="Search Books"
                                density="compact"
                            >
                            </v-text-field>
                        </div>
                    </div>
                    <div class="control-position">
                        <div class="head-section">
                            <div class="title-section">
                                <p class="heading-title">{{ title }}</p>
                                <span class="subheading">{{ subtitle }}</span>
                            </div>
                        </div>
                        <div class="scroll-container">
                            <div
                                v-for="(data, index) in datas"
                                :key="index"
                                :draggable="true"
                                @dragstart="startDrag(index)"
                                class="card-container"
                            >
                                <v-card
                                    class="ma-4 container-style"
                                    height="200"
                                    :color="'primary'"
                                >
                                    <div
                                        class="d-flex fill-height align-center justify-center"
                                    >
                                        <img
                                            class="bg-white fit-img-2"
                                            :src="data.image"
                                        />
                                    </div>
                                    <v-scale-transition class="full-icon">
                                        <!-- <v-icon
                                                size="48"
                                                icon="mdi-check-circle-outline"
                                            ></v-icon> -->
                                    </v-scale-transition>
                                </v-card>
                                <p class="font-weight-bold text-center">
                                    {{ data.title }}
                                </p>
                            </div>
                        </div>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.custom-progress {
    width: 70%;
}

.import-card-text {
    display: flex !important;
    width: 469px !important;
    height: 299px !important;
    padding: 56px 79px !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 17px !important;
    flex-shrink: 0 !important;
}

.control-position {
    position: relative;
}

.v-slide-group__next {
    cursor: pointer;
    position: absolute;
    top: 10px !important;
    right: -38px;
    height: 100%;
}

.v-slide-group__prev {
    cursor: pointer;
    position: absolute;
    top: 10px !important;
    left: -24px;
    height: 100%;
    z-index: 1;
}
.scroll-container {
    overflow-x: scroll;
    white-space: nowrap;
    display: flex;
    flex-wrap: nowrap;
    padding: 10px; /* Add padding for spacing */
}
.card-container {
    min-width: 380px; /* Adjust card width as needed */
    margin-right: 10px; /* Adjust spacing between cards as needed */
}

.fit-img-2 {
    object-fit: cover;
    width: 120%;
    height: 120%;
    /* height: 100%; */
}

.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.heading-title {
    margin: 0;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
    padding-left: 9px !important;
}

.head-button {
    align-self: flex-end;
}

.full-icon {
    position: absolute;
    left: 50%;
    right: 0;
    bottom: 0;
    top: 50%;
    transform: translate(-50%, -50%);
}

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
.container-style {
    position: relative !important;
    z-index: 1 !important;
}
</style>
