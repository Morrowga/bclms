<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";

import { ref } from "vue";
let tab = ref(null);
const deleteStudent = () => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            SuccessDialog({
                title: "You have successfully deleted student!",
                color: "#17CAB6",
            });
        },
    });
};
</script>
<template>
    <AdminLayout>
        <v-container class="width-80">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img src="/images/student_pf.png" />
                </v-col>
                <v-col cols="12" md="6" class="pa-5">
                    <div class="d-flex justify-space-between align-center">
                        <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
                        <div>
                            <Link
                                :href="
                                    route(
                                        'organizations-student.edit'
                                    )
                                "
                            >
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
                                @click="deleteStudent"
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
                    </v-row>
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="2">
                    <Link :href="route('organizations-student.index')">
                        <v-btn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-primary">Back</span>
                        </v-btn>
                    </Link>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<style scoped></style>
