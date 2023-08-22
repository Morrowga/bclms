<script setup>
import TeacherProfileCard from "./TeacherProfileCard.vue";
</script>
<template>
    <div>
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
            <VCol
                cols="12"
                sm="6"
                md="3"
                lg="2"
                class="pe-2"
                v-for="item in 12"
                :key="item"
            >
                <TeacherProfileCard
                    :studentInfo="{
                        name: 'Wren Clark',
                        phone_number: '9123 4567',
                        img: '/images/students/studentone.svg',
                    }"
                />
            </VCol>
        </VRow>
    </div>
</template>
<style scoped></style>
