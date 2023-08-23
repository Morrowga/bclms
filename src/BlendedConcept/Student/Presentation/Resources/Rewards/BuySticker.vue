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
            <VRow>
                <VCol cols="1">
                    <img src="/images/back.png" @click="() => router.get(route('student-rewards'))" class="backarrow" alt="">
                </VCol>
                <VCol cols="11">
                    <div class="d-flex justify-center">
                        <div class="postercard">
                            <img src="/images/blankpage.png" alt="" class="reward-img">
                            <!-- <div class="d-flex justify-center"> -->
                                <div class="b4">
                                    <VRow>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stickerb1.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick6.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick4.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick1.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick3.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick5.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                        <VCol cols="3" class="text-center">
                                            <VCard class="stickercard text-center">
                                                <v-img src="/images/stick7.png" class="stickimg" cover></v-img>
                                                <div>
                                                    <span class="stickertext ruddy-bold">SecretAgent Tiggie</span>
                                                </div>
                                                <div>
                                                    <v-chip class="sticker-chip text-left">
                                                        <img src="/images/chipcoin.png" class="">
                                                        <span class="sticker-chip-text ruddy-bold"> 10</span>
                                                        <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                                                        <img src="/images/chipcoin2.png">
                                                        <span class="sticker-chip-text ruddy-bold">1</span>
                                                    </v-chip>
                                                </div>
                                            </VCard>
                                        </VCol>
                                    </VRow>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </VCol>
            </VRow>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.sticker-chip-or-text{
    color: var(--candy-red, #FF6262) !important;
    font-size: 25px !important;
    font-style: normal !important;
    text-transform: capitalize !important;
}

.sticker-chip-text{
    padding: 0 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.stickercard{
    padding: 15px;
    border-radius: 15px;
    border: 5px solid var(--black, #000);
    background: rgba(40, 40, 40, 0.50);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.stickertext{
    color: var(--white, #FFF) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}

.sticker-chip{
    padding-right: 20px !important;
    padding-top: 25px !important;
    padding-bottom: 25px !important;
    border-radius: 30px;
    color: #fff;
    background: #000;
    gap: 6px;
}

.postercard{
    position: relative;
}

.rolltext{
    color: #000 !important;
    font-size: 20px !important;
    text-transform: capitalize !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
}

.rolltext > strong {
    color: #FF6262 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    text-transform: capitalize !important;
}

.stickimg{
    height: 180px !important;
    object-fit: cover !important;
}

.rewardimagetext{
    color: var(--graphite, #282828) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.rollbtn{
    border-radius: 23px !important;
    color: #fff;
}

.posterbg{
    height: 15vh;
}

.adtext{
    color: #F80808 !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 104% */
    text-transform: capitalize !important;
}

.b4{
    position: absolute;
    top: 10% !important;
    z-index: 1;
    width: 100%;
    overflow: auto !important;
    padding: 20px;
    height: 588px;
    // top: 20%
}

.poster {
    height: 35vh;
}

.backarrow{
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}

.reward-img{
    position: relative;
    height: 85vh;
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

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
