<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import AddProfillingSurvey from "./components/AddProfillingSurvey.vue";
import { ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let tab = ref(false);
let isSurveryAdd = ref(false);
const checkUserRole = () => {
    return user_role.value == "BC Super Admin" || user_role.value == "BC Staff";
};
const openDialog = () => {
    isSurveryAdd.value = !isSurveryAdd.value;
};
const handleSubmit = () => {
    SuccessDialog({ title: "You've successfully added question" });
};
</script>
<template>
    <AdminLayout>
        <VContainer :fluid="checkUserRole()">
            <v-row>
                <v-col
                    cols="12"
                    md="12"
                    class="d-flex justify-space-between align-center"
                >
                    <div>
                        <h1 class="tiggie-title mb-4">Profilling Survey</h1>
                        <span class="text-subtitle-1"
                            >Answer these questions to identify the best
                            educational pathway for the student's unique needs
                            and abilities.</span
                        >
                    </div>
                    <div>
                        <VBtn @click="openDialog">Add New</VBtn>
                    </div>
                </v-col>
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 1:</span
                    >
                    <span class="text-h6 t-black">
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
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 2:</span
                    >
                    <span class="text-h6 t-black">
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
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 3:</span
                    >
                    <span class="text-h6 t-black">
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
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 4:</span
                    >
                    <span class="text-h6 t-black">
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
                <v-col cols="12"> </v-col>
            </v-row>
        </VContainer>
        <AddProfillingSurvey
            v-model:isDialogVisible="isSurveryAdd"
            @submit="handleSubmit"
        />
    </AdminLayout>
</template>
<style scoped></style>
