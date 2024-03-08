<script setup>
import { router } from "@inertiajs/core";
import { computed, defineProps,onBeforeUnmount } from "vue";
import axios from "axios";

let props = defineProps(["route", "count", "iframeSrc","game", "auth"]);

const isDialogVisible = ref(false);
const myIframe = ref(null);

console.log(props.iframeSrc);

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
    const response = await axios.post('game-score', postData);

    console.log('Response:', response.data);
  } catch (error) {
    console.error('Error:', error.message);
  }
};

const setCookieInIframe = (cookieName, cookieValue, cookiePath) => {
    // Get the iframe element
    const iframe = document.getElementById('gameiframe');

    // Construct the cookie string
    const cookieString = `${cookieName}=${encodeURIComponent(cookieValue)}; path=${cookiePath}`;

    // Access the contentDocument of the iframe
    const iframeDocument = iframe.contentDocument;

    // Set the cookie inside the iframe document
    iframeDocument.cookie = cookieString;
}

onMounted(() => {
    let path =  '/gamefiles/' + props.game.game_file.replace(/\/index\.html$/, '');

    setCookieInIframe('gameURL', props.iframeSrc, path);

    if (myIframe.value) {
        myIframe.value.contentWindow.focus();
    }

});

const handleBeforeUnmount = () => {
  const leavePage = window.confirm('Are you sure you want to leave this page?');

  if (!leavePage) {
    throw new Error('User canceled leaving the page');
  } else {
    const iframeDocument = document.getElementById('gameiframe').contentDocument;
    const cookies = parseCookie(iframeDocument.cookie);
    const Totaltime = parseFloat(cookies.Totaltime);
    const Percentage_correct = parseFloat(cookies.Percentage_correct);
    const TotalSelection = parseInt(cookies.TotalSelection);
    const scoreData = {
        student_id:  props.auth.data.student.student_id,
        game_id:  props.game.id,
        duration: Totaltime,
        accuracy: Percentage_correct,
        score: TotalSelection
    };

    postData(scoreData);
  }
};


onBeforeUnmount(() => {
    handleBeforeUnmount()
});
</script>
<template #activator="{ props }">
    <div>
        <div class="d-flex justify-center">
            <iframe
                ref="myIframe"
                id="gameiframe"
                class="html5-width"
                :src="iframeSrc"
                frameborder="0"
                allowfullscreen
                scrolling="auto"
            ></iframe>
            <!-- <img :src="image" class="videoplayer" @click="isDialogVisible = true" alt=""> -->
        </div>
        <VDialog v-model="isDialogVisible" width="700">
            <VCard class="gameover-card">
                <VCardText>
                    <div class="d-flex justify-center text-center">
                        <span class="ruddy-bold gameover-text ruddy-bold"
                            >congratulations,
                            <strong class="ruddy-bold">100 Stars</strong> has
                            been
                            <br />
                            added to your account!</span
                        >
                    </div>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
<style scoped>
.html5-width {
    display: block;
    overflow: scroll;
    width: 100%;
    height: calc(100vh - 40px); /* Adjust 40px according to the height of the back arrow */
}

iframe{
    width: 100%; /* Set the width to 100% */
    height: 100%; /* Set the height to 100% */
}

.gameover-card {
    /* height: 400px; */
    background: url("/images/Game Pop Up.png") no-repeat;
    background-size: cover;
}

.videoplayer {
    width: 100%;
    height: calc(100vh - 40px); /* Adjust 40px according to the height of the back arrow */
}

.gameoverimg {
    object-fit: cover !important;
}

.gameover-text > strong {
    color: #ff6262 !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.gameover-text {
    margin-top: 50% !important;
    color: var(--white, #fff);
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 40px !important;
    text-transform: capitalize;
}
</style>
