<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex">
                <h1 class="tiggie-title mb-4">Happiness Survey</h1>
                <v-spacer></v-spacer>
                <span class="mt-2 survey_name font-weight-bold"
                    >Albert Leonardo</span
                >
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
            </div>
            <v-row>
                <v-col cols="12" md="12">
                    <v-card>
                        <v-card-title>
                            <span class="h3 font-weight-bold"
                                >Question 1 .</span
                            >
                            <span> Single Response</span>
                        </v-card-title>
                        <v-card-subtitle class="pb-2">
                            How are you feeling ? [Please select]
                        </v-card-subtitle>
                        <v-divider class="border-opacity-100"></v-divider>
                        <v-card-text>
                            <div class="d-flex">
                                <span class="h4 font-weight-bold pt-2 pr-3"
                                    >Options:
                                </span>
                                <div>
                                    <v-radio-group>
                                        <v-radio
                                            label="Radio 1"
                                            value="1"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 2"
                                            value="2"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 3"
                                            value="3"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 4"
                                            value="3"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 5"
                                            value="3"
                                        ></v-radio>
                                    </v-radio-group>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="12">
                    <v-card>
                        <v-card-title>
                            <span class="h3 font-weight-bold"
                                >Question 2 .</span
                            >
                            <span> Multiple Response</span>
                        </v-card-title>
                        <v-card-subtitle class="pb-2">
                            How are you feeling ? [Please select]
                        </v-card-subtitle>
                        <v-divider class="border-opacity-100"></v-divider>
                        <v-card-text>
                            <div class="d-flex">
                                <span class="h4 font-weight-bold pt-2 pr-3"
                                    >Options:
                                </span>
                                <div>
                                    <v-radio-group>
                                        <v-radio
                                            label="Radio 6"
                                            value="1"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 7"
                                            value="2"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 8"
                                            value="3"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 9"
                                            value="3"
                                        ></v-radio>
                                        <v-radio
                                            label="Radio 10"
                                            value="3"
                                        ></v-radio>
                                    </v-radio-group>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.survey_name {
    font-size: 26px !important;
}
</style>
