<script setup>
import StudentProfile from "./components/StudentProfile.vue";
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import UserExperiencSurvey from "./components/UserExperiencSurvey.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { defineProps } from "vue";
import TotalStudents from "./TotalStudent.vue";

const props = defineProps(["students"]);
</script>

<template>
    <section>
        <VContainer>
            <VRow align="center">
                <VCol cols="12" sm="12" lg="12" class="mt-10">
                    <TotalStudents :students="props.students" />
                </VCol>
            </VRow>
        </VContainer>
        <UserExperiencSurvey />
    </section>
</template>

<style></style>
