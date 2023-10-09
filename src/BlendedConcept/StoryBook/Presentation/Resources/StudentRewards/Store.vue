<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
let props = defineProps(["flash", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
</script>

<template>
    <StudentLayout>
        <section class="mb-3">
            <VRow>
                <VCol cols="1">
                    <img
                        src="/images/back.png"
                        @click="() => router.get(route('student-rewards'))"
                        class="backarrow ml-2"
                        alt=""
                    />
                </VCol>
                <VCol cols="10">
                    <div class="d-flex justify-center">
                        <img
                            src="/images/reward.png"
                            alt=""
                            class="reward-img"
                        />
                        <div class="b1">
                            <div class="mt-12 mr-16">
                                <img
                                    src="/images/b1.png"
                                    @click="() => router.get(route('be-lucky'))"
                                    alt=""
                                />
                            </div>
                            <div class="mt-15 mr-16">
                                <img
                                    src="/images/b2.png"
                                    @click="
                                        () => router.get(route('buy-sticker'))
                                    "
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                </VCol>
            </VRow>
        </section>
    </StudentLayout>
</template>

<style lang="scss" scope>
.app-user-search-filter {
    inline-size: 24.0625rem;
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }

.b1 {
    position: absolute;
    right: 15%;
    top: 20%;
}

.b1 > div > img {
    height: 20vh;
    cursor: pointer;
}

.backarrow {
    cursor: pointer !important;
    width: 40px !important;
    height: 40px !important;
}

.reward-img {
    height: 85vh;
    width: 100%;
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

.textcolor {
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
