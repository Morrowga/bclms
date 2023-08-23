<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps,ref } from "vue";
let props = defineProps([
    "flash",
    "auth",
]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const active = ref('assigned');

const activeTab = (name) => {
  active.value  = name
};
</script>
<template>
    <StudentLayout>
        <section>
            <v-navigation-drawer
                floating
                permanent
                class="story-sidebar"
            >
            <div @click="activeTab('assigned')" :class="{'inside-div': active === 'assigned'}" class="mt-5">
                <div  class="vlis" value="home">
                    <div class="d-flex justify-center mt-1">
                        <img src="/images/bookicon.png" class="icon-sidebar" alt="">
                    </div>
                    <p class="text-center sidebartext pppangram-medium">Assigned</p>
                </div>
            </div>
            <div @click="activeTab('pathway')" :class="{'inside-div': active === 'pathway'}" class="mt-5">
                <div  class="vlis" value="home">
                    <div class="d-flex justify-center mt-1">
                        <img src="/images/pathicon.png" class="icon-sidebar" alt="">
                    </div>
                    <p class="text-center sidebartext pppangram-medium">Path Way</p>
                </div>
            </div>
            <div @click="activeTab('playlist')" :class="{'inside-div': active === 'playlist'}" class="mt-5">
                <div  class="vlis" value="home">
                    <div class="d-flex justify-center mt-1">
                        <img src="/images/play-square.png" class="icon-sidebar" alt="">
                    </div>
                    <p class="text-center sidebartext pppangram-medium">Playlist</p>
                </div>
            </div>
            </v-navigation-drawer>
            <VContainer v-if="active === 'assigned'">
                <VRow>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/21.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname  ruddy-bold">It's Ok to Lose</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/3.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Jack And The Beanstalk</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/sample2.png" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Denver The River</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/1.webp" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">I Am Able To Shine</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/2.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">"Ohana Means Family</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/storybook.png" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">A Walk On The Thundra</span>
                        </div>
                    </VCol>
                </VRow>
            </VContainer>
            <VContainer v-if="active === 'pathway'">
                <div class="d-flex justify-center">
                    <img src="images/Pathway Card.png" class="pathwayimg" alt="">
                </div>
            </VContainer>
            <VContainer v-if="active === 'playlist'">
                <div class="text-center d-flex justify-center">
                    <div class="title-chip"><span class="title-chip-text  ruddy-bold">Self-Love (3 Books)</span></div>
                </div>
                <VRow class="mt-5">
                     <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/21.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">It's Ok To Lose</span>
                        </div>
                     </VCol>
                     <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/3.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Jack And The Beanstalk</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/sample2.png" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Denver The River</span>
                        </div>
                    </VCol>
                </VRow>
                <div class="text-center d-flex justify-center mt-5">
                    <div class="title-chip"><span class="title-chip-text ruddy-bold">Bravery (2 Books)</span></div>
                </div>
                <VRow class="mt-5">
                     <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/21.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">It's Ok To Lose</span>
                        </div>
                     </VCol>
                     <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/3.jpg" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Jack And The Beanstalk</span>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="4">
                        <VCard class="card-story">
                            <v-img src="/images/sample2.png" class="showimg" cover></v-img>
                            <div class="d-flex justify-center">
                                <img src="/images/Play Button.png" class="playButton" alt="">
                            </div>
                            <div class="d-flex justify-center">
                                <div class="goldCoin">
                                    <v-chip class="coinChip text-center">
                                        <div class="mt-2 text-center">
                                            <span class="chipText">1</span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <img src="/images/Gold Coin.png" width="30" height="30" alt="">
                                        </div>
                                    </v-chip>
                                </div>
                            </div>
                        </VCard>
                        <div class="text-center mt-3">
                            <span class="bookname ruddy-bold">Denver The River</span>
                        </div>
                    </VCol>
                </VRow>
            </VContainer>
        </section>
    </StudentLayout>
</template>

<style  lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.sidebartext{
    font-size: 10px !important;
    line-height: 1.5 !important;
    font-weight: bold;
    color: #000;
}

.title-chip{
    display: flex;
    padding: 0px 38px 0px 37px;
    height: 50px;
    border-radius: 30px;
    background: var(--sun-yellow, #FC0);
}

.title-chip-text{
    color: var(--graphite, #282828);
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 123.333% */
    text-transform: capitalize !important;
}

.pathwayimg{
    height: 80vh;
}

.bookname{
    color: var(--white, #FFF) !important;
    // font-family: Ruddy;
    font-size: 25px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.inside-div{
    // margin-top: 20px;
    margin-left: 0px;
    width: 78px;
    height: 75px;
    flex-shrink: 0;
    border-top-right-radius: 17px !important;
    border-bottom-right-radius: 17px !important;
    border-right: 3px solid var(--white, #FFF);
    border-top: 3px solid var(--white, #FFF);
    border-bottom: 3px solid var(--white, #FFF);
    background: var(--sun-yellow, #FC0);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
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

.showimg{
    object-fit: cover;
    height: 230px;
}

.playButton{
    position: absolute;
    top: 28%;
    z-index: 1;
}

.icon-sidebar{
    width: 45px;
    height: 45px;
}

.story-sidebar{
    width: 90px !important;
    height: 285px !important;
    margin-top: 15% !important;
    border-top: 4px solid #fff;
    border-bottom: 4px solid #fff;
    border-right: 4px solid #fff;
    border-top-right-radius: 17px;
    border-bottom-right-radius: 17px;
    background: #FF8015 !important;
}

.story-vlist {
    border-radius: 20px;
    background: #FF8015 !important;
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
