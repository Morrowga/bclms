<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps,onBeforeUnmount } from "vue";
import GameOver from "@mainRoot/components/Games/GameOver.vue";
import FullScreenComponent from "@Layouts/Dashboard/FullScreenComponent.vue";
import JSZip from "jszip";
import GameEndUserExperienceSurvey from "./components/GameEndUserExperienceSurvey.vue";

let props = defineProps(["flash", "auth", "game", "user_survey"]);

console.log(props.game);

let openDialog = ref(false);
const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

console.log(app_url.value + '/gamefiles/' + props.game.game_file)

let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown);

  handleOrientationChange();

  window.addEventListener("resize", handleOrientationChange);
});

// Remove event listeners when the component is unmounted
onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeyDown);
});

const handleKeyDown = (event) => {
    const iframe = document.getElementById('gameiframe'); // Assuming you have an iframe with id 'gameIframe'
    iframe.contentWindow.postMessage({ type: 'keydown', keyCode: event.keyCode }, '*');
};

const handleOrientationChange = () => {
    if (isPortrait()) {
        openDialog.value = true;
    } else {
        openDialog.value = false;
    }
};

const isPortrait = () => {
    return window.innerHeight > window.innerWidth;
};

onUnmounted(() => {
    window.removeEventListener("resize", handleOrientationChange);
});
</script>

<template>
        <FullScreenComponent
            @close_orientation="openDialog = false"
            :openDialog="openDialog"
        />
        <section class="section-bg">
            <!-- <div class="fixed-back-icon">
                <img
                    src="/images/Back.png"
                    @click="() => router.get(route('student-games'))"
                    class="backarrow"
                    alt=""
                />
            </div> -->
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
</template>

<style lang="scss" scoped>
.fixed-back-icon {
    position: absolute;
    top: 5vh;
    left: 2vh;
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

.section-bg{
    background: url("/images/studentbg.webp") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
    position: relative; /* Ensure the section is positioned relative to its containing block */
    width: 100%; /* Set the width to 100% of the viewport */
    height: 100vh; /* Set the height to 100% of the viewport height */
    overflow: hidden; /* Hide overflow to prevent scrolling */

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
