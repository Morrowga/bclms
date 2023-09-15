<script setup>
import RecommendedGameCard from "./RecommendedGameCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Recommended Games </span>
        </div>
        <div class="body-sec">
            <div
                class="d-flex justify-start justify-md-center align-center gap-10 f-wrap"
            >
                <div v-for="item in 3" :key="item" class="width-290">
                    <RecommendedGameCard />
                </div>
            </div>
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
