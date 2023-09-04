<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentList from "./components/OrgAdminListOfStudent/StudentList.vue";
import TeacherList from "./components/OrgAdminListOfTeacher/TeacherList.vue";
import { ref } from "vue";
let tab = ref("student");
const changeTab = (tabName) => {
    tab.value = tabName;
};
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <div class="mb-10">
                <v-row>
                    <VCol cols="12" md="6">
                        <div class="d-flex align-center" style="gap: 10px">
                            <VBtn
                                variant="flat"
                                rounded
                                :color="
                                    tab == 'teacher' ? 'primary' : '#f6f6f6'
                                "
                                :class="
                                    tab == 'teacher'
                                        ? 'text-white'
                                        : 'text-black border-black'
                                "
                                @click="changeTab('teacher')"
                            >
                                Teacher
                            </VBtn>
                            <VBtn
                                variant="flat"
                                rounded
                                :color="
                                    tab == 'student' ? 'primary' : '#f6f6f6'
                                "
                                :class="
                                    tab == 'student'
                                        ? 'text-white'
                                        : 'text-black border-black'
                                "
                                @click="changeTab('student')"
                            >
                                Students
                            </VBtn>
                        </div>
                    </VCol>
                    <VCol cols="12" md="6" class="d-flex justify-end">
                        <div
                            v-if="tab == 'student'"
                            class="d-flex justify-end"
                            style="gap: 10px"
                        >
                            <Link
                                :href="
                                    route(
                                        'org_view_teacher_student.student.create'
                                    )
                                "
                            >
                                <VBtn
                                    variant="flat"
                                    rounded
                                    color="primary"
                                    class="text-white"
                                    prepend-icon="mdi-plus"
                                >
                                    Add
                                </VBtn>
                            </Link>

                            <VBtn
                                variant="flat"
                                rounded
                                color="primary"
                                class="text-white"
                                prepend-icon="mdi-upload"
                            >
                                Upload
                            </VBtn>
                        </div>
                        <div
                            v-if="tab == 'teacher'"
                            class="d-flex justify-end"
                            style="gap: 10px"
                        >
                            <Link :href="route('listoforgteacher')">
                                <VBtn
                                    variant="flat"
                                    rounded
                                    color="#17CAB6"
                                    class="text-white"
                                    prepend-icon="mdi-plus"
                                >
                                    Allocate Storage
                                </VBtn>
                            </Link>

                            <Link
                                :href="
                                    route(
                                        'org_view_teacher_student.teacher.create'
                                    )
                                "
                            >
                                <VBtn
                                    variant="flat"
                                    rounded
                                    color="primary"
                                    class="text-white"
                                    prepend-icon="mdi-plus"
                                >
                                    Add
                                </VBtn>
                            </Link>

                            <VBtn
                                variant="flat"
                                rounded
                                color="primary"
                                class="text-white"
                                prepend-icon="mdi-upload"
                            >
                                Upload
                            </VBtn>
                        </div>
                    </VCol>
                </v-row>
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
<style scoped>
.border-black {
    border: 1px solid #e5e5e5 !important;
}
</style>
