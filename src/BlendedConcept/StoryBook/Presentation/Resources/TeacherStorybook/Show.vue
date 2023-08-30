<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import StorybookVersion from "./components/StorybookVersion.vue";
import LearningActivity from "./components/LearningActivity.vue";
import RecommendedGames from "./components/RecommendedGames.vue";
import PhysicalResources from "./components/PhysicalResources.vue";
import RecommendedBooks from "./components/RecommendedBooks.vue";
import ReviewDialog from "./components/ReviewDialog.vue";
import { router } from "@inertiajs/core";
import { ref } from "vue";
import VersionCard from "@mainRoot/components/Teacher/VersionCard.vue";

let tab = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <v-row>
                <v-col cols="12" md="6">
                    <div style="position: relative">
                        <v-img src="/images/img.png" class="main-pic" />
                        <div class="vector-background">
                            <img src="/images/bg.png" />
                        </div>
                    </div>
                </v-col>
                <v-col cols="12" md="6">
                    <VRow>
                        <VCol cols="12" md="6">
                            <h1
                                class="tiggie-sub-subtitle ml-10"
                                style="font-size: 40px !important"
                            >
                                Toy Story 2
                            </h1>
                        </VCol>
                        <VCol cols="12" md="6" class="text-end">
                            <ReviewDialog />
                        </VCol>
                    </VRow>
                    <p class="text-subtitle-1">
                        When Woody is kidnapped by a greedy toy collector and is
                        nowhere to be found, Buzz and his friends set out to
                        rescue him.
                    </p>
                    <br />
                    <div class="learning-chip-group">
                        <v-chip variant="outlined" color="success" class="mr-4"
                            >Switch</v-chip
                        >
                        <v-chip variant="outlined" color="success" class="mr-4"
                            >Eye-Gaze</v-chip
                        >
                        <v-chip variant="outlined" color="success" class="mr-4"
                            >Touch</v-chip
                        >
                    </div>
                    <div class="learning-tabs mt-10">
                        <v-tabs v-model="tab">
                            <v-tab value="learning">Learning Needs</v-tab>
                            <v-tab value="themes">Themes</v-tab>
                            <v-tab value="disability"
                                >Learning Activities</v-tab
                            >
                        </v-tabs>

                        <div>
                            <v-window v-model="tab">
                                <v-window-item value="learning">
                                    <ChipWithBlueDot
                                        v-for="item in 5"
                                        :key="item"
                                        title="Dyslexia"
                                    />
                                </v-window-item>
                                <v-window-item value="themes">
                                    <ChipWithBlueDot
                                        v-for="item in 5"
                                        :key="item"
                                        title="Themes"
                                    />
                                </v-window-item>

                                <v-window-item value="disability">
                                    <ChipWithBlueDot
                                        v-for="item in 5"
                                        :key="item"
                                        title="Disability"
                                    />
                                </v-window-item>
                            </v-window>
                        </div>
                    </div>
                </v-col>
            </v-row>
            <v-row class="storybook-version" style="margin-top: 100px">
                <v-col cols="12">
                    <StorybookVersion />
                </v-col>
            </v-row>
            <v-row class="learning-activity" style="margin-top: 100px">
                <v-col cols="12">
                    <LearningActivity />
                </v-col>
            </v-row>
            <v-row class="recommended-games" style="margin-top: 100px">
                <v-col cols="12">
                    <RecommendedGames />
                </v-col>
            </v-row>
            <v-row class="physical" style="margin-top: 100px">
                <v-col cols="12">
                    <PhysicalResources />
                </v-col>
            </v-row>
            <v-row class="recommended-books" style="margin-top: 100px">
                <v-col cols="12">
                    <RecommendedBooks />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-center">
                    <SecondaryBtn
                        title="Back"
                        @click="router.get(route('teacher_storybook.index'))"
                    />
                </v-col>
            </v-row>
            <VersionCard />
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.main-pic {
    z-index: 2;
}
.vector-background {
    position: absolute;
    top: -52%;
    left: -36%;
    z-index: 1;
}
.vector-background img {
    width: 900px;
    height: auto;
}
</style>
