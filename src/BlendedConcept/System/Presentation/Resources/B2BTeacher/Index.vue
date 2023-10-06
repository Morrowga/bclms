<script setup>
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import ClassroomCard from "@mainRoot/components/ClassroomCard/ClassroomCard.vue";
import { defineProps } from "vue";
import TotalStudents from "./TotalStudents.vue";
let props = defineProps(["org_teacher_students", "org_teacher_classrooms", "user_survey"]);
const showCount = (classroom) => {
    return classroom?.students_count + "/" + classroom?.teachers_count;
};

console.log(props.user_survey);
</script>
<template>
    <section>
        <VContainer>
            <!-- <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            />
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            />
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            /> -->
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <div class="header d-flex justify-space-between">
                        <h1 class="tiggie-title">Classrooms</h1>
                    </div>
                    <div class="mt-5">
                        <v-row>
                            <v-col
                                v-for="classroom in props.org_teacher_classrooms
                                    .data"
                                :key="classroom.id"
                                cols="12"
                                sm="6"
                                md="4"
                                lg="3"
                            >
                                <ClassroomCard
                                    :route="route('showCopy', classroom.id)"
                                    :count="showCount(classroom)"
                                    :label="classroom.name"
                                    :image="classroom.classroom_photo"
                                />
                            </v-col>
                        </v-row>
                    </div>
                </VCol>
                <VCol cols="12" sm="12" lg="12" class="mt-10">
                    <TotalStudents :students="props.org_teacher_students" />
                </VCol>
            </VRow>
        </VContainer>
        <UserExperienceSurvey :data="props.user_survey" />
    </section>
</template>

<style></style>
