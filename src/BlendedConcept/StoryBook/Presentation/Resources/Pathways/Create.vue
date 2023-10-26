<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { requiredValidator } from "@validators";
import AddBook from "./components/AddBook.vue";
import ImageDropFile from "@mainRoot/components/DropFile/ImageDropFile.vue";

const props = defineProps(["data_type", "storybooks"]);
let flash = computed(() => usePage().props.flash);
const isFormValid = ref(false);
let refForm = ref();
function showBook() {
    isShowBook.value = !isShowBook.value;
}
let switchBtn = ref("");
const selectedImage = ref(null);
let draggedImageIndex = null;
const uploadedImages = ref([]);
const targetRef = ref(null);
const containerRef = ref(null);
// let datas = [
//     {
//         id: 1,
//         image: "/images/image1.png",
//         title: "Book 1",
//     },
//     {
//         id: 2,
//         image: "/images/image2.png",
//         title: "Book 2",
//     },
//     {
//         id: 3,
//         image: "/images/image3.png",
//         title: "Book 3",
//     },
//     {
//         id: 4,
//         image: "/images/image4.png",
//         title: "Book 4",
//     },
//     {
//         id: 5,
//         image: "/images/image5.png",
//         title: "Book 5",
//     },
// ];

const handleDrop = (event) => {
    event.preventDefault();
    const selectedFile = event.dataTransfer.files[0];
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};
const addPathway = () => {
    FlashMessage({ flash });
};

async function startDrag(index, id) {
    // Store the index of the dragged image
    if (!form.storybooks.includes(id)) {
        form.storybooks.push(id);
        draggedImageIndex = index;
    }
}

async function handleDropp(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    let book = props.storybooks[draggedImageIndex];
    if (files.length > 0) {
        for (const file of files) {
            uploadedImages.value.push({
                id: book.id,
                file: file,
                src: URL.createObjectURL(file),
                name: book.name,
            });
        }
        uploadedImages.value = uploadedImages.value.filter(
            (image, index, self) =>
                index === self.findIndex((t) => t.id === image.id)
        );
    } else {
        const droppedImage = props.storybooks[draggedImageIndex];

        // Check if the dropped item is an image card
        if (droppedImage) {
            // Add the dropped image to the uploadedImages array
            uploadedImages.value.push({
                id: droppedImage.id,
                file: "",
                src: "",
                name: droppedImage.name,
            });

            draggedImageIndex = null;
        }
    }
    scrollToTarget();
}

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
    form.storybooks.splice(index, 1);
};

const form = useForm({
    name: "",
    description: "",
    num_gold_coins: "",
    num_silver_coins: "",
    need_complete_in_order: false,
    storybooks: [],
    image: null,
});
const scrollToTarget = () => {
    const container = containerRef.value;
    const target = targetRef.value;

    const containerRect = container.getBoundingClientRect();
    const targetRect = target.getBoundingClientRect();

    container.scrollTo({
        left: targetRect.left - containerRect.left,
        behavior: "smooth",
    });
};
let search = ref("");
let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("pathways.store"), {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
                onError: (error) => {},
            });
        }
    });
};

const storybooks = (datas) => {
    let searchTerm = search.value.toLowerCase();

    return datas.filter((data) => {
        return data.name.toLowerCase().includes(searchTerm);
    });
};
</script>
<template>
    <AdminLayout>
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
        >
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
                                variant="tonal"
                                class="pl-16 pr-16"
                            >
                                Back
                            </VBtn>
                        </Link>
                        <VBtn class="ml-4" type="submit"> Add Pathway </VBtn>
                    </VCol>
                </VRow>

                <VRow>
                    <VCol cols="6">
                        <VLabel class="tiggie-label required"
                            >Thumbnail Picture</VLabel
                        >
                        <ImageDropFile
                            v-model="form.image"
                            memeType="image"
                            :id="3"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VRow>
                            <VCol cols="12" sm="6" md="4">
                                <VLabel class="tiggie-label required"
                                    >Path Name</VLabel
                                >
                                <VTextField
                                    placeholder="Type here ..."
                                    density="compact"
                                    v-model="form.name"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.name"
                                />
                            </VCol>
                            <VCol cols="12" sm="6" md="4">
                                <VLabel class="tiggie-label required"
                                    >Description</VLabel
                                >
                                <VTextField
                                    placeholder="Type here ..."
                                    density="compact"
                                    v-model="form.description"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.description"
                                />
                            </VCol>
                            <VCol cols="12" sm="6" md="4"> </VCol>

                            <VCol cols="12" sm="6" md="4">
                                <VLabel class="tiggie-label required"
                                    >Number Of Gold Coins</VLabel
                                >
                                <VTextField
                                    placeholder="Type here ..."
                                    density="compact"
                                    type="number"
                                    v-model="form.num_gold_coins"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.num_gold_coins
                                    "
                                />
                            </VCol>

                            <VCol cols="12" sm="6" md="4">
                                <VLabel class="tiggie-label required"
                                    >Number Of Silver Coins</VLabel
                                >
                                <VTextField
                                    placeholder="Type here ..."
                                    density="compact"
                                    type="number"
                                    v-model="form.num_silver_coins"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.num_silver_coins
                                    "
                                />
                            </VCol>
                            <VCol cols="12" sm="6" md="4">
                                <VLabel class="tiggie-label required"
                                    >Must Complete Books In Order</VLabel
                                >
                                <VSwitch v-model="form.need_complete_in_order">
                                </VSwitch>
                            </VCol>
                            <VCol cols="12" sm="6" md="12" class="py-4">
                                <h1 class="tiggie-title required">
                                    Current Flow
                                </h1>
                                <VCardText class="pa-0">
                                    <div class="mt-3">
                                        <div
                                            class="scroll-container"
                                            ref="containerRef"
                                        >
                                            <div
                                                class="ps-relative card-container"
                                                v-for="(
                                                    image, index
                                                ) in uploadedImages"
                                                :key="index"
                                            >
                                                <p
                                                    class="font-weight-bold text-right storybook-ps"
                                                >
                                                    <VIcon
                                                        @click="
                                                            removeUploadedItem(
                                                                index
                                                            )
                                                        "
                                                        icon="mdi-minus-circle"
                                                        size="20"
                                                        color="#282828"
                                                        class="mb-2 ml-2"
                                                    />
                                                </p>

                                                <p
                                                    class="font-weight-bold text-right text-white storybook-ps-2"
                                                >
                                                    <VBtn
                                                        color="#fff"
                                                        icon="dd"
                                                        size="x-small"
                                                        class="black-border"
                                                    >
                                                        <span
                                                            class="text-dark"
                                                            >{{
                                                                index + 1
                                                            }}</span
                                                        >
                                                    </VBtn>
                                                </p>
                                                <v-card
                                                    class="ma-0 pa-0 mb-2 ps-index"
                                                    height="200"
                                                    :color="'primary'"
                                                >
                                                    <div
                                                        class="d-flex fill-height align-center justify-center"
                                                    >
                                                        <img
                                                            class="bg-white fit-img-2"
                                                            :src="image.src"
                                                        />
                                                    </div>
                                                </v-card>
                                                <p
                                                    class="font-weight-bold text-center"
                                                >
                                                    {{ image.name }}
                                                </p>
                                            </div>
                                            <div
                                                class="imprt-path-text mr-5"
                                                @dragover.prevent
                                                @drop="handleDropp"
                                            >
                                                <div class="text-center">
                                                    <div class="mt-2">
                                                        <span
                                                            class="import-fade-text"
                                                        >
                                                            Drag and Drop to add
                                                        </span>
                                                        <div
                                                            class="mt-2"
                                                            ref="targetRef"
                                                        >
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
                                    v-model="search"
                                >
                                </v-text-field>
                            </div>
                        </div>
                        <div class="control-position">
                            <div class="head-section">
                                <div class="title-section"></div>
                            </div>
                            <div class="scroll-container">
                                <div
                                    v-for="(data, index) in storybooks(
                                        props.storybooks
                                    )"
                                    :key="index"
                                    :draggable="true"
                                    @dragstart="startDrag(index, data.id)"
                                    class="card-container"
                                >
                                    <v-card
                                        class="container-style pa-0 ma-0 mb-2"
                                        height="200"
                                        :color="'primary'"
                                    >
                                        <div
                                            class="d-flex fill-height align-center justify-center"
                                        >
                                            <img
                                                class="bg-white fit-img-2"
                                                :src="data.thumbnail_img"
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
                                        {{ data.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VContainer>
        </VForm>
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
    width: 100%;
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
    width: 390px;
    height: 200px;
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
.storybook-ps {
    position: absolute !important;
    top: 7px !important;
    right: 7px !important;
    z-index: 3 !important;
}
.storybook-ps-2 {
    position: absolute !important;
    top: 24px !important;
    left: 21px !important;
    z-index: 3 !important;
}
</style>
