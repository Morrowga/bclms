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
    <StudentLayout class="pathway">
        <section class="pathway-section">
            <VRow>
                <VCol cols="1">
                    <div class="">
                        <img src="/images/back.png" @click="() => router.get(route('storybooks'))" class="backarrow" alt="">
                    </div>
                </VCol>
                <VCol cols="11" class="text-center">
                    <v-chip class="inclusive-chip ruddy-bold">Inclusive Learning Stars </v-chip>
                </VCol>
            </VRow>
        </section>
        <v-img src="/images/path.png" cover></v-img>

        <div class="d-flex justify-center">
            <div class="progress d-flex justify-center">
                <span class="progress-text ruddy-bold ml-5 mt-2">Progress</span>
                <div class="mt-5">
                    <img src="/images/Progress Bars.png" class="progressimg ml-3" alt="">
                </div>
                <div>
                    <span class="progress-num-text ruddy-bold ml-2"> 21</span>
                    <img src="/images/chipcoin.png" class="ml-2" width="25" height="25" alt="">
                    <span class="progress-num-text ruddy-bold ml-5">1</span>
                    <img src="/images/chipcoin2.png" class="mr-5" width="30" height="25" alt="">
                </div>
            </div>
        </div>
    </StudentLayout>
</template>

<style  lang="scss">
.pathway .layout-page-content{
    margin: 0 !important;
    padding: 0 !important;
}

.progress-num-text{
    color: #FFF !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize;
}

.progress-text{
    color: var(--white, #FFF) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize ;
}

.progressimg{
    width: 170px;
}

.progress{
    // padding: 5px;
    border-radius: 30px 30px 0px 0px;
    background: var(--primary, #3749E9);
    position: absolute;
    bottom: 0;
}

.pathway-section{
    padding: 20px;
}

.inclusive-chip{
    background: #3749e8 !important;
    padding: 20px !important;
    flex-shrink: 0;
    color: var(--white, #FFF) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize;
}

.backarrow{
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}

.app-user-search-filter {
    inline-size: 24.0625rem;
}

.overlay-container {
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
