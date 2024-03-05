<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps,onBeforeUnmount } from "vue";
import GameOver from "@mainRoot/components/Games/GameOver.vue";
import JSZip from "jszip";
import GameEndUserExperienceSurvey from "./components/GameEndUserExperienceSurvey.vue";

let props = defineProps(["flash", "auth", "game", "user_survey"]);

console.log(props.game);

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

console.log(app_url.value + '/gamefiles/' + props.game.game_file)

let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);


</script>

<template>
    <StudentLayout>
        <section>
            <div class="fixed-back-icon">
                <img
                    src="/images/Back.png"
                    @click="() => router.get(route('student-games'))"
                    class="backarrow"
                    alt=""
                />
            </div>
            <GameOver
                :iframeSrc="app_url + '/gamefiles/' + props.game.game_file"
                :game="props.game"
                :auth="props.auth"
            />
            <GameEndUserExperienceSurvey
                v-if="props.user_survey ?? false"
                :data="props.user_survey"
            />
        </section>
    </StudentLayout>
</template>

<style lang="scss" scoped>
.fixed-back-icon {
    position: absolute;
    top: 20px;
    left: 13px;
}
.app-user-search-filter {
    inline-size: 24.0625rem;
}

:deep(.layout-navbar-and-nav-container > .layout-navbar) {
    display: none !important;
}

:deep(.layout-navbar-and-nav-container > .std-head-bar) {
    display: none !important;
}

.videoplayer {
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
