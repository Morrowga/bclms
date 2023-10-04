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

const props = defineProps(["teacher_storybook", "storybooks", "games"]);

let tab = ref(false);
const getImage = (item) => {
    return item.thumbnail_img == "" || !item.thumbnail_img
        ? "/images/image8.png"
        : item.thumbnail_img;
};
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row>
                <v-col cols="12" md="6">
                    <div class="ps-relative">
                        <v-img
                            :src="getImage(teacher_storybook)"
                            class="main-pic"
                        />
                        <div class="vector-background">
                            <img src="/images/bg.png" />
                        </div>
                    </div>
                </v-col>
                <v-col cols="12" md="6">
                    <VRow>
                        <VCol cols="12" md="6">
                            <h1 class="tiggie-sub-subtitle ml-10 fs-40">
                                {{ teacher_storybook.name }}
                            </h1>
                        </VCol>
                        <VCol cols="12" md="6" class="text-end">
                            <ReviewDialog
                                :storybook_id="teacher_storybook.id"
                            />
                        </VCol>
                    </VRow>
                    <p class="text-subtitle-1">
                        {{ teacher_storybook.description }}
                    </p>
                    <br />
                    <div class="learning-chip-group">
                        <v-chip
                            v-for="teacher_sb in teacher_storybook.devices"
                            variant="outlined"
                            color="success"
                            :key="teacher_sb.id"
                            class="mr-4"
                        >
                            {{ teacher_sb.name }}
                        </v-chip>
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
                                        v-for="item in teacher_storybook.learningneeds"
                                        :key="item.id"
                                        :title="item.name"
                                    />
                                </v-window-item>
                                <v-window-item value="themes">
                                    <ChipWithBlueDot
                                        v-for="item in teacher_storybook.themes"
                                        :key="item.id"
                                        :title="item.name"
                                    />
                                </v-window-item>

                                <v-window-item value="disability">
                                    <ChipWithBlueDot
                                        v-for="item in teacher_storybook.disability_types"
                                        :key="item.id"
                                        :title="item.name"
                                    />
                                </v-window-item>
                            </v-window>
                        </div>
                    </div>
                </v-col>
            </v-row>
            <v-row class="storybook-version mtop">
                <v-col cols="12">
                    <StorybookVersion :dataStoryBook="teacher_storybook" />
                </v-col>
            </v-row>

            <v-row class="recommended-games mtop">
                <v-col cols="12">
                    <RecommendedGames :games="games" />
                </v-col>
            </v-row>
            <v-row class="physical mtop">
                <v-col cols="12">
                    <PhysicalResources />
                </v-col>
            </v-row>
            <v-row class="recommended-books mtop">
                <v-col cols="12">
                    <RecommendedBooks :storybooks="storybooks" />
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
    max-height: 600px;
}
</style>
