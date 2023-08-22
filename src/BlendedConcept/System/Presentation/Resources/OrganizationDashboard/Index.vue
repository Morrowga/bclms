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
                    <h1 class="tiggie-title">Students</h1>
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
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.78325 7.44861C7.30525 8.53582 8.01684 9.5548 8.91803 10.456C9.81921 11.3572 10.8382 12.0688 11.9254 12.5908C12.0189 12.6357 12.0657 12.6581 12.1249 12.6754C12.3351 12.7367 12.5933 12.6926 12.7714 12.5651C12.8215 12.5292 12.8644 12.4864 12.9501 12.4006C13.2123 12.1384 13.3434 12.0073 13.4752 11.9216C13.9724 11.5984 14.6133 11.5984 15.1105 11.9216C15.2423 12.0073 15.3734 12.1384 15.6356 12.4006L15.7818 12.5468C16.1804 12.9454 16.3797 13.1447 16.4879 13.3587C16.7032 13.7844 16.7032 14.2871 16.4879 14.7127C16.3797 14.9268 16.1804 15.1261 15.7818 15.5246L15.6636 15.6429C15.2664 16.0401 15.0677 16.2387 14.7977 16.3904C14.4981 16.5587 14.0327 16.6797 13.6891 16.6787C13.3793 16.6778 13.1677 16.6177 12.7443 16.4975C10.4693 15.8518 8.32253 14.6335 6.53154 12.8425C4.74056 11.0515 3.5222 8.90472 2.87647 6.62967C2.75632 6.20634 2.69624 5.99467 2.69532 5.68496C2.6943 5.34129 2.81532 4.87592 2.98363 4.57629C3.13532 4.30627 3.33393 4.10766 3.73114 3.71044L3.84937 3.59222C4.24795 3.19364 4.44724 2.99434 4.66128 2.88609C5.08695 2.67078 5.58965 2.67078 6.01532 2.88609C6.22936 2.99434 6.42865 3.19364 6.82723 3.59222L6.97338 3.73837C7.23559 4.00057 7.36669 4.13168 7.4524 4.26351C7.77565 4.76068 7.77565 5.40161 7.4524 5.89878C7.36669 6.03061 7.23559 6.16172 6.97338 6.42392C6.88765 6.50966 6.84478 6.55252 6.8089 6.60263C6.68139 6.7807 6.63736 7.0389 6.69866 7.24916C6.7159 7.30833 6.73835 7.35509 6.78325 7.44861Z"
                                                    stroke="#FF6262" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
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
                                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M6.78325 7.44861C7.30525 8.53582 8.01684 9.5548 8.91803 10.456C9.81921 11.3572 10.8382 12.0688 11.9254 12.5908C12.0189 12.6357 12.0657 12.6581 12.1249 12.6754C12.3351 12.7367 12.5933 12.6926 12.7714 12.5651C12.8215 12.5292 12.8644 12.4864 12.9501 12.4006C13.2123 12.1384 13.3434 12.0073 13.4752 11.9216C13.9724 11.5984 14.6133 11.5984 15.1105 11.9216C15.2423 12.0073 15.3734 12.1384 15.6356 12.4006L15.7818 12.5468C16.1804 12.9454 16.3797 13.1447 16.4879 13.3587C16.7032 13.7844 16.7032 14.2871 16.4879 14.7127C16.3797 14.9268 16.1804 15.1261 15.7818 15.5246L15.6636 15.6429C15.2664 16.0401 15.0677 16.2387 14.7977 16.3904C14.4981 16.5587 14.0327 16.6797 13.6891 16.6787C13.3793 16.6778 13.1677 16.6177 12.7443 16.4975C10.4693 15.8518 8.32253 14.6335 6.53154 12.8425C4.74056 11.0515 3.5222 8.90472 2.87647 6.62967C2.75632 6.20634 2.69624 5.99467 2.69532 5.68496C2.6943 5.34129 2.81532 4.87592 2.98363 4.57629C3.13532 4.30627 3.33393 4.10766 3.73114 3.71044L3.84937 3.59222C4.24795 3.19364 4.44724 2.99434 4.66128 2.88609C5.08695 2.67078 5.58965 2.67078 6.01532 2.88609C6.22936 2.99434 6.42865 3.19364 6.82723 3.59222L6.97338 3.73837C7.23559 4.00057 7.36669 4.13168 7.4524 4.26351C7.77565 4.76068 7.77565 5.40161 7.4524 5.89878C7.36669 6.03061 7.23559 6.16172 6.97338 6.42392C6.88765 6.50966 6.84478 6.55252 6.8089 6.60263C6.68139 6.7807 6.63736 7.0389 6.69866 7.24916C6.7159 7.30833 6.73835 7.35509 6.78325 7.44861Z"
                                                    stroke="#FF6262" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
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
