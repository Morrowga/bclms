<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StoryBookSlider from "./components/StoryBookSlider.vue";
import PlaylistSlider from "./components/PlaylistSlider.vue";
import { Link, useForm } from "@inertiajs/vue3";

import { ref } from "vue";
let tab = ref(null);
let form = useForm({
    student_fullname: "Wren Clark",
    gender: "Female",
    dob: "January 24,2010",
    education_level: "K1",
    parent_fullname: "Fransico Maia",
    relation_to_child: "Mother",
    contact_number: "9133232322",
    login_email: "fransica@mail.com",
    login_password: "password",
});
const isPasswordVisible = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img src="/images/student_pf.png" />
                </v-col>
                <v-col cols="12" md="6" class="pa-5">
                    <div class="d-flex justify-space-between align-center">
                        <h1
                            class="tiggie-sub-subtitle"
                            style="font-size: 40px !important"
                        >
                            Students
                        </h1>
                    </div>
                    <v-row>
                        <v-col cols="12" class="mt-10">
                            <p class="text-h5 font-weight-bold mb-0">
                                Student Details
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Fullname</p>
                            <v-text-field
                                v-model="form.student_fullname"
                                placeholder="e.g. Wren Clark"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Gender</p>
                            <v-select
                                placeholder="Select"
                                variant="solo"
                                v-model="form.gender"
                            >
                            </v-select>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Date of birth</p>
                            <v-text-field
                                v-model="form.dob"
                                placeholder="e.g January 24, 2010"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Education Level</p>
                            <v-text-field
                                v-model="form.education_level"
                                placeholder="e.g K1"
                                variant="solo"
                            ></v-text-field>
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
                            <v-text-field
                                v-model="form.parent_fullname"
                                placeholder="e.g. Fransico Maia"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Relationship To Child
                            </p>
                            <v-text-field
                                v-model="form.relation_to_child"
                                placeholder="e.g. Mother"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Contact Number</p>
                            <v-text-field
                                v-model="form.contact_number"
                                placeholder="e.g. 9180003"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Email Address</p>
                            <v-text-field
                                v-model="form.login_email"
                                placeholder="e.g. @fransico@gmail.com"
                                variant="solo"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Login Password</p>
                            <v-text-field
                                v-model="form.login_password"
                                variant="solo"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="
                                    isPasswordVisible
                                        ? 'mdi-eye-off-outline'
                                        : 'mdi-eye-outline'
                                "
                                @click:append-inner="
                                    isPasswordVisible = !isPasswordVisible
                                "
                            ></v-text-field>
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

                            <v-card-text>
                                <v-window v-model="tab">
                                    <v-window-item value="learning">
                                        <div
                                            class="chip my-2 mr-2"
                                            v-for="item in 5"
                                            :key="item"
                                        >
                                            <div class="chip-head"></div>
                                            <div class="chip-content">
                                                Dyslexia
                                            </div>
                                        </div>
                                    </v-window-item>

                                    <v-window-item value="disability">
                                        <div
                                            class="chip my-2 mr-2"
                                            v-for="item in 5"
                                            :key="item"
                                        >
                                            <div class="chip-head"></div>
                                            <div class="chip-content">
                                                Disability
                                            </div>
                                        </div>
                                    </v-window-item>
                                </v-window>
                            </v-card-text>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <div class="d-flex justify-center">
                        <Link :href="route('view_students.index')">
                            <v-btn
                                variant="flat"
                                rounded
                                class="mr-4 text-primary"
                                width="200"
                                color="rgba(55, 73, 233, 0.10)"
                                >Cancel</v-btn
                            >
                        </Link>
                        <v-btn
                            variant="flat"
                            rounded
                            width="200"
                            color="primary"
                            class="text-white"
                            >Update</v-btn
                        >
                    </div>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
}
.chip-head {
    display: flex;
    position: relative;
    overflow: hidden;
    background-color: #32c5d2;
    font-size: 1.25rem;
    flex-shrink: 0;
    align-items: center;
    user-select: none;
    border-radius: 50%;
    justify-content: center;
    width: 10px;
    color: #fff;
    height: 10px;
    margin-right: -4px;
    margin-left: 10px;
}
.chip-content {
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
</style>
