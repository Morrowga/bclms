<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentList from "./components/StudentList.vue";
import TeacherList from "./components/TeacherList.vue";
import { ref } from "vue";
let tab = ref("student");
const changeTab = (tabName) => {
    tab.value = tabName;
};
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <div class="d-flex justify-space-between align-center mb-10">
                <div class="d-flex align-center" style="gap: 10px">
                    <v-btn
                        variant="flat"
                        rounded
                        :color="tab == 'student' ? 'primary' : 'secondary'"
                        class="text-white"
                        @click="changeTab('student')"
                    >
                        Students
                    </v-btn>
                    <v-btn
                        variant="flat"
                        rounded
                        :color="tab == 'teacher' ? 'primary' : 'secondary'"
                        class="text-white"
                        @click="changeTab('teacher')"
                    >
                        Teacher
                    </v-btn>
                </div>
                <div class="d-flex align-center" style="gap: 10px">
                    <v-btn
                        variant="flat"
                        rounded
                        color="#17CAB6"
                        class="text-white"
                        prepend-icon="mdi-plus"
                    >
                        Allocate Storage
                    </v-btn>

                    <Link :href="route('view_students.create')">
                        <v-btn
                            variant="flat"
                            rounded
                            color="primary"
                            class="text-white"
                            prepend-icon="mdi-plus"
                        >
                            Add
                        </v-btn>
                    </Link>

                    <v-btn
                        variant="flat"
                        rounded
                        color="primary"
                        class="text-white"
                        prepend-icon="mdi-upload"
                    >
                        Upload
                    </v-btn>
                </div>
            </div>
            <div class="tab-list">
                <section v-if="tab == 'student'">
                    <StudentList />
                </section>
                <section v-if="tab == 'teacher'">
                    <TeacherList />
                </section>
            </div>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
