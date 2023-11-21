<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
import { onMounted, nextTick } from "vue";

let props = defineProps(["book"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
let iframeRef = ref("");
const active = ref("assigned");

const activeTab = (name) => {
    active.value = name;
};
const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);
onMounted(() => {
    iframeRef.value.style.display = "none";

    iframeRef.value.addEventListener("load", (event) => {
        iframeRef.value.style.display = "flex";
        let iframe = iframeRef.value.contentWindow.document;
        let innerIframe = iframe.querySelector(
            "#app .container-fluid .h5p-content-wrap .h5p-iframe-wrapper iframe"
        );
        let innerFrameConent = innerIframe.contentWindow.document.querySelector(
            ".h5p-content .h5p-video-wrapper"
        );

        let h5pControls = innerIframe.contentWindow.document.querySelector(
            ".h5p-content .h5p-controls"
        );
        let fullScreenButton = h5pControls.querySelector(
            ".h5p-control.h5p-fullscreen"
        );

        let video = innerFrameConent.querySelector("video");
        let fullscreenClicked = false;

        document.addEventListener("keydown", (event) => {
            if (
                (event.key === " " || event.key === "Enter") &&
                !fullscreenClicked
            ) {
                fullScreenButton.click();
                let playButton = h5pControls.querySelector(".h5p-play");
                if (playButton) {
                    playButton.click();
                }
                fullscreenClicked = true;
            }
        });
        video.addEventListener("pause", () => {
            let h5pIcon = innerFrameConent.querySelector(
                ".h5p-interaction-button"
            );
            let h5pIconButton = innerFrameConent.querySelector(
                ".h5p-dragnbar-element"
            );
            h5pIcon.style.display = "none";
            let h5pLabel = h5pIconButton.querySelector(
                ".h5p-interaction-label"
            );

            h5pLabel.style.borderTopLeftRadius = "1em";
            h5pLabel.style.borderBottomLeftRadius = "1em";

            document.addEventListener("keydown", (event) => {
                if (event.key === " " || event.key === "Enter") {
                    h5pIcon.click();
                }
            });

            let h5pDialog = innerIframe.contentWindow.document.querySelector(
                ".h5p-content .h5p-dialog-wrapper"
            );
            let checkButtonClicked = false;
            h5pDialog.addEventListener("keydown", (event) => {
                let checkButton = h5pDialog.querySelector(
                    ".h5p-question-check-answer"
                );
                let continueButton = h5pDialog.querySelector(
                    ".h5p-question-iv-continue"
                );
                if (event.key === " " || event.key === "Enter") {
                    if (checkButton && !checkButtonClicked) {
                        checkButton.click();
                        checkButtonClicked = true;
                    } else if (continueButton && checkButtonClicked) {
                        continueButton.click();
                        checkButtonClicked = false;
                    }
                }
            });
        });
    });
});
</script>
<template>
    <StudentLayout>
        <section>
            <div class="fixed-back-icon">
                <img
                    src="/images/back.png"
                    @click="() => router.get(route('storybooks'))"
                    class="backarrow"
                    alt=""
                />
            </div>
            <div class="d-flex justify-center">
                <iframe
                    v-if="props.book.storybook.type == 'H5P'"
                    :src="`${app_url}/admin/h5p/h5p/${props.book.h5p_id}`"
                    frameborder="0"
                    class="h5p-width"
                    ref="iframeRef"
                    id="myIframe"
                ></iframe>
                <iframe
                    v-else
                    :src="`${app_url}/book_html5/${props.book.html5_file}`"
                    frameborder="0"
                    class="html5-width"
                    ref="iframeRef"
                    id="myIframe"
                ></iframe>
            </div>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.fixed-back-icon {
    position: absolute;
    top: 100px;
    left: 30px;
}
.book_view {
    // min-height: calc(100vh - 100px);
}
.backarrow {
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}
.h5p-width {
    padding: 50px 0;
    width: 75%;
    height: 840px;
}
.html5-width {
    display: block;
    width: 100%;
    min-height: calc(100vh - 55px);
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }
.videoplayer {
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
