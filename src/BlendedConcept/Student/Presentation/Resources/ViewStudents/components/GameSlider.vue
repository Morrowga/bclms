<script setup>
import { ref, defineProps } from "vue";
import GameSliderCard from "./GameSliderCard.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import "swiper/css/pagination";
import "swiper/css";
let model = ref(false);
const modules = [Pagination];

const props = defineProps(["datas", "student_id"]);
</script>
<template>
    <div class="body-sec">
        <swiper
            :slides-per-view="4"
            :space-between="10"
            :modules="modules"
            class="h-100"
            :pagination="true"
        >
            <swiper-slide v-for="data in props.datas" :key="data.id">
                <GameSliderCard :data="data.game" :student_id="student_id" />
            </swiper-slide>
        </swiper>
    </div>
</template>

<style>
.body-sec {
    height: 400px;
}
.control-position {
    position: relative;
}
.control-position .v-slide-group__next {
    cursor: pointer;
    position: absolute;
    top: 40px;
    right: -38px;
    height: 100%;
}
.control-position .v-slide-group__prev {
    cursor: pointer;
    position: absolute;
    top: 40px;
    left: -24px;
    height: 100%;
    z-index: 1;
}
.fit-img {
    object-fit: cover;
    width: 300px;
    height: auto;
    /* height: 100%; */
}

.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    align-self: flex-end;
}
.card-container {
    max-width: 275px !important;
}
</style>
