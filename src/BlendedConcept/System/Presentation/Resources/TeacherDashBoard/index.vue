<script setup>
import StudentProfile from "./components/StudentProfile.vue";
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { defineProps } from "vue";
import TotalStudents from "./TotalStudent.vue";

const props = defineProps(["students", "user_survey"]);

// console.log(props.user_survey);
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
        <UserExperienceSurvey
            v-if="props.user_survey ?? false"
            :data="props.user_survey"
        />
    </section>
</template>

<style></style>
