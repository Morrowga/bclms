<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import axios from "axios";

let props = defineProps(["flash", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const active = ref("assigned");
const currentPage = ref(0);
const totalPage = ref("");
const currentPageData = ref([]);
const datas = ref([]);
// Function to handle slide change
async function fetchData() {
    try {
        const response = await axios.get(
            `/storybooks/student-pathways?pathway_id=${props.pathway.id}`
        );
        // Assuming the API response contains an array of data similar to props.pathways.data
        datas.value = response.data.data;
        totalPage.value = response.data.total;
        let results = datas.value[0].map((book, index) => {
            return {
                id: book.id,
                thumbnail_img: book.thumbnail_img,
                own_progress: calculatePercentageByCount(
                    book.pathways?.[0]?.pivot?.sequence,
                    response.data.total
                ),
            };
        });
        currentPageData.value = results;
        totalBook.value = response.data.total;
        // currentPageData.value = results;
        // if (totalPage.value == "") {
        //     totalPage.value = response.data.last_page + 1;
        // }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

function handleSlideChange(swiper) {
    currentPage.value = swiper.activeIndex;
    let results = datas.value[swiper.activeIndex].map((book, index) => {
        return {
            id: book.id,
            thumbnail_img: book.thumbnail_img,
            own_progress: calculatePercentageByCount(
                book.pathways?.[0]?.pivot?.sequence,
                totalPage.value
            ),
        };
    });
    currentPageData.value = results;
}

function calculatePercentageByCount(specificCount, totalCount) {
    if (totalCount === 0) {
        return 0; // To avoid division by zero error
    }

    return (specificCount / totalCount) * 100;
}

function calculateCountFromPercentage(percent, totalCount) {
    return Math.round((percent / 100) * totalCount);
}
const bookType = (book_progress) => {
    let pathway_progress = progress.value;
    let current_count = calculateCountFromPercentage(
        book_progress,
        totalBook.value
    );
    let prev_count = current_count - 1;

    let previous_progress = calculatePercentageByCount(
        prev_count,
        totalBook.value
    );
    if (pathway_progress) {
        if (book_progress <= pathway_progress) {
            return "complete";
        } else if (
            previous_progress > pathway_progress &&
            book_progress > pathway_progress
        ) {
            return "lock";
        } else {
            return "unlock";
        }
    } else {
        let first_progress = calculatePercentageByCount(1, totalBook.value);

        if (book_progress > first_progress) {
            return "lock";
        }
        return "unlock";
    }
};
const setCookie = (value) => {
    var cookieName = "current_pathway_book";
    var cookieValue = value;
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 1);
    var expires = "expires=" + expirationDate.toUTCString();

    var cookieString =
        cookieName + "=" + cookieValue + ";" + expires + ";path=/";

    document.cookie = cookieString;
};
const readPathwayBook = (book) => {
    let value = bookType(book.own_progress);
    if (value == "lock") {
        return;
    }
    setCookie(value);
    router.get(route("storybooks.show", book.id));
};
const changePhoto = (book) => {
    let type = bookType(book.own_progress);
    if (type == "lock") {
        return "/images/lock.png";
    } else {
        return "/images/Play Button.png";
    }
};

const dynamicClass = (book_progress) => {
    let value = bookType(book_progress);
    if (value == "lock") {
        return "storybook-story-lock";
    } else {
        return "storybook-story";
    }
};
const swiperOptions = {
    slidesPerView: 1,
    on: {
        slideChange: function () {
            handleSlideChange(this);
        },
    },
    // Other Swiper configuration options
};
const printCons = (index) => {
    console.log(index);
};
onMounted(() => {
    // Load initial data for page 1
    fetchData();
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
                <swiper :slide-per-view="1" @slideChange="handleSlideChange">
                    <swiper-slide
                        class="swiper-path"
                        v-for="(page, index) in totalPage"
                        :key="index"
                    >
                        <v-img
                            src="/images/down.png"
                            v-if="currentPage === 0"
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
                            :class="
                                currentPageData.length > 1
                                    ? 'currentfp' + index
                                    : 'currentfp' + index + ' d-none'
                            "
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
.d-none {
    display: none;
}
</style>
