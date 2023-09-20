<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStoryBookSlider.vue";
import AddBook from "./components/AddBook.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

const props = defineProps(["data_type", "storybooks", "pathway"]);
const isFormValid = ref(false);
let refForm = ref();
const isShowBook = ref(false);
const selectedImage = ref(null);
let draggedImageIndex = null;
const uploadedImages = ref([]);
const targetRef = ref(null);
const containerRef = ref(null);
const form = useForm({
    name: "",
    description: "",
    num_gold_coins: "",
    num_silver_coins: "",
    need_complete_in_order: false,
    storybooks: [],
    _method: "PUT",
});
let flash = computed(() => usePage().props.flash);
const handleDrop = (event) => {
    event.preventDefault();
    const selectedFile = event.dataTransfer.files[0];
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};
function startDrag(index, id) {
    // Store the index of the dragged image
    if (!form.storybooks.includes(id)) {
        form.storybooks.push(id);
    }
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
    scrollToTarget();
}

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
    form.storybooks.splice(index, 1);
};
function showBook() {
    isShowBook.value = !isShowBook.value;
}
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
const savePathway = () => {
    SuccessDialog({ title: "You have successfully saved Pathway" });
};
let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("pathways.update", { id: props.pathway.id }), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
                onError: (error) => {},
            });
        }
    });
};
onMounted(() => {
    form.name = props.pathway.name;
    form.description = props.pathway.description;
    form.num_gold_coins = props.pathway.num_gold_coins;
    form.num_silver_coins = props.pathway.num_silver_coins;
    form.need_complete_in_order = props.pathway.need_complete_in_order
        ? true
        : false;
    uploadedImages.value = props.pathway.storybooks.map((storybook) => {
        return {
            file: null,
            src: storybook.thumbnail_img,
            name: storybook.name,
        };
    });
    form.storybooks = props.pathway.storybooks.map((storybook) => storybook.id);
});
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
                    <VCol cols="12">
                        <div class="d-flex justify-space-between align-center">
                            <div>
                                <h1 class="tiggie-title">
                                    Inclusive Learning Stars
                                </h1>
                                <p class="tiggie-p">
                                    Fostering inclusive education and
                                    personalized support
                                </p>
                            </div>
                            <div class="d-flex align-center gap-4">
                                <Link :href="route('pathways.index')">
                                    <VBtn color="gray" width="150">Back</VBtn>
                                </Link>
                                <VBtn type="submit" color="success" width="150"
                                    >Save</VBtn
                                >
                            </div>
                        </div>

                        <h3 class="tiggie-title">Current Flow</h3>
                    </VCol>
                </VRow>
                <VRow>
                    <VCol cols="12" class="pt-0">
                        <div class="scroll-container" ref="containerRef">
                            <div
                                class="ps-relative card-container"
                                v-for="(image, index) in uploadedImages"
                                :key="index"
                                :draggable="true"
                                @dragend="startDrag(index)"
                            >
                                <p
                                    class="font-weight-bold text-right storybook-ps"
                                >
                                    <VIcon
                                        @click="removeUploadedItem(index)"
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
                                        <span class="text-dark">{{
                                            index + 1
                                        }}</span>
                                    </VBtn>
                                </p>
                                <v-card
                                    class="ma-4 ps-index"
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
                                <p class="font-weight-bold text-center">
                                    {{ image.name }}
                                </p>
                            </div>
                            <div
                                class="imprt-path-text mt-4 mx-5"
                                @dragover.prevent
                                @drop="handleDropp"
                            >
                                <div class="text-center">
                                    <div class="mt-2">
                                        <span class="import-fade-text">
                                            Drag and Drop to add
                                        </span>
                                        <div class="mt-2" ref="targetRef">
                                            <span class="text-tiggie-blue"
                                                >Books</span
                                            >
                                            Here
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </VCol>
                    <VCol>
                        <div class="d-flex justify-space-between align-center">
                            <VBtn color="primary" @click="showBook"
                                >Add Books</VBtn
                            >
                            <div class="search-field">
                                <v-text-field
                                    density="compact"
                                    placeholder="Search book"
                                    variant="solo"
                                ></v-text-field>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="12">
                        <div class="scroll-container">
                            <div
                                v-for="(data, index) in props.storybooks"
                                :key="index"
                                :draggable="true"
                                @dragend="startDrag(index, data.id)"
                                class="card-container"
                            >
                                <v-card
                                    class="ma-4 container-style pa-0"
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
