<script setup>
import StorybookVersionCard from "./StorybookVersionCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";
import { onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import { checkPermission } from "@actions/useCheckPermission";

import "swiper/css/pagination";
import "swiper/css";
const modules = [Pagination];
const props = defineProps(["dataStoryBook"]);

// console.log(props.dataStoryBook);
onMounted(() => {});
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Storybook Versions </span>
            <CreateStorybookVersion
                v-if="
                    checkPermission('access_createVersion') &&
                    dataStoryBook.type == 'H5P'
                "
                :dataStoryBook="dataStoryBook"
            />
        </div>
        <div class="body-sec">
            <swiper :slides-per-view="4" :space-between="20">
                <swiper-slide
                    v-for="(item, index) in dataStoryBook.storybook_versions"
                    :key="item.id"
                >
                    <StorybookVersionCard
                        :hide="index === 0 ? true : false"
                        :story_img="dataStoryBook.thumbnail_img"
                        :storybook_versions="item"
                        :storybook_id="dataStoryBook.id"
                        :type="dataStoryBook.type"
                    />
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
