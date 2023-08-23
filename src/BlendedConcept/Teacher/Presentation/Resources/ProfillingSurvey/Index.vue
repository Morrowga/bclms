<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { ref } from "vue";
let tab = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <v-row>
                <v-col cols="12" md="12">
                    <h1
                        class="text-h3 font-weight-bold mb-4"
                        style="color: #000"
                    >
                        Profilling Survey
                    </h1>
                    <span class="text-subtitle-1"
                        >Answer these questions to identify the best educational
                        pathway for the student's unique needs and
                        abilities.</span
                    >
                </v-col>
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold" style="color: #000"
                        >Question 1:</span
                    >
                    <span class="text-h6" style="color: #000">
                        Which of the following categories best describes the
                        type of special needs that the student may have? (Please
                        select all that apply) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Learning Disabilities (e.g., dyslexia, dysgraphia)"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Autism Spectrum Disorder (ASD)"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Attention Deficit Hyperactivity Disorder (ADHD)"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Intellectual Disabilities"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Speech and Language Impairments"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Emotional or Behavioural Disorders"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Physical Disabilities"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox label="Visual Impairments"></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Hearing Impairments"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold" style="color: #000"
                        >Question 2:</span
                    >
                    <span class="text-h6" style="color: #000">
                        How would you rate the student's overall level of
                        independence in daily activities? (Choose one option)
                        *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly independent - The student can complete most activities with minimal assistance"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderately independent - The student requires some support but can handle many activities independently"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Partially independent - The student needs significant assistance in several activities"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly dependent - The student relies heavily on others for daily activities"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold" style="color: #000"
                        >Question 3:</span
                    >
                    <span class="text-h6" style="color: #000">
                        In the academic setting, what specific challenges does
                        the student face due to their special needs? (Please
                        select all that apply) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with reading or comprehension"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Challenges with writing or fine motor skills
"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Trouble with focus and attention"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Social interaction difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Sensory sensitivities or sensory processing issues"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Communication challenges"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Physical mobility limitations"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Emotional regulation or self-regulation difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with organization and time management"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold" style="color: #000"
                        >Question 4:</span
                    >
                    <span class="text-h6" style="color: #000">
                        How does the student respond to changes in their routine
                        or unexpected situations? (Choose one option) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Adapts well - The student shows flexibility and copes effectively with changes"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderate response - The student may experience some initial discomfort but can adjust with support"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Difficulty adapting - The student struggles with changes and may need significant reassurance and guidance"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Severe response - The student becomes highly distressed and requires intensive support to navigate changes"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12">
                    <div class="d-flex justify-center">
                        <VBtn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            class="pl-16 pr-16 mr-4"
                        >
                            <span class="text-primary">Cancel</span>
                        </VBtn>
                        <VBtn
                            color="primary"
                            variant="flat"
                            rounded
                            class="pl-16 pr-16"
                        >
                            <span>Submit</span>
                        </VBtn>
                    </div>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
