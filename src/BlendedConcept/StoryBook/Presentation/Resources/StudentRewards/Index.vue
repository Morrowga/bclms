<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { Swiper, SwiperSlide } from "swiper/vue";
import DraggableSticker from "./DraggableSticker.vue";
import { ref, defineProps } from "vue";
let props = defineProps(["flash", "auth", "stickers"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const isDrag = ref(false);
const isDragging = (isDragging) => {
    isDrag.value = isDragging;
};
let isOpen = ref(true);
const toggleBar = () => {
    isOpen.value = !isOpen.value;
};
const getXPosition = (sticker) => {
    return sticker.students[0]?.pivot.x_axis_position
        ? sticker.students[0]?.pivot.x_axis_position
        : 13;
};

const getYPosition = (sticker, index) => {
    return sticker.students[0]?.pivot.y_axis_position
        ? sticker.students[0]?.pivot.y_axis_position
        : index * 80;
};
</script>

<template>
    <StudentLayout class="section-bg">
        <div class="storereward">
            <img
                class="store-reward-img"
                src="/images/store.gif"
                @click="() => router.get(route('reward-store'))"
                alt=""
            />
        </div>
        <section>
            <!-- <v-navigation-drawer floating permanent class="reward-sidebar"> -->
            <!-- <v-slide-x-transition> -->
            <div>
                <div v-if="isOpen" class="left-panel reward-sidebar"></div>
                <div class="sticker-bar">
                    <div class="scrollable">
                        <div
                            class="vlist"
                            value="home"
                            v-for="(sticker, index) in stickers"
                            :key="sticker.id"
                        >
                            <div
                                class="d-flex justify-center mt-1"
                                v-if="getXPosition(sticker) < 100"
                            >
                                <DraggableSticker
                                    :hidden="
                                        isOpen == false &&
                                        getXPosition(sticker) < 100
                                    "
                                    :data="sticker"
                                    :imageSrc="sticker.file_src"
                                    :pox="getXPosition(sticker)"
                                    :poy="getYPosition(sticker, index)"
                                    class="icon-reward-sidebar"
                                    @isDragging="isDragging"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                        class="vlist-2"
                        value="home"
                        v-for="(sticker, index) in stickers"
                        :key="sticker.id"
                    >
                        <div
                            class="d-flex justify-center mt-1"
                            v-if="getXPosition(sticker) > 100"
                        >
                            <DraggableSticker
                                :hidden="
                                    isOpen == false &&
                                    getXPosition(sticker) < 100
                                "
                                :data="sticker"
                                :imageSrc="sticker.file_src"
                                :pox="getXPosition(sticker)"
                                :poy="getYPosition(sticker, index)"
                                class="icon-reward-sidebar"
                                @isDragging="isDragging"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- </v-slide-x-transition> -->
            <!-- </v-navigation-drawer> -->
            <div :class="isOpen ? 'dragsticker' : 'close-dragsticker'">
                <img src="/images/stickerdrag.png" @click="toggleBar()" />
            </div>
        </section>
    </StudentLayout>
</template>

<style lang="scss" scope>
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.section-bg .layout-page-content {
    height: 1000px;
    background: url("/images/rewardbg2.png") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
}

.dragsticker {
    position: absolute;
    top: 35%;
    left: 6.8%;
    cursor: pointer;
}
.close-dragsticker {
    position: absolute;
    top: 35%;
    left: -1.2%;
    cursor: pointer;
}
.storereward {
    cursor: pointer;
    position: absolute;
    left: 39.8%;
    top: 12.7%;
    z-index: 2;
}

.overlay-container {
    //   z-index: 1;
    position: absolute;
    top: 8%;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reward-sidebar::-webkit-scrollbar {
    width: 1px !important; /* Width of the scroll bar */
}

.reward-sidebar {
    // overflow-x: hidden !important;
    // overflow-y: scroll !important;
    margin-top: 3%;
    margin-bottom: 3%;
    height: 630px !important;
    width: 130px !important;
    border-top: 4px solid #fff;
    border-bottom: 4px solid #fff;
    border-right: 4px solid #fff;
    border-top-right-radius: 17px;
    border-bottom-right-radius: 17px;
    background: var(--gray, #bfc0c1);
}

.rewardsidebartext {
    font-size: 10px !important;
    line-height: 1.5 !important;
    font-weight: bold;
    color: #000;
}

.icon-reward-sidebar {
    height: 60px !important;
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

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.left-panel {
    position: absolute;
    left: 0;
    top: 100px;
    bottom: 0;
    z-index: 1;
}
.store-reward-img {
    width: 214px;
    height: 234px;
}

.sticker-bar {
    margin-top: 5% !important;
    position: relative !important;
    height: 600px !important;
}

.scrollable {
    position: relative;
    height: 100%;

    overflow-y: scroll;
}

/* Hiding scrollbar for Chrome, Safari and Opera */
.scrollable::-webkit-scrollbar {
    display: none;
}

/* Hiding scrollbar for IE, Edge and Firefox */
.scrollable {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}
</style>
