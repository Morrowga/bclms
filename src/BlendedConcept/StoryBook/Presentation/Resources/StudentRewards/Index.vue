<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";

import DraggableSticker from "./DraggableSticker.vue";
import { ref, defineProps } from "vue";
let props = defineProps(["flash", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const isDrag = ref(false);
const isDragging = (isDragging) => {
    isDrag.value = isDragging;
};
const images = [
    "/images/s5.png",
    "/images/s6.png",
    "/images/s1.png",
    "/images/s2.png",
    "/images/s7.png",
    "/images/s8.png",
    "/images/s4.png",
    "/images/s3.png",
    "/images/s3.png",
];
let isOpen = ref(true);
const toggleBar = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <StudentLayout class="section-bg">
        <div class="storereward">
            <img
                style="width: 214px; height: 234px"
                src="/images/store.gif"
                @click="() => router.get(route('reward-store'))"
                alt=""
            />
        </div>
        <section>
            <!-- <v-navigation-drawer floating permanent class="reward-sidebar"> -->
            <!-- <v-slide-x-transition> -->
            <div v-if="isOpen" class="left-panel reward-sidebar">
                <div class="mt-3" v-for="(image, index) in images" :key="index">
                    <div class="vlis" value="home">
                        <div class="d-flex justify-center mt-1">
                            <DraggableSticker
                                :imageSrc="image"
                                :pox="30"
                                :poy="index * 70"
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

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.section-bg .layout-page-content {
    height: 1000px;
    background: url("/images/rewardbg.png") no-repeat !important;
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
    left: 39.5%;
    top: 11%;
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
.reward-sidebar-drag {
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
</style>
