<script setup>
import UserListCard from "@mainRoot/components/UserListCard.vue";
import { defineProps } from "vue";

import TotalClassRooms from "./TotalClassRooms.vue";
import TotalStudents from "./TotalStudents.vue";
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import TeacherAvatar from "@mainRoot/components/TeacherAvatar/TeacherAvatar.vue";
import ClassroomCard from "@mainRoot/components/ClassroomCard/ClassroomCard.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

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
    <v-container>
        <VRow>
            <VCol cols="12" sm="12" lg="12">
                <div class="header d-flex justify-space-between">
                    <h1 class="tiggie-title">Classrooms</h1>
                    <Link :href="route('classrooms.create')">
                        <VBtn color="primary" variant="flat" rounded>
                            <VIcon icon="mdi-plus"></VIcon>
                            <span class="text-white">Add</span>
                        </VBtn>
                    </Link>
                </div>
                <div class="mt-5">
                    <v-row>
                        <v-col
                            v-for="n in 8"
                            :key="n"
                            cols="12"
                            sm="6"
                            md="4"
                            lg="3"
                        >
                            <ClassroomCard
                                :route="route('showCopy')"
                                count="5 / 5"
                                :label="`${n}A`"
                            />
                        </v-col>
                    </v-row>
                </div>
            </VCol>
            <VCol cols="12" sm="12" lg="12" class="mt-10">
                <div class="header">
                    <div class="d-flex justify-end mb-4">
                        <h1 class="tiggie-title">Student</h1>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <VTextField
                            placeholder="Search User ..."
                            density="compact"
                            class="mr-4"
                        />

                        <SelectBox
                            label="Sort By"
                            :datas="[]"
                            density="compact"
                        />
                    </div>
                    <VRow no-gutters>
                        <v-col v-for="n in 12" :key="n">
                            <StudentAvatar
                                route="view_students/show"
                                image="/images/student.png"
                                title="Wren Clark"
                                phone_number="9111 1112"
                            />
                        </v-col>
                    </VRow>
                    <VRow class="d-flex justify-center align-center">
                        <Pagination />
                    </VRow>
                </div>
            </VCol>
            <VCol cols="12" sm="12" lg="12" class="mt-10">
                <div class="header">
                    <div class="d-flex justify-end mb-4">
                        <h1 class="tiggie-title">Teachers</h1>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <VTextField
                            placeholder="Search User ..."
                            density="compact"
                            class="mr-4"
                        />

                        <SelectBox
                            label="Sort By"
                            :items="[]"
                            density="compact"
                        />
                    </div>
                    <VRow no-gutters>
                        <v-col v-for="n in 12" :key="n">
                            <TeacherAvatar
                                class="py-2"
                                image="/images/teacher.png"
                                title="Wren Clark"
                                phone_number="9111 1112"
                                :route="
                                    route(
                                        'org_view_teacher_student.teacher.show'
                                    )
                                "
                                storage="135 MB/ 200 MB"
                            />
                        </v-col>
                    </VRow>
                    <VRow class="d-flex justify-center align-center">
                        <Pagination />
                    </VRow>
                </div>
            </VCol>
        </VRow>
        <UserExperienceSurvey />
    </v-container>
</template>

<style lang="scss">
.phone-color {
    color: #ff6262;
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
