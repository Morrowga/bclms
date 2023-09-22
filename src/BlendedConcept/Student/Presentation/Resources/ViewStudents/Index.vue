<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
let props = defineProps(['students']);

let roles = [];
let selectedRole = null;
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <div class="d-flex justify-space-between align-center mb-10">
                <h1 class="tiggie-sub-subtitle fs-40">Students</h1>

                <!-- <Link :href="route('teacher_students.create')">
                    <v-btn
                        variant="flat"
                        rounded
                        color="primary"
                        class="text-white"
                        prepend-icon="mdi-plus"
                    >
                        Add
                    </v-btn>
                </Link> -->
            </div>
            <div class="d-flex justify-end mb-4 align-center">
                <v-spacer></v-spacer>

                <div class="search-field">
                    <VTextField
                        placeholder="Search User ..."
                        density="compact"
                        class="mr-4"
                        variant="solo"
                    />
                </div>
                <div class="d-flex">
                    <div
                        class="app-user-search-filter d-flex align-center justify-end gap-3 width-200"
                    >
                        <selectBox
                            placeholder="Sort By"
                            density="compact"
                            variant="outlined"
                            :datas="[
                                'Name',
                                'Email',
                                'Contact Number',
                                'Role',
                                'Status',
                            ]"
                        />
                        <!-- 👉 Add User button -->
                    </div>
                </div>
            </div>
            <VRow cols="6">
                <VCol cols="2" class="pe-2" v-for="item in props.students.data" :key="item">
                    <StudentProfile
                        :studentInfo="{
                            id: item.student_id,
                            name: item.user.full_name,
                            contact_number: item.user.contact_number,
                            img: item.user.profile_pic,
                        }"
                    />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
