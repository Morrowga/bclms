<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/core";
import { usePage,useForm } from "@inertiajs/vue3";
import ExitMode from "@mainRoot/components/Student/ExitMode.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";

let props = defineProps({
    isOpenMenu: {
        type: Boolean,
        default: true,
    },
    user_survey: {
        type: Object
    }
});
const teacher_id = ref(null);
const page = usePage();
const user = computed(() => page.props.auth.data);
const userData = user.value

const getCookie = () => {
  const cookieName = "teacher_id"; // Replace with your cookie name
  const cookies = document.cookie.split("; ");
  for (const cookie of cookies) {
    const [name, value] = cookie.split("=");
    if (name === cookieName) {
        teacher_id.value = value;
      return;
    }
  }
};
console.log(getCookie()+ 'teacher_id')

onMounted(() => {
  // Load initial data for page 1
  getCookie();
});
</script>

<template>
    <section class="section-student-home vh-m-86">
        <VRow>
            <VCol cols="12" lg="3" md="6">
                <VFadeTransition>
                    <VCard
                        v-if="props.isOpenMenu"
                        class="text-center card-student ml-5"
                    >
                        <div class="d-flex justify-center mt-2">
                            <img
                                src="/images/classroom1.jpeg"
                                class="studentimg"
                            />
                        </div>
                        <div class="mt-2">
                            <p class="studentname pppangram-bold">
                                {{ user.name }}
                            </p>
                            <p class="semi-text pppangram-medium">{{ userData.student.gender}}</p>
                        </div>
                        <VRow class="mx-2 my-2">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">DOB</p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{userData.student.dob}}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-1">
                            <VCol cols="5" class="text-left">
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
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{userData.student.education_level}}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left">
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
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5" v-if="userData.student.disability_types.length > 0">
                                    <p class="value-student pppangram-medium" v-for="diabilitytype in userData.student.disability_types" :key="diabilitytype.id">
                                        {{ diabilitytype.name  }}
                                    </p>
                                </div>
                                <div class="ml-5" v-else>
                                    <p class="value-student pppangram-medium">
                                        No Disability Type
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left">
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
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        Switch Single
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left">
                                <span class="label-student pppangram-bold"
                                    >Student Code</span
                                >
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <span class="value-student pppangram-medium"
                                        >{{ userData.student.student_code ?? 'No Code' }}</span
                                    >
                                </div>
                            </VCol>
                        </VRow>
                        <div class="text-center mt-6">
                            <p class="semi-text pppangram-medium">
                                Parent's Details
                            </p>
                        </div>
                        <VRow class="mx-2 my-4">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">Name</p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{ userData.student.parent.user.full_name }}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">
                                    Relationship
                                </p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        Parent
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">
                                    Contact No.
                                </p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{ userData.student.parent.user.contact_number }}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <VRow class="mx-2 my-0">
                            <VCol cols="5" class="text-left mt-3">
                                <p class="label-student pppangram-bold">
                                    Email
                                </p>
                            </VCol>
                            <VCol cols="7" class="text-left">
                                <div class="ml-5">
                                    <p class="value-student pppangram-medium">
                                        {{ userData.student.parent.user.email }}
                                    </p>
                                </div>
                            </VCol>
                        </VRow>
                        <div class="mt-1 my-3 mx-3">
                            <ExitMode :teacher_id="teacher_id" :student_id="userData.student.student_id" />
                        </div>
                    </VCard>
                </VFadeTransition>
            </VCol>
            <VCol cols="12" lg="5" md="6">
                <div class="ml-10 d-none d-md-flex">
                    <img
                        src="/images/Storybooks.png"
                        @click="() => router.get(route('storybooks'))"
                        class="storybook"
                        alt=""
                    />
                </div>
                <div class="d-flex d-sm-none">
                    <img
                        src="/images/Storybooks.png"
                        @click="() => router.get(route('storybooks'))"
                        class="storybook"
                        alt=""
                    />
                </div>
            </VCol>
            <VCol cols="12" lg="4" md="6" class="text-center">
                <div class="text-center">
                    <img
                        src="/images/Games.png"
                        @click="() => router.get(route('student-games'))"
                        class="games"
                        alt=""
                    />
                </div>
                <div class="text-center">
                    <img
                        src="/images/Rewards.png"
                        @click="() => router.get(route('student-rewards'))"
                        class="rewards"
                        alt=""
                    />
                </div>
            </VCol>
        </VRow>
        <UserExperienceSurvey v-if="props.user_survey ?? false" :data="props.user_survey" />
    </section>
</template>

<style>
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
    width: 60%;
    height: 250px;
    cursor: pointer !important;
}

.rewards {
    cursor: pointer !important;
    width: 60%;
    height: 250px;
}

.storybook {
    cursor: pointer !important;
    width: 100%;
    height: 506px;
}

.card-student {
    background: var(--pale-blue, #d7ddf2);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.value-student {
    color: #000 !important;
    font-size: 13px !important;
    /* line-height:  !important; */
}

.semi-text {
    color: var(--text, #161616);
    font-size: 11px !important;
    font-style: normal;
    font-weight: 700;
    margin: 0 !important;
    line-height: 0.1 !important;
    padding: 0 !important;
    /* line-height: 22px;  */
}

.section-student-home {
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

@media only screen and (max-width: 600px) {
    .games {
        width: 100% !important;
    }
    .rewards {
        width: 100% !important;
    }
}
</style>
