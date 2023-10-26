<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStoryBookSlider.vue";
import AddBook from "./components/AddBook.vue";
import { router } from "@inertiajs/core";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";

const props = defineProps(["data_type", "pathway"]);

let flash = computed(() => usePage().props.flash);
let search = ref("");
const uploadedImages = ref([]);
const deletePathway = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            router.delete(route("pathways.destroy", id), {
                onSuccess: () => {
                    FlashMessage({ flash })
                },
            });
        },
    });
};
onMounted(() => {
    uploadedImages.value = props.pathway.storybooks.map((storybook) => {
        return {
            file: null,
            src: storybook.thumbnail_img,
            name: storybook.name,
        };
    });
});
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <div class="d-flex justify-space-between align-center">
                        <div>
                            <h1 class="tiggie-title">
                                Inclusive Learning Stars
                            </h1>
                            <p class="tiggie-p">
                                Fostering inclusive education and personalized
                                support
                            </p>
                        </div>
                        <div class="d-flex align-center gap-4">
                            <Link :href="route('pathways.index')">
                                <VBtn color="gray" width="150">Back</VBtn>
                            </Link>
                            <Link
                                :href="route('pathways.edit', props.pathway.id)"
                            >
                                <VBtn color="success" width="150">Edit</VBtn>
                            </Link>
                            <VBtn
                                color="candy-red"
                                width="150"
                                @click="deletePathway(props.pathway.id)"
                                >Delete</VBtn
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
                        >
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
                            <p class="font-weight-bold text-center">
                                {{ image.name }}
                            </p>
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
