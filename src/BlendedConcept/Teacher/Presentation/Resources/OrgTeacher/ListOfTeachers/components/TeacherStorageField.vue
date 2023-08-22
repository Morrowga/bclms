<script setup>
import { ref } from "vue"
const storage = ref(200)
import EditTeacherStorage from "./EditTeacherStorage.vue"
</script>
<template>
    <VCard>
        <VRow justify="space-between" class="pa-2">
            <VCol cols="4" class="teacher-profile">
                <VImg src="/images/teacherimg.png" class="tggie-student-img" />
            </VCol>
            <VCol cols="8" class="allocated-storage">
                <div class="d-flex align-center justify-space-between">
                    <p class="tiggie-teacher-label" style="font-size:24px  !important ;">
                        Allocated Storage
                    </p>
                    <div class="d-flex">
                        <VLabel class="tiggie-teacher-label">200 MB</VLabel>
                    </div>
                </div>
                <div class="d-flex">
                    <v-sheet width="100%" height="42px" color="#BFC0C1" class="d-flex my-4 rounded overflow-hidden">
                        <v-sheet class="pt-3 pl-3" color="primary" height="100%" :width="`${50 / 100 * 100}%`"/>
                    </v-sheet>
                </div>
                <div class="d-flex gap-3 align-center ">
                    <div>
                        <VIcon icon="mdi-circle" color="teal" class="mr-3" />
                        <span>Used</span>
                    </div>
                    <div>
                        <VIcon icon="mdi-circle" class="mr-3"/>
                        <span>Available</span>
                    </div>
                </div>
            </VCol>
            <VCol cols="6">
                <p class="tiggie-subtitle">Tyler Covington</p>
            </VCol>
            <VCol cols="6" class="text-end pr-3">
                <EditTeacherStorage/>
            </VCol>
        </VRow>
    </VCard>
</template>
