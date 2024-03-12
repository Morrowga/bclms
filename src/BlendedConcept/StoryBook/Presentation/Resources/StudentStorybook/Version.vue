<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref, onBeforeUnmount } from "vue";
import { onMounted, nextTick } from "vue";
import axios from "axios";
import BookEndUserExperienceSurvey from "./components/BookEndUserExperienceSurvey.vue";

let props = defineProps(["book", "user_survey", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
let iframeRef = ref(null);
let htmliframeRef = ref(null);
const active = ref("assigned");

const activeTab = (name) => {
    active.value = name;
};
console.log(props.book)
const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

const parseCookie = (cookieString) => {
  const cookies = {};
  cookieString.split(';').forEach(cookie => {
    const [key, value] = cookie.trim().split('=');
    try {
      cookies[key] = decodeURIComponent(value);
    } catch (error) {
      console.error(`Error decoding value for cookie '${key}':`, error);
      console.log("Value:", value);
    }
  });
  return cookies;
};


const postData = async (postData) => {
  try {
    const response = await axios.post('book-score', postData);

    console.log('Response:', response.data);
  } catch (error) {
    console.error('Error:', error.message);
  }
};

const setCookieInIframe = (cookieName, cookieValue, cookiePath) => {
    // Get the iframe element
    const iframe = document.getElementById('html5-frame');

    // Construct the cookie string
    const cookieString = `${cookieName}=${encodeURIComponent(cookieValue)}; path=${cookiePath}`;

    // Access the contentDocument of the iframe
    const iframeDocument = iframe.contentDocument;

    // Set the cookie inside the iframe document
    iframeDocument.cookie = cookieString;
}


onMounted(() => {
    if (htmliframeRef.value) {
        htmliframeRef.value.contentWindow.focus();
    }

    if(props.book.storybook.type == 'HTML5'){
        let path =  '/book_html5/' + props.book.html5_file.replace(/\/index\.html$/, '');
        let iframeSrc = app_url.value + '/book_html5/' + props.book.html5_file
        setCookieInIframe('gameURL', iframeSrc, path);
    } else {
        iframeRef.value.style.display = "none";

    iframeRef.value.addEventListener("load", (event) => {
        iframeRef.value.style.display = "flex";
        let iframe = iframeRef.value.contentWindow.document;
        let innerIframe = iframe.querySelector(
            "#app .container .h5p-content-wrap .h5p-iframe-wrapper iframe"
        );

        let innerFrameConent = innerIframe.contentWindow.document.querySelector(
            ".h5p-content .h5p-video-wrapper"
        );

        let innerFrameContentActions =
            innerIframe.contentWindow.document.querySelector(
                ".h5p-content .h5p-actions"
            );
        innerFrameContentActions.style.display = "none";

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
    }


});


const handleBeforeUnmount = () => {
  const leavePage = window.confirm('Are you sure you want to leave this page?');

  if (!leavePage) {
    throw new Error('User canceled leaving the page');
  } else {
    const iframeDocument = document.getElementById('html5-frame').contentDocument;
    const cookies = parseCookie(iframeDocument.cookie);
    const Totaltime = parseFloat(cookies.Totaltime);
    // const Percentage_correct = parseFloat(cookies.Percentage_correct);
    const TotalSelection = parseInt(cookies.TotalSelection);
    const scoreData = {
        student_id:  props.auth.data.student.student_id,
        id:  props.book.id,
        duration: Totaltime,
        accuracy: 99,
        score: TotalSelection
    };

    postData(scoreData);
  }
};


onBeforeUnmount(() => {
    handleBeforeUnmount()
});
</script>
<template>
        <section>
            <!-- <div class="fixed-back-icon">
                <img
                    src="/images/Back.png"
                    @click="() => router.get(route('storybooks'))"
                    class="backarrow"
                    alt=""
                />
            </div> -->
            <div class="d-flex justify-center">
                <iframe
                    v-if="props.book.storybook.type == 'H5P'"
                    :src="`${app_url}/admin/h5p/h5p/${props.book.h5p_id}`"
                    frameborder="0"
                    class="h5p-book-width"
                    ref="iframeRef"
                    id="myIframe"
                ></iframe>
                <iframe
                    v-else
                    :src="`${app_url}/book_html5/${props.book.html5_file}`"
                    frameborder="0"
                    class="html5-width"
                    ref="htmliframeRef"
                    id="html5-frame"
                ></iframe>
            </div>
        </section>
        <BookEndUserExperienceSurvey
            v-if="props.user_survey ?? false"
            :data="props.user_survey"
        />
</template>

<style lang="scss">
.fixed-back-icon {
    position: absolute;
    top: 100px;
    left: 30px;
}

.backarrow {
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}

.h5p-book-width {
    display: block !important;
    background: black;
    width: 100%;
    min-height: 105vh !important;
}

.html5-width {
    display: block;
    overflow: hidden;
    width: 100%;
    min-height: calc(100vh - 0px);
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }
.videoplayer {
    width: 100%;
    height: 120vh;
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
