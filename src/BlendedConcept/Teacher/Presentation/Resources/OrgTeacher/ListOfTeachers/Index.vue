<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherStorageField from "./components/TeacherStorageField.vue";
</script>

<template>
    <AdminLayout>
        <VContainer>
            <div class="fixed-progressbar">
                <div class="d-flex justify-space-between align-center pt-10">
                    <h1 class="tiggie-teacher-title">
                        Allocate Teacher’s Storage
                    </h1>
                    <Link :href="route('org_view_teacher_student.index')">
                        <VBtn
                            class="text-primary"
                            color="#e8e9ed"
                            width="200px"
                            variant="flat"
                            rounded
                        >
                            Back
                        </VBtn>
                    </Link>
                </div>
                <div
                    class="d-flex justify-space-between align-center mt-3 pt-3"
                >
                    <h1 class="tiggie-teacher-subtitle fs-30">
                        Total Storage Usage
                    </h1>
                    <div class="tiggie-subtitle">
                        1.23GB of 2GB allocated to teachers,130MB available
                    </div>
                </div>
                <div class="d-flex justify-space-between align-center">
                    <v-sheet
                        width="100%"
                        height="42px"
                        color="#BFC0C1"
                        class="d-flex my-4 rounded overflow-hidden"
                    >
                        <v-sheet
                            color="primary"
                            height="100%"
                            :width="`${(20 / 100) * 100}%`"
                        />
                        <v-sheet
                            v-if="10"
                            color="teal"
                            height="100%"
                            :width="`${(30 / 100) * 100}%`"
                        />
                        <v-sheet
                            v-if="10"
                            color="sun-yellow"
                            height="100%"
                            :width="`${(30 / 100) * 100}%`"
                        />
                    </v-sheet>
                </div>
                <VRow>
                    <VCol cols="3">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="primary"
                                class="mr-2"
                            />
                            <span class="t-black">Organization Resources</span>
                        </div>
                    </VCol>
                    <VCol cols="3">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="teal"
                                class="mr-2"
                            />
                            <span class="t-black">Teacher Resources</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="sun-yellow"
                                class="mr-2"
                            />
                            <span class="t-black"
                                >Allocated to teachers but not in use</span
                            >
                        </div>
                    </VCol>
                </VRow>
            </div>
            <div class="padding-block"></div>

            <VRow>
                <VCol cols="6" v-for="item in 6">
                    <TeacherStorageField />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.fixed-progressbar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 100%;
    background-color: #fff; /* You can change the background color as needed */
    z-index: 1000; /* Adjust the z-index as necessary */
    padding: 10px; /* Add padding to the header if desired */
    padding-right: 165px;
    padding-left: 165px;
}
.padding-block {
    height: 250px;
}
</style>
