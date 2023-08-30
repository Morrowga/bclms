<script setup>
import StudentProfile from "./components/StudentProfile.vue";
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import UserExperiencSurvey from "./components/UserExperiencSurvey.vue";
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
            <VRow align="center">
                <VCol cols="6">
                    <h1
                        class="tiggie-sub-subtitle"
                        style="font-size: 40px !important"
                    >
                        Students
                    </h1>
                </VCol>
                <VCol cols="3">
                    <VTextField
                        rounded
                        placeholder="Search User ..."
                        density="compact"
                    />
                </VCol>
                <VCol cols="3">
                    <VSelect label="Sort By" density="compact" />
                </VCol>
            </VRow>
            <VRow cols="6">
                <VCol cols="2" class="pe-2" v-for="item in 12" :key="item">
                    <Link :href="route('view_students.show')">
                        <StudentProfile
                            :studentInfo="{
                                name: 'Wren Clark',
                                phone_number: '9123 4567',
                                img: '/images/students/studentone.svg',
                            }"
                        />
                    </Link>
                </VCol>
            </VRow>
        </VContainer>
        <UserExperiencSurvey />
    </section>
</template>

<style></style>
