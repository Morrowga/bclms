<script setup>
import { ref, defineProps } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";

let model = ref(false);
import PlaylistCard from "./PlaylistCard.vue";
const props = defineProps({
    datas: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <swiper :slides-per-view="4" :space-between="20">
        <swiper-slide v-for="data in props.datas" :key="data">
            <PlaylistCard :data="data" />
        </swiper-slide>
    </swiper>
</template>

<style>
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
