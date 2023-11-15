<script setup>
// import RecommendedGameCard from "./RecommendedGameCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";
import { Swiper, SwiperSlide } from "swiper/vue";

const props = defineProps(["games"]);
// console.log(props.games);
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Recommended Games </span>
        </div>
        <div class="body-sec">
            <swiper :slides-per-view="4" :space-between="20">
                <swiper-slide v-for="item in games.data" :key="item.id">
                    <v-card class="grab-pointer">
                        <v-card-title>
                            <v-img :src="item.thumbnail" />
                        </v-card-title>

                        <v-card-text class="text-center">
                            <div class="text-center">
                                <span
                                    class="text-subtitle-2 font-weight-bold t-black"
                                >
                                    {{ item.name }}
                                </span>
                                <br />
                                <span class="text-subtitle-1 font-weight-bold">
                                    {{ item.description }}
                                </span>
                            </div>
                        </v-card-text>
                    </v-card>
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
}
</style>
