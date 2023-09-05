<script setup>
import TotalStudents from "./components/TotalStudents.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

const addGroup = () => {
    SuccessDialog({
        title: "You have successfully added a group!",
        color: "#17CAB6",
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div>
                <span class="semi-label-head ruddy-bold">Add A New Group</span>
                <p class="text-subtitle-1">
                    Each student in a classroom is limited to being part of just
                    one group.
                </p>
            </div>
            <VLabel class="semi-label ruddy-bold required mb-2"
                >Group Name</VLabel
            >
            <div class="d-flex justify-end align-center mb-4">
                <v-text-field
                    density="compact"
                    label="Search"
                    append-inner-icon="mdi-magnify"
                    single-line
                    rounded
                    hide-details
                    model-value="Group 3"
                    class="mr-4"
                ></v-text-field>
            </div>
            <VLabel class="semi-label ruddy-bold required mb-2"
                >Select Students</VLabel
            >
            <div class="d-flex justify-end align-center mb-4">
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
            <v-row>
                <v-col cols="12">
                    <TotalStudents />
                </v-col>
            </v-row>
            <br />
            <div class="d-flex justify-center" style="gap: 10px">
                <SecondaryBtn
                    title="Cancel"
                    :route="route('org-teacher-classroom.show')"
                />
                <PrimaryBtn title="Save" :isLink="false" @click="addGroup()" />
            </div>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}
.semi-label-head {
    color: var(--graphite, #282828) !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}
</style>
