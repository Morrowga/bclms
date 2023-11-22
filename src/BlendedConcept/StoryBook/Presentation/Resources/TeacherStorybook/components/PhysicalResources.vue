<script setup>
import PhysicalResourcesCard from "./PhysicalResourcesCard.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import "swiper/css/pagination";
import "swiper/css";
import { ref } from "vue";

let model = ref(false);
const modules = [Pagination];
const props = defineProps(["physical_resources"]);
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Physical Resources </span>
        </div>
        <div class="body-sec">
            <swiper
                :modules="modules"
                :slides-per-view="3"
                :space-between="20"
                class="h-100"
                :pagination="true"
            >
                <swiper-slide
                    v-for="(data, key) in props.physical_resources"
                    :key="key"
                >
                    <PhysicalResourcesCard :data="data" />
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>
<style scoped>
.header-sec {
    width: 100%;
    gap: 20px;
}
.header-sec span {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.body-sec {
    padding-top: 40px;
    height: 450px;
}
</style>
