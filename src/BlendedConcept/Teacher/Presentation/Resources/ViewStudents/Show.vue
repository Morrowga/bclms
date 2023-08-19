<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StoryBookSlider from "./components/StoryBookSlider.vue";
import PlaylistSlider from "./components/PlaylistSlider.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";

import { ref } from "vue";
let tab = ref(null);
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img src="/images/student_pf.png" />

                    <div class="d-flex justify-center my-4">
                        <v-btn
                            variant="flat"
                            rounded
                            color="#FF8015"
                            class="text-white"
                            >Enter Kids Mode</v-btn
                        >
                    </div>
                </v-col>
                <v-col cols="12" md="6" class="pa-5">
                    <div class="d-flex justify-space-between align-center">
                        <h1
                            class="tiggie-sub-subtitle"
                            style="font-size: 40px !important"
                        >
                            Students
                        </h1>
                        <div>
                            <Link :href="route('view_students.edit')">
                                <v-btn
                                    variant="flat"
                                    rounded
                                    color="#17CAB6"
                                    prepend-icon="mdi-pencil"
                                    class="mr-4 text-white"
                                    >Edit</v-btn
                                >
                            </Link>
                            <v-btn
                                variant="flat"
                                rounded
                                color="error"
                                prepend-icon="mdi-trash"
                                >Delete</v-btn
                            >
                        </div>
                    </div>
                    <v-row>
                        <v-col cols="12" class="mt-10">
                            <p class="text-h5 font-weight-bold mb-0">
                                Student Details
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Fullname</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                Wren Clark
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Gender</p>
                            <p class="text-h6 font-weight-bold mx-4">Female</p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Date of birth</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                January 24, 2010
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Education Level</p>
                            <p class="text-h6 font-weight-bold mx-4">K1</p>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="mt-3">
                            <p class="text-h5 font-weight-bold mb-0">
                                Parent Details
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Fullname</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                Francisco Maia
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Relationship To Child
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">Mother</p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Contact Number</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                9872333243
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Email Address</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                francisco@gmail.com
                            </p>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-tabs v-model="tab">
                                <v-tab value="learning">Learning Need</v-tab>
                                <v-tab value="disability"
                                    >Disability Types</v-tab
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

                                    <v-window-item value="disability">
                                        <ChipWithBlueDot
                                            v-for="item in 5"
                                            :key="item"
                                            title="Disability"
                                        />
                                    </v-window-item>
                                </v-window>
                            </div>
                        </v-col>

                        <v-col cols="12">
                            <div>
                                <v-btn
                                    variant="flat"
                                    rounded
                                    color="#FF8015"
                                    class="mr-4 text-white"
                                    >Do/Redo Profiling Survey</v-btn
                                >
                                <v-btn
                                    variant="flat"
                                    rounded
                                    color="#FF8015"
                                    class="text-white"
                                    >Set Accessibility Device</v-btn
                                >
                            </div>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </VContainer>
        <div class="storybooks-assign mb-4">
            <VContainer class="header" style="width: 80%; margin: 0 auto">
                <div class="d-flex justify-space-between align-center">
                    <h1 class="text-h4 font-weight-bold">
                        Storybooks Assigned to Student
                    </h1>
                    <v-spacer></v-spacer>

                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                    ></v-text-field>
                </div>
            </VContainer>
            <div>
                <StoryBookSlider />
            </div>
        </div>

        <div class="playlist">
            <VContainer class="header" style="width: 80%; margin: 0 auto">
                <div class="d-flex justify-space-between align-center">
                    <h1 class="text-h4 font-weight-bold">Playlists</h1>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                    ></v-text-field>
                </div>
            </VContainer>
            <div>
                <PlaylistSlider />
            </div>
        </div>
    </AdminLayout>
</template>
<style scoped></style>
