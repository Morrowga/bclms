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
        <VRow class="tablet-resize">
            <!-- <VCol cols="12" sm="4" lg="3">
                <VBtn
                @click="menuOpener"
                color="#BFC0C1"
                class="ml-5 opener"
                :icon="isOpenMenu ? 'mdi-chevron-down' : 'mdi-chevron-right'"
                >
                </VBtn>
                <VFadeTransition>
                    <VCard
                        class="text-center card-student ml-5 mt-4"
                    >
                        <div class="d-flex justify-center mt-2">
                            <img :src="getImage()" class="studentimg" />
                            <div class="mt-2 mx-4">
                                <p class="studentname pppangram-bold">
                                    {{ userData.name }}
                                </p>
                                <p class="semi-text pppangram-bold">
                                    {{ userData.student.gender }}
                                </p>
                            </div>
                        </div>
                        <VRow class="mx-2 mt-1">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">DOB</p>
                                <div class="mt-7">
                                    <div>
                                        <p class="label-student pppangram-bold">
                                            Education
                                        </p>
                                    </div>
                                    <div class="text-left">
                                        <p class="label-student pppangram-bold">
                                            Level
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-7">
                                    <div>
                                        <p class="label-student pppangram-bold">
                                            Disability
                                        </p>
                                    </div>
                                    <div class="text-left">
                                        <p class="label-student pppangram-bold">
                                            Types
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-7">
                                    <div>
                                        <p class="label-student pppangram-bold">
                                            Accessibility
                                        </p>
                                    </div>
                                    <div class="text-left">
                                        <p class="label-student pppangram-bold">
                                            Device
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="label-student pppangram-bold"
                                        >Student Code</span
                                    >
                                </div>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{ userData.student.dob }}
                                        <br />
                                        {{ userData.student.education_level }}
                                    </p>
                                    <div
                                        v-if="
                                            userData.student.disability_types
                                                .length > 0
                                        "
                                    >
                                        <p
                                            class="value-student pppangram-medium"
                                            v-for="diabilitytype in userData
                                                .student.disability_types"
                                            :key="diabilitytype.id"
                                        >
                                            {{ diabilitytype.name }}
                                        </p>
                                    </div>
                                    <div v-else>
                                        <p
                                            class="value-student pppangram-medium"
                                        >
                                            No Disability Type
                                        </p>
                                    </div>
                                    <div>
                                        <span
                                            class="value-student pppangram-medium"
                                            >{{
                                                userData.student.device ===
                                                    null ||
                                                userData.student.device === ""
                                                    ? "No Device"
                                                    : userData.student.device
                                                          .name
                                            }}</span
                                        >
                                    </div>
                                    <div class="mt-2">
                                        <span
                                            class="value-student pppangram-medium"
                                            >{{
                                                userData.student.student_code ??
                                                "No Code"
                                            }}</span
                                        >
                                    </div>
                                </div>
                            </VCol>
                        </VRow>
                        <div class="text-center mt-9">
                            <p class="semi-text pppangram-bold">
                                Parent's Details
                            </p>
                        </div>
                        <VRow class="mx-2 my-2">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">Name</p>
                                <p class="label-student pppangram-bold mt-8">
                                    Relationship
                                </p>
                                <p class="label-student pppangram-bold mt-8">
                                    Contact No.
                                </p>
                                <p class="label-student pppangram-bold mt-8">
                                    Email
                                </p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{
                                            userData.student.parent
                                                ? userData.student.parent?.user
                                                      .full_name
                                                : userData.student.teachers?.[0]
                                                      ?.user?.full_name
                                        }}
                                        <br />
                                        {{
                                            userData.student.parent
                                                ? "Parent"
                                                : "Teacher"
                                        }}
                                        <br />
                                        {{
                                            userData.student.parent
                                                ? userData.student.parent?.user
                                                      .contact_number
                                                : userData.student.teachers?.[0]
                                                      ?.user.contact_number
                                        }}
                                        <br />
                                        {{
                                            userData.student.parent
                                                ? userData.student.parent?.user
                                                      .email
                                                : userData.student.teachers?.[0]
                                                      ?.user.email
                                        }}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <div class="mt-1 my-3 mx-3">
                            <ExitMode
                                :teacher_id="getCookie('teacher_id')"
                                :student_id="userData.student.student_id"
                            />
                            <VBtn
                                color="#BFC0C1"
                                @click="logout"
                                v-if="userData.student.organisation_id == null"
                                variant="flat"
                                class="textcolor w-100 pppangram-bold mt-3"
                                rounded
                                >Logout</VBtn
                            >
                        </div>
                    </VCard>
                </VFadeTransition>
            </VCol> -->
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
        </VRow>
        <UserExperienceSurvey
            v-if="props.user_survey ?? false"
            :data="props.user_survey"
        />
    </section>
</template>

<style scoped>
/* .student .layout-page-content{
    background: url('/images/artbg.png') no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
} */

.label-student {
    color: #000 !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    line-height: 0.1 !important;
}

.games {
    width: 40%;
    height: 250px;
    cursor: pointer !important;
}

.rewards {
    cursor: pointer !important;
    width: 40%;
    height: 250px;
}
.games-landscape {
    width: 100%;
    height: 250px;
    cursor: pointer !important;
}

.rewards-landscape {
    cursor: pointer !important;
    width: 100%;
    height: 250px;
}

.storybook {
    cursor: pointer !important;
    width: 65%;
    height: 506px;
}

.card-student {
    background: var(--pale-blue, #d7ddf2);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.value-student {
    color: #000 !important;
    font-size: 13px !important;
    line-height: 2.4 !important;
    /* line-height:  !important; */
}

.semi-text {
    color: var(--text, #161616);
    font-size: 13px !important;
    font-style: normal;
    font-weight: 700;
    margin: 0 !important;
    line-height: 0.1 !important;
    padding: 0 !important;
    /* line-height: 22px;  */
}

.section-student-home {
    padding: 10px;
    overflow: hidden !important;
}

.studentimg {
    object-fit: cover;
    /* border-radius: 180.181px; */
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
    /* line-height: 32px !important; */
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
    /* line-height: 52px !important; */
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

@media only screen and (max-width: 600px) {
    .games {
        width: 100% !important;
        height: auto !important;
    }
    .rewards {
        width: 100% !important;
        height: auto !important;
    }

    .storybook{
        width: 100% !important;
        height: auto !important;
    }
}
/* Tablets in portrait mode */
@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .games {
        width: 100% !important;
    }
    .rewards {
        width: 100% !important;
    }
    .margin-left {
        margin-left: 0 !important;
    }
}
/* Tablets in landscape mode */
@media only screen and (min-width: 1025px) and (max-width: 1280px) {
    .games {
        width: 100% !important;
        height: 34vh;
    }
    .rewards {
        width: 100% !important;
        height: 34vh;
    }
    .margin-left {
        margin-left: 0 !important;
    }

    .storybook{
        height: auto;
        width: 100%;
    }

    .tablet-resize{
        display: flex;
        justify-content: center;
    }
}

@media only screen
  and (min-device-width: 768px)
  and (max-device-width: 1024px)
  and (-webkit-min-device-pixel-ratio: 1)
  and (orientation: landscape) {
    .tablet-resize{
        display: flex;
        justify-content: center;
    }

    .storybook{
        width: 100%;
    }
}

@media only screen
  and (min-device-width: 1366px)
  and (max-device-width: 1366px)
  and (-webkit-min-device-pixel-ratio: 2)
  and (orientation: landscape) {
    .storybook {
        width: 80%;
        height: 57vh;
    }

    .games{
        width: 52%;
        height: 28vh;
    }

    .rewards{
        width: 52%;
        height: 28vh;
    }
  /* Styles for iPad Pro (12.9-inch) in landscape mode */
}
</style>
