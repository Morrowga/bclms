<script setup>
import axios from "axios";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
let props = defineProps(["students", "flash"]);
serverPage.value = ref(props.students.current_page ?? 1);
serverPerPage.value = ref(10);

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
const userImage = (user) => {
    return user.profile_pic ?? "/images/profile/profilefive.png";
};
</script>
<template>
    <div class="header">
        <div class="d-flex justify-space-between align-center mb-4">
            <h1 class="tiggie-title">Student</h1>

            <div class="d-flex">
                <div class="search-field">
                    <VTextField
                        placeholder="Search User ..."
                        density="compact"
                        class="mr-4"
                        variant="solo"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                    />
                </div>

                <div class="sort-field">
                    <SelectBox
                        placeholder="Sort By"
                        :datas="['A-Z', 'Z-A', 'Contact Number']"
                        density="compact"
                    />
                </div>
            </div>
        </div>
        <VRow no-gutters>
            <v-col
                cols="6"
                md="3"
                v-for="student in props.students.data"
                :key="student.id"
            >
                <StudentAvatar
                    :image="userImage(student.user)"
                    :title="student?.user?.full_name"
                    :phone_number="student?.parent?.user?.contact_number"
                />
            </v-col>
        </VRow>
        <VRow class="d-flex justify-center align-center">
            <VPagination
                v-model="serverPage"
                size="small"
                :total-visible="5"
                :length="props.students.last_page"
                @next="onPageChange"
                @prev="onPageChange"
                @click="onPageChange"
                variant="outlined"
            />
        </VRow>
    </div>
</template>
