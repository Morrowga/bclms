<script setup>
import UserListCard from "@mainRoot/components/UserListCard.vue";
import { defineProps } from "vue";

import TotalClassRooms from "./TotalClassRooms.vue";
import TotalStudents from "./TotalStudents.vue";

const statisticsWithImages = [
    {
        title: "My Classes",
        subtitle: "Total Number Of Classes",
        stats: 100,
        icon: "mdi-google-classroom",
        imgWidth: 99,
        color: "primary",
    },
    {
        title: "My Students",
        subtitle: "Total Number Of Students",
        stats: "10",
        icon: "mdi-account-multiple",
        imgWidth: 85,
        color: "success",
    },
];
</script>

<template>
    <section>
        <VRow class="match-height mb-5">
            <!-- <VCol
                v-for="statistics in statisticsWithImages"
                :key="statistics.title"
                cols="12"
                sm="12"
                md="6"
            >
                <UserListCard :statistics="statistics" />
            </VCol> -->
        </VRow>
        <VRow>
            <VCol cols="12" sm="12" lg="12">
                <div class="header">
                    <span class="text-xl">Total ClassRooms</span>
                    <br />

                    <!-- <TotalClassRooms  /> -->

                    <br />
                </div>
                <br />
            </VCol>
            <VCol cols="12" sm="12" lg="12">
                <div class="header">
                    <span class="text-xl">Latest Students</span>
                    <br />

                    <!-- <TotalStudents  /> -->

                    <br />
                </div>
                <br />
            </VCol>
        </VRow>
    </section>
</template>
