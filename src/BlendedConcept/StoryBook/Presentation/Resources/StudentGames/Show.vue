<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import GameOver from "@mainRoot/components/Games/GameOver.vue";

let props = defineProps([
    "flash",
    "auth",
]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
</script>

<template>
    <StudentLayout>
        <section class="mb-6">
            <div class="ml-2">
                <img src="/images/back.png" @click="() => router.get(route('student-games'))" class="backarrow" alt="">
            </div>
            <GameOver iframeSrc="https://games.cdn.famobi.com/html5games/o/om-nom-run/v1240/?fg_domain=play.famobi.com&fg_aid=A1000-111&fg_uid=abe80572-560a-444d-baf7-2fa4a7b2c02f&fg_pid=e37ab3ce-88cd-4438-9b9c-a37df5d33736&fg_beat=298&original_ref=https%3A%2F%2Fplay.famobi.com%2Fom-nom-run" />
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.videoplayer{
    cursor: pointer;
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
