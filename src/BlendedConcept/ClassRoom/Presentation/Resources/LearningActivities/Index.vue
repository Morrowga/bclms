<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import LearningActivity from "./components/LearningActivity.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { ref } from "vue";
let props = defineProps(["storybook", "h5p_contents", "student"]);
let tab = ref(false);
const setImage = () => {
    return props.storybook.thumbnail_img == "" || !props.storybook.thumbnail_img
        ? "/images/defaults/organisation_logo.png"
        : props.storybook.thumbnail_img;
};
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img :src="setImage()" />
                </v-col>
                <v-col cols="12" md="6">
                    <h1 class="tiggie-sub-subtitle ml-10 fs-40">
                        {{ storybook.name }}
                    </h1>
                    <p class="text-subtitle-1">
                        {{ storybook.description }}
                    </p>
                    <br />
                    <div class="learning-chip-group">
                        <v-chip
                            v-for="device in storybook.devices"
                            :key="device.id"
                            variant="outlined"
                            color="success"
                            class="mr-4"
                            >{{ device.name }}</v-chip
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
                                        v-for="learningneed in storybook.learningneeds"
                                        :key="learningneed.id"
                                        :title="learningneed.name"
                                    />
                                </v-window-item>
                                <v-window-item value="themes">
                                    <ChipWithBlueDot
                                        v-for="theme in storybook.themes"
                                        :key="theme.id"
                                        :title="theme.name"
                                    />
                                </v-window-item>

                                <v-window-item value="disability">
                                    <ChipWithBlueDot
                                        v-for="dt in storybook.disability_types"
                                        :key="dt.id"
                                        :title="dt.name"
                                    />
                                </v-window-item>
                            </v-window>
                        </div>
                    </div>
                    <div class="learning-progress mt-10">
                        <v-progress-linear
                            model-value="70"
                            height="10"
                            bg-color="#FF6262"
                            color="#FF6262"
                        ></v-progress-linear>
                        <p class="text-center text-h6">70% Completed</p>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <LearningActivity :h5p_contents="h5p_contents" />
                </v-col>
                <v-col cols="12" class="d-flex justify-center">
                    <Link
                        :href="
                            route('teacher_students.show', student.student_id)
                        "
                    >
                        <v-btn
                            variant="flat"
                            rounded
                            color="rgba(55, 73, 233, 0.10)"
                            class="text-primary"
                            width="200"
                            >Back</v-btn
                        >
                    </Link>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
