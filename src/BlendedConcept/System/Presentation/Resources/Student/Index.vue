<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/core";
import { usePage, useForm } from "@inertiajs/vue3";
import ExitMode from "@mainRoot/components/Student/ExitMode.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";

let props = defineProps({
    // isOpenMenu: {
    //     type: Boolean,
    //     default: true,
    // },
    user_survey: {
        type: Object,
    },
});

const teacher_id = ref(null);
const page = usePage();
const user = computed(() => page.props.auth.data);
const userInfo = computed(() => page.props.user_info.user_detail);
const userData = user.value;
let isLandscape = ref(false);

const getCookie = (name) => {
    const cookies = document.cookie.split("; ");
    for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split("=");
        if (cookieName === name) {
            return cookieValue;
        }
    }
    return null;
};

console.log(userData);

const logout = () => {
    router.post("/logout");
};

const handleOrientationChange = () => {
    if (isPortrait()) {
        isLandscape.value = false;
    } else {
        isLandscape.value = true;
    }
};

const isOpenMenu = ref(false);

const menuOpener = () => {
    isOpenMenu.value = !isOpenMenu.value;
}

const isPortrait = () => {
    // Check whether the screen is in portrait mode
    return window.innerHeight > window.innerWidth;
};
const getImage = (user) => {
    return userInfo.value?.profile_pic ?? "/images/profile/profilefive.png";
};
onMounted(() => {
    // Initial check for orientation
    handleOrientationChange();

    // Add an event listener for orientation change
    window.addEventListener("resize", handleOrientationChange);
});
</script>

<template>
    <section class="section-student-home">
        <div class="d-flex justify-center">
            <div class="wrapper">
                <div class="d-flex justify-center">
                    <div class="">
                        <img
                            src="/images/Storybooks.png"
                            @click="() => router.get(route('storybooks'))"
                            class="storybook"
                            alt=""
                        />
                    </div>
                    <div class="mx-1">
                        <div class="text-left">
                            <img
                                src="/images/Games.png"
                                @click="() => router.get(route('student-games'))"
                                class="games"
                                alt=""
                            />
                        </div>
                        <div class="text-left">
                            <img
                                src="/images/Rewards.png"
                                @click="() => router.get(route('student-rewards'))"
                                class="rewards"
                                alt=""
                            />
                        </div>
                    </div>
                    <!-- <VRow class="tablet-resize">
                        <VCol cols="12" sm="6" lg="7">
                            <div class="mt-15 text-right">
                                <img
                                    src="/images/Storybooks.png"
                                    @click="() => router.get(route('storybooks'))"
                                    class="storybook"
                                    alt=""
                                />
                            </div>
                        </VCol>
                        <VCol cols="12" sm="3" lg="5" class="md-text-left">
                            <div class="text-left mt-14">
                                <img
                                    src="/images/Games.png"
                                    @click="() => router.get(route('student-games'))"
                                    class="games"
                                    alt=""
                                />
                            </div>
                            <div class="text-left">
                                <img
                                    src="/images/Rewards.png"
                                    @click="() => router.get(route('student-rewards'))"
                                    class="rewards"
                                    alt=""
                                />
                            </div>
                        </VCol>
                    </VRow> -->
                </div>
            </div>
        </div>

        <UserExperienceSurvey
            v-if="props.user_survey ?? false"
            :data="props.user_survey"
        />
    </section>
</template>

<style scoped>
.section-student-home {
    position: fixed;
    overflow: hidden; /* Hide overflow to prevent scrolling */
}

.wrapper {
    width: 70%;
    padding: 1rem;
    margin-left: 13vh;
    margin-top: 6vh;
}

/* Adjust image sizes to fit the screen */
.storybook,
.games,
.rewards {
    width: 100%;
    max-width: 100%;
}


.label-student {
    color: #000 !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    line-height: 0.1 !important;
}

.games,.rewards,.games-landscape,.rewards-landscape,.storybook  {
    cursor: pointer !important;
}

.card-student {
    background: var(--pale-blue, #d7ddf2);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.value-student {
    color: #000 !important;
    font-size: 13px !important;
    line-height: 2.4 !important;
}

.semi-text {
    color: var(--text, #161616);
    font-size: 13px !important;
    font-style: normal;
    font-weight: 700;
    margin: 0 !important;
    line-height: 0.1 !important;
    padding: 0 !important;
}


.studentimg {
    object-fit: cover;
    width: 50.181px;
    height: 50px;
    flex-shrink: 0;
    border-radius: 50% !important;
}

.studentname {
    color: var(--text, #161616) !important;
    font-size: 15px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    align-self: flex-end;
}
.margin-left {
    margin-left: 40px !important;
}


:deep(.opener span.v-btn__content > svg) {
    color: #000 !important;
    font-size: 30px !important;
}


@media only screen and (max-width: 600px) and (orientation: portrait) {
    .wrapper{
        margin: 0 auto;
    }
}

@media only screen and (min-width: 600px) and (max-height: 450px) and (orientation: landscape) {
    .wrapper{
        margin-top: 4vh;
        margin-left: 0px;
        width: 50%;
    }
}

@media only screen and (min-width: 600px) and (max-width: 1366px) and (orientation: portrait) {
    .wrapper{
        margin-left: -2vh;
    }
}

@media only screen and (min-width: 600px) and (max-width: 1366px) and (orientation: landscape) {
    .wrapper{
        margin-left: 5vh;
    }
}

</style>
