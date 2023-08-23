<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/core";

</script>

<template>
    <section>
        <VRow>
            <VCol cols="3">
                <VCard class="text-center card-student">
                    <div class="d-flex justify-center mt-2">
                        <img src="/images/classroom1.jpeg" class="studentimg">
                    </div>
                    <div class="mt-4">
                        <span class="studentname">Francisco Maia</span>
                    </div>
                    <div class="mt-1">
                        <span class="semi-text">Female</span>
                    </div>
                    <VRow class="mx-2 mt-3">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">DOB</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">January 1, 2012</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student">Education </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student">Level </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">K1</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student">Disability </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student">Types </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">Down Syndrome</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <div>
                                <span class="label-student">Accessibility </span>
                            </div>
                            <div class="text-left">
                                <span class="label-student">Device </span>
                            </div>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">Switch Single</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">Student Code</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">128, 274</span>
                            </div>
                        </VCol>
                    </VRow>
                    <div class="text-center mt-5">
                        <span class="semi-text">Parent's Details</span>
                    </div>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">Name</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">Jane Ang</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">Relationship</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">Mother</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">Contact No.</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">9123 4567</span>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow class="mx-2 mt-3">
                        <VCol cols="5" class="text-left">
                            <span class="label-student">Email</span>
                        </VCol>
                        <VCol cols="7" class="text-left">
                            <div class="ml-5">
                                <span class="value-student">jane.ang@gmail.com</span>
                            </div>
                        </VCol>
                    </VRow>
                    <div class="mt-5 my-3 mx-3">
                        <v-btn varient="flat" color="#BFC0C1" class="textcolor w-100" rounded>
                        Exit Kids Mode
                        </v-btn>
                    </div>
                </VCard>
            </VCol>
            <VCol cols="5">
                <div class="ml-10">
                    <img src="/images/Storybooks.png" @click="() => router.get(route('storybooks'))" class="storybook" alt="">
                </div>
            </VCol>
            <VCol cols="4" class="text-center">
                <div class="text-center">
                    <img src="/images/Games.png" @click="() => router.get(route('student-games'))" class="games" alt="">
                </div>
                <div class="text-center">
                    <img src="/images/Rewards.png" @click="() => router.get(route('student-rewards'))" class="rewards" alt="">
                </div>
            </VCol>
        </VRow>
    </section>
</template>

<style>

.label-student{
    color: #000 !important;
    font-size: 16px !important;
    font-weight: 700 !important;
}

.games{
    width: 60%;
    height: 250px;
    cursor: pointer !important;
}

.rewards{
    cursor: pointer !important;
    width: 60%;
    height: 250px;
}

.storybook{
    cursor: pointer !important;
    width: 100%;
    height: 506px;
}

.card-student{
    background: var(--pale-blue, #D7DDF2);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.value-student{
    color: #000 !important;
    font-size: 16px !important;
}

.semi-text{
    color: var(--text, #161616);
    font-size: 14px;
    font-style: normal;
    font-weight: 700;
    line-height: 22px; /* 157.143% */
}

.studentimg{
    object-fit: cover;
    /* border-radius: 180.181px; */
    width: 130.181px;
    height: 121px;
    flex-shrink: 0;
    border-radius: 50% !important;
}

.studentname{
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
</style>
