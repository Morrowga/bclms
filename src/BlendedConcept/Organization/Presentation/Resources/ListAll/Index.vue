<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
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
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
