<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
let props = defineProps([
    "flash",
    "auth",
]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
</script>

<template>
    <StudentLayout>
        <section>
            <VContainer>
                <VRow>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook1.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Om Nom Rush</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook2.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Tower Crash 3D</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook1.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Endless Truck</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook2.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Color Strings</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook1.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Find Me</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook2.jpeg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" @click="() => router.get(route('games.show'))" class="playButton" alt="">
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Pendguin Rush</span>
                        </div>
                    </VCol>
                </VRow>
            </VContainer>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }

.bookname{
    color: var(--white, #FFF) !important;
    // font-family: Ruddy;
    font-size: 25px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.showimg{
    object-fit: cover;
    height: 230px;
}

.coinChip{
    border-radius: 30px !important;
    display: inline-flex !important;
    height: 30px !important;
    padding: 20px !important;
    align-items: center !important;
    flex-shrink: 0 !important;
    background: var(--candy-red, #FF6262);
}

.chipText{
    color: #FFF !important;
    // font-family: Ruddy;
    font-size: 25px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.playButton{
    position: absolute;
    top: 28%;
    z-index: 1;
}

.goldCoin{
    position: absolute;
    top: 0;
    margin: 10px;
    right: 0;
    letter-spacing: 15px;
    z-index: 1;
}

.card-story{
    justify-content: center;
    align-items: center;
    height: auto !important;
    border-radius: 30px;
    border: 5px solid var(--white, #FFF);
    backdrop-filter: blur(2px);
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


.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.textcolor{
    color: #fff;
}

.classname{
    color: #000;
    font-size: 36px;
    font-style: normal;
    font-weight: bold;
    text-transform: capitalize;
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
