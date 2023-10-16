<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import axios from "axios";

let props = defineProps(["flash", "auth", "pathway"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const active = ref("assigned");
const currentPage = ref(1);
const totalPage = ref("");
const currentPageData = ref([]);

// Function to handle slide change
async function fetchData(page) {
    try {
        const response = await axios.get(
            `/storybooks/student-pathways?page=${page}&pathway_id=${props.pathway.id}`
        );
        // Assuming the API response contains an array of data similar to props.pathways.data
        currentPageData.value = response.data.data;
        totalPage.value = response.data.last_page;
        console.log(currentPageData.value);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

function handleSlideChange(swiper) {
    if (swiper.isEnd) {
        // Increment the current page and fetch the next page of data
        currentPage.value++;
        fetchData(currentPage.value);
    } else if (swiper.isBeginning) {
        // Decrement the current page and fetch the previous page of data
        currentPage.value--;
        fetchData(currentPage.value);
    }
}

onMounted(() => {
    // Load initial data for page 1
    fetchData(currentPage.value);
});
</script>
<template>
    <StudentLayout class="pathway">
        <section class="vh-m-80 pathway-section">
            <VRow>
                <VCol cols="1">
                    <div class="mx-5 mt-4">
                        <img
                            src="/images/back.png"
                            @click="() => router.get(route('storybooks'))"
                            class="backarrow"
                            alt=""
                        />
                    </div>
                </VCol>
                <VCol cols="11" class="text-center">
                    <v-chip class="inclusive-chip ruddy-bold"
                        >Inclusive Learning Stars
                    </v-chip>
                </VCol>
            </VRow>
            <div class="scroll-container">
                <swiper :slides-per-view="1" @slideChange="handleSlideChange">
                    <swiper-slide
                        class="swiper-path"
                        v-for="(page, index) in totalPage"
                        :key="index"
                    >
                        <v-img
                            src="/images/down.png"
                            v-if="currentPage === 1"
                            class="startmap"
                            width="200"
                            height="200"
                        ></v-img>
                        <v-img
                            src="/images/footprint.png"
                            class="footprint1"
                            width="180"
                            height="180"
                        ></v-img>
                        <div class="card1">
                            <VCard class="storybook-story">
                                <v-img
                                    :src="
                                        currentPageData[0].thumbnail_img == ''
                                            ? '/images/toycard.png'
                                            : currentPageData[0].thumbnail_img
                                    "
                                    class="showimg-path"
                                    cover
                                ></v-img>
                                <div class="d-flex justify-center">
                                    <img
                                        @click="
                                            () =>
                                                router.get(
                                                    route(
                                                        'storybooks.show',
                                                        currentPageData[0].id
                                                    )
                                                )
                                        "
                                        src="/images/Play Button.png"
                                        class="playButton"
                                        alt=""
                                    />
                                </div>
                            </VCard>
                        </div>
                        <!-- <v-img :src="currentPageData[0].thumbnail_img == '' ? '/images/toycard.png' : currentPageData[0].thumbnail_img" class="card1" width="300" height="200"></v-img> -->

                        <div class="card2" v-if="currentPageData.length > 1">
                            <VCard class="storybook-story">
                                <v-img
                                    :src="
                                        currentPageData[1].thumbnail_img == ''
                                            ? '/images/toycard.png'
                                            : currentPageData[1].thumbnail_img
                                    "
                                    class="showimg-path"
                                    cover
                                ></v-img>
                                <div class="d-flex justify-center">
                                    <img
                                        @click="
                                            () =>
                                                router.get(
                                                    route(
                                                        'storybooks.show',
                                                        currentPageData[0].id
                                                    )
                                                )
                                        "
                                        src="/images/Play Button.png"
                                        class="playButton"
                                        alt=""
                                    />
                                </div>
                            </VCard>
                        </div>

                        <v-img
                            v-if="currentPageData.length > 1"
                            src="/images/footprint2.png"
                            class="footprint2"
                            width="350"
                            height="210"
                        ></v-img>
                        <!-- <v-img :src="currentPageData[1].thumbnail_img == '' ? '/images/toycard.png' : currentPageData[0].thumbnail_img" class="card2" width="300" height="200"></v-img> -->
                        <v-img
                            v-if="currentPageData.length > 1"
                            src="/images/footprint4.png"
                            class="footprint3"
                            width="330"
                            height="300"
                        ></v-img>
                    </swiper-slide>
                </swiper>
                <!-- <div class="scroll-content">
                    <v-img src="/images/footprint.png" class="footprint1" width="180" height="180"></v-img>
                    <v-img src="/images/toycard.png" class="card1" width="300" height="200"></v-img>
                    <v-img src="/images/footprint2.png" class="footprint2" width="400" height="230"></v-img>
                    <v-img src="/images/toycard.png" class="card2" width="300" height="200"></v-img>
                </div> -->
            </div>

            <div class="d-flex justify-center">
                <div class="progress d-flex justify-center">
                    <span class="progress-text ruddy-bold ml-5 mt-2"
                        >Progress</span
                    >
                    <div class="mt-5">
                        <img
                            src="/images/Progress Bars.png"
                            class="progressimg ml-3"
                            alt=""
                        />
                    </div>
                    <div>
                        <span class="progress-num-text ruddy-bold ml-2">
                            21</span
                        >
                        <img
                            src="/images/chipcoin.png"
                            class="ml-2"
                            width="25"
                            height="25"
                            alt=""
                        />
                        <span class="progress-num-text ruddy-bold ml-5">1</span>
                        <img
                            src="/images/chipcoin2.png"
                            class="mr-5"
                            width="30"
                            height="25"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.pathway .layout-page-content {
    margin: 0 !important;
    padding: 0 !important;
}

// .scroll-container {
//     overflow-x: auto;       /* Enable horizontal scrolling */
//     white-space: nowrap;   /* Prevent content from wrapping */
// }

// .scroll-content {
//     display: inline-block; /* Display children in a row */
//     margin-right: 20px;    /* Add spacing between content */
// }
.swiper-path {
    height: 75vh;
}

.card1 {
    position: absolute !important;
    left: 29% !important;
    top: 43%;
}

.card2 {
    position: absolute !important;
    left: 69% !important;
    top: 12%;
}

.startmap {
    position: absolute !important;
    top: 40%;
}

.footprint1 {
    position: absolute !important;
    left: 15% !important;
    top: 40%;
}

.footprint2 {
    position: absolute !important;
    left: 48% !important;
    top: 26%;
}

.footprint3 {
    position: absolute !important;
    left: 91% !important;
    top: 15.5%;
}

.progress-num-text {
    color: #fff !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize;
}

.progress-text {
    color: var(--white, #fff) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize;
}

.progressimg {
    width: 170px;
}

.progress {
    border-radius: 30px 30px 0px 0px;
    background: var(--primary, #3749e9);
    position: absolute;
    bottom: 0;
}

.storybook-story {
    justify-content: center;
    width: 300px;
    align-items: center;
    height: auto !important;
    border-radius: 30px;
    border: 5px solid var(--white, #fff);
    backdrop-filter: blur(2px);
}

.showimg-path {
    object-fit: cover;
    height: 230px;
}

.playButton {
    position: absolute;
    top: 28%;
    z-index: 1;
}

// .pathway-section{
//     padding: 0;
// }

.inclusive-chip {
    background: #3749e8 !important;
    padding: 20px !important;
    flex-shrink: 0;
    color: var(--white, #fff) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize;
}

.backarrow {
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}

.app-user-search-filter {
    inline-size: 24.0625rem;
}

.overlay-container {
    position: absolute;
    top: 8%;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
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

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
