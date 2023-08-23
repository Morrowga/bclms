<script setup>
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
</script>

<template>
    <section>
        <SystemErrorAlert sytemErrorMessage="Something is wrong" v-if="true" />
        <SystemErrorAlert sytemErrorMessage="Something is wrong" v-if="true" />
        <SystemErrorAlert sytemErrorMessage="Something is wrong" v-if="true" />
        <VContainer style="width: 80%; margin: 0 auto">
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
                    <StudentAvatar
                        image="/images/student.png"
                        title="Wren Clark"
                        phone_number="9111 1112"
                        route="#"
                    />
                </VCol>
            </VRow>
        </VContainer>
        <UserExperiencSurvey />
    </section>
</template>

<style></style>
