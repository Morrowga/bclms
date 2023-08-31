<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/core";
import ExitMode from "@mainRoot/components/Student/ExitMode.vue";
let props = defineProps({
    isOpenMenu: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <section class="section-student-home" style="min-height: 86.8vh">
        <VRow>
            <VCol cols="12" lg="3" md="6">
                <VCard
                    v-if="props.isOpenMenu"
                    class="text-center card-student ml-5"
                >
                    <div class="d-flex justify-center mt-2">
                        <img src="/images/classroom1.jpeg" class="studentimg" />
                    </div>
                    <div class="mt-2">
                        <p class="studentname pppangram-bold">Francisco Maia</p>
                        <p class="semi-text pppangram-medium">Female</p>
                    </div>
                    <VRow class="mx-2 my-2">
                        <VCol cols="5" class="text-left">
                            <p class="label-student pppangram-bold">DOB</p>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    January 1, 2012
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
                                <p class="value-student pppangram-medium">K1</p>
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
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    Down Syndrome
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
                                    >128, 274</span
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
                        <VCol cols="5" class="text-left">
                            <p class="label-student pppangram-bold">Name</p>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    Jane Ang
                                </p>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2 my-0">
                        <VCol cols="5" class="text-left">
                            <p class="label-student pppangram-bold">
                                Relationship
                            </p>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    Mother
                                </p>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2 my-0">
                        <VCol cols="5" class="text-left">
                            <p class="label-student pppangram-bold">
                                Contact No.
                            </p>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    9123 4567
                                </p>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2 my-0">
                        <VCol cols="5" class="text-left">
                            <p class="label-student pppangram-bold">Email</p>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <p class="value-student pppangram-medium">
                                    jane.ang@gmail.com
                                </p>
                            </div>
                        </VCol>
                    </VRow>
                    <div class="mt-1 my-3 mx-3">
                        <ExitMode />
                    </div>
                </VCard>
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
    line-height: 0.1 !important;
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
