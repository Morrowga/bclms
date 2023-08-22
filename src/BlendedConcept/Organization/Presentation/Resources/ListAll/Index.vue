<script setup>
// import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <div class="d-flex justify-space-between align-center mb-10">
                <h1
                    class="tiggie-sub-subtitle"
                    style="font-size: 40px !important"
                >
                    Students
                </h1>

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
            </div>
            <div class="d-flex justify-end mb-4">
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <VTextField
                    placeholder="Search User ..."
                    density="compact"
                    class="mr-4"
                />

                <VSelect
                    v-model="selectedRole"
                    label="Sort By"
                    :items="roles"
                    density="compact"
                />
            </div>
            <VRow cols="6">
                <VCol cols="2" class="pe-2" v-for="item in 12" :key="item">
                    <!-- <StudentProfile
                        :studentInfo="{
                            name: 'Wren Clark',
                            phone_number: '9123 4567',
                            img: '/images/students/studentone.svg',
                        }"
                    /> -->
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
