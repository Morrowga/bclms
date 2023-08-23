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
                                <div class="b3 mt-15">
                                    <VRow>
                                        <VCol cols="5" class="text-left">
                                           <div class="d-flex justify-center">
                                                <div>
                                                    <div class="text-center">
                                                    <span class="adtext">Get It Today!</span>
                                                    </div>
                                                    <div class="d-flex justify-center">
                                                        <img class="poster" src="/images/tiger.png">
                                                    </div>
                                                    <div class="mt-3 text-center">
                                                        <span class="rewardimagetext">
                                                            Super Rare
                                                            <br>
                                                            WarriorTiggie
                                                        </span>
                                                    </div>
                                                </div>
                                           </div>
                                        </VCol>
                                        <VCol cols="7" class="text-left">
                                            <div>
                                                <div class="mt-15 text-center">
                                                    <img src="/images/posterbg.png" class="posterbg" alt="">
                                                </div>
                                                <VRow class="mt-8">
                                                    <VCol cols="6" class="text-center">
                                                        <v-btn variant="flat" color="#282828" width="200" height="100" class="rollbtn">Roll Once</v-btn>
                                                        <div class="text-center">
                                                            <span class="rolltext">Spend <strong>1 Gold Coin</strong></span>
                                                        </div>
                                                    </VCol>
                                                    <VCol cols="6" class="text-center">
                                                        <v-btn variant="flat" color="#282828" width="200" height="100" class="rollbtn mx-3">Roll 10 Times</v-btn>
                                                        <div class="text-center">
                                                            <span class="rolltext">Spend <strong>1 Gold Coin</strong></span>
                                                        </div>
                                                    </VCol>
                                                </VRow>
                                            </div>
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

.b3{
    position: absolute;
    top: 10% !important;
    z-index: 1;
    width: 100%;
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
