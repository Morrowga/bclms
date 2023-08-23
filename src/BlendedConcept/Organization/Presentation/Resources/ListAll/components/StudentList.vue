<script setup>
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
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
                <StudentAvatar
                    image="/images/student.png"
                    title="Wren Clark"
                    phone_number="9111 1112"
                    route="#"
                />
            </VCol>
        </VRow>
        <div class="d-flex justify-center">
            <Pagination />
        </div>
    </div>
</template>
<style scoped></style>
