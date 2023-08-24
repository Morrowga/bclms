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
            <div class="">
                <img src="/images/back.png" @click="() => router.get(route('storybooks'))" class="backarrow" alt="">
            </div>
            <div class="d-flex justify-center">
                <img src="/images/toy.png" class="videoplayer" alt="">
            </div>
        </section>
    </StudentLayout>
</template>

<style  lang="scss">

.backarrow{
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }
.videoplayer{
    height: 600px;
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
