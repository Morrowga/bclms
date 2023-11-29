<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentList from "./components/OrgAdminListOfStudent/StudentList.vue";
import TeacherList from "./components/OrgAdminListOfTeacher/TeacherList.vue";
import { ref } from "vue";
import { checkPermission } from "@actions/useCheckPermission";
import ImportUser from "./components/ImportUser.vue";

let tab = ref("teacher");
let props = defineProps([
    "teachers",
    "students",
    "total_teachers",
    "total_students",
    "organisation",
]);

const changeTab = (tabName) => {
    tab.value = tabName;
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="mb-10">
                <div class="d-flex justify-space-between">
                    <div>
                        <div class="d-flex align-center">
                            <VBtn
                                class="mr-2"
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
                    </div>
                    <div class="d-flex justify-end">
                        <div
                            v-if="tab == 'student'"
                        >
                            <Link
                                v-if="
                                    checkPermission('create_organisationUser')
                                "
                                :href="route('organisations-student.create')"
                            >
                                <VBtn
                                    variant="flat"
                                    rounded
                                    height="40"
                                    color="primary"
                                    class="text-white mr-2"
                                    prepend-icon="mdi-plus"
                                >
                                    Add
                                </VBtn>
                            </Link>

                            <ImportUser :organisation="props.organisation" />
                        </div>
                        <div
                            v-if="tab == 'teacher'"
                        >
                            <Link :href="route('listoforgteacher')">
                                <VBtn
                                    variant="flat"
                                    rounded
                                    color="#17CAB6"
                                    class="text-white mr-2"
                                    prepend-icon="mdi-plus"
                                    height="40"
                                >
                                    Allocate Storage
                                </VBtn>
                            </Link>

                            <Link
                                v-if="
                                    checkPermission('create_organisationUser')
                                "
                                :href="route('organisations-teacher.create')"
                            >
                                <VBtn
                                    variant="flat"
                                    rounded
                                    color="primary"
                                    class="text-white mr-2"
                                    prepend-icon="mdi-plus"
                                >
                                    Add
                                </VBtn>
                            </Link>
                            <ImportUser :organisation="props.organisation" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-list">
                <section v-if="tab == 'student'">
                    <StudentList
                        :students="props.students"
                        :total_students="total_students"
                    />
                </section>
                <section v-if="tab == 'teacher'">
                    <TeacherList
                        :data="props.teachers"
                        :total_teachers="total_teachers"
                    />
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
