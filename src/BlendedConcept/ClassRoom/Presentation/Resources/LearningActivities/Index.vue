<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import LearningActivity from "./components/LearningActivity.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { ref } from "vue";
let tab = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img src="/images/imgbook.png" />
                </v-col>
                <v-col cols="12" md="6">
                    <h1
                        class="tiggie-sub-subtitle ml-10"
                        style="font-size: 40px !important"
                    >
                        Toy Story 2
                    </h1>
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
                    <LearningActivity />
                </v-col>
                <v-col cols="12" class="d-flex justify-center">
                    <v-btn
                        variant="flat"
                        rounded
                        color="rgba(55, 73, 233, 0.10)"
                        class="text-primary"
                        width="200"
                        >Back</v-btn
                    >
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
