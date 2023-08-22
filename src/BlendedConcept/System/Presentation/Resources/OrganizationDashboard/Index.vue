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
        <VContainer>
            <VRow class="match-height mb-5">
            </VRow>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <div class="header d-flex justify-space-between">
                        <h1 class="tiggie-title">Classrooms</h1>
                        <VBtn color="primary" variant="flat" rounded>
                            <VIcon icon="mdi-plus"></VIcon>
                            <span class="text-white">Add</span>
                        </VBtn>
                    </div>
                    <div class="mt-5">
                        <v-row no-gutters>
                            <v-col v-for="n in 4" :key="n">
                                <v-card class="mx-auto mr-5" max-width="400">
                                    <v-img class="align-end text-white" height="200"
                                        src="https://cdn.vuetifyjs.com/images/cards/docks.jpg" cover>
                                        <v-card-title class="text-white">Top 10 Australian beaches</v-card-title>
                                    </v-img>
                                </v-card>
                            </v-col>
                        </v-row>
                    </div>
                </VCol>
                <VCol cols="12" sm="12" lg="12" class="mt-10">
                    <div class="header">
                        <v-row>
                            <VCol cols="6">
                                <h1 class="tiggie-sub-subtitle" style="font-size: 40px !important">
                                    Students
                                </h1>
                            </VCol>
                            <VCol cols="3">
                                <VTextField rounded placeholder="Search Students ..." density="compact" />
                            </VCol>
                            <VCol cols="3">
                                <VSelect label="Sort By" density="compact" />
                            </VCol>
                        </v-row>
                        <v-row no-gutters>
                            <v-col v-for="n in 6" :key="n" cols="2">
                                <div class="ma-5 pe-2">
                                    <div class="d-flex flex-column align-center">
                                        <img class="rounded-circle w-10 h-10"
                                            src="https://images.unsplash.com/profile-1446404465118-3a53b909cc82?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64&s=3ef46b07bb19f68322d027cb8f9ac99f">
                                        <div class="mt-2">
                                            <h5 class="tiggie-subtitle">
                                                When clark
                                            </h5>
                                            <div class="d-flex align-center">
                                                <VIcon icon="mdi-phone" witdth="14px" height="14px" color="candy-red" />
                                                <span class="ml-2 phone-color">890809076</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                    </div>
                </VCol>
                <VCol cols="12" sm="12" lg="12" class="mt-10">
                    <div class="header">
                        <h1 class="tiggie-title">Teachers</h1>
                        <v-row no-gutters>
                            <v-col v-for="n in 6" :key="n">
                                <div class="ma-2 pa-2">
                                    <div class="d-flex flex-column align-center">
                                        <img class="rounded-circle w-10 h-10"
                                            src="https://images.unsplash.com/profile-1446404465118-3a53b909cc82?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64&s=3ef46b07bb19f68322d027cb8f9ac99f">
                                        <div class="mt-2">
                                            <h5 class="tiggie-subtitle">
                                                When clark
                                            </h5>
                                            <div class="d-flex align-center">
                                                <VIcon icon="mdi-phone" witdth="14px" height="14px" color="candy-red" />
                                                <span class="ml-2 phone-color">890809076</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </v-col>
                        </v-row>
                    </div>
                </VCol>
            </VRow>
        </VContainer>

    </section>
</template>

<style lang="scss">
.phone-color {
    color: #FF6262;
}

.w-10 {
    width: 180px;
}

.h-10 {
    width: 180px;
}

.w-6 {
    width: 16px;
}

.h-6 {
    height: 16px;
}
</style>
