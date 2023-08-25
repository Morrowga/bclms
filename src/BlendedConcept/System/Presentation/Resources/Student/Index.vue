<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/core";
import ExitMode from "@mainRoot/components/Student/ExitMode.vue";

</script>

<template>
    <section>
        <VRow>
            <VCol cols="12" lg="3" md="6">
                <VCard class="text-center card-student">
                    <div class="d-flex justify-center mt-2">
                        <img src="/images/classroom1.jpeg" class="studentimg" />
                    </div>
                    <div class="mt-4">
                        <span class="studentname pppangram-bold"
                            >Francisco Maia</span
                        >
                    </div>
                    <div class="mt-1">
                        <span class="semi-text pppangram-medium">Female</span>
                    </div>
                    <VRow class="mx-2 mt-3">
                        <VCol cols="5" class="text-left">
                            <span class="label-student pppangram-bold"
                                >DOB</span
                            >
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >January 1, 2012</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student pppangram-bold"
                                    >Education
                                </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student pppangram-bold"
                                    >Level
                                </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >K1</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student pppangram-bold"
                                    >Disability
                                </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student pppangram-bold"
                                    >Types
                                </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >Down Syndrome</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student pppangram-bold"
                                    >Accessibility
                                </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student pppangram-bold"
                                    >Device
                                </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >Switch Single</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
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
                    <div class="text-center mt-5">
                        <span class="semi-text pppangram-medium"
                            >Parent's Details</span
                        >
                    </div>
                    <VRow class="mx-2 mt-3">
                        <VCol cols="5" class="text-left">
                            <span class="label-student pppangram-bold"
                                >Name</span
                            >
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >Jane Ang</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student pppangram-bold"
                                >Relationship</span
                            >
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >Mother</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student pppangram-bold"
                                >Contact No.</span
                            >
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >9123 4567</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2 mt-3">
                        <VCol cols="5" class="text-left">
                            <span class="label-student pppangram-bold"
                                >Email</span
                            >
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student pppangram-medium"
                                    >jane.ang@gmail.com</span
                                >
                            </div>
                        </VCol>
                    </VRow>
                    <div class="mt-5 my-3 mx-3">
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

.label-student{
    color: #000 !important;
    font-size: 16px !important;
    font-weight: 700 !important;
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
    font-size: 16px !important;
}

.semi-text {
    color: var(--text, #161616);
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 22px; /* 157.143% */
}

.studentimg {
    object-fit: cover;
    /* border-radius: 180.181px; */
    width: 130.181px;
    height: 121px;
    flex-shrink: 0;
    border-radius: 50% !important;
}

.studentname {
    color: var(--text, #161616) !important;
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 32px !important; /* 133.333% */
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
    line-height: 52px !important; /* 130% */
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
