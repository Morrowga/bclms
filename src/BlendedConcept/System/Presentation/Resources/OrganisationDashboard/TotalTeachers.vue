<script setup>
import axios from "axios";
import TeacherAvatar from "@mainRoot/components/TeacherAvatar/TeacherAvatar.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";

import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    datas,
    routeName,
} from "./useTeachersDatatable.js";

serverPage.value = ref(datas.value?.current_page ?? 1);
serverPerPage.value = ref(10);
routeName.value = "classrooms.getTeachers";
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
const userImage = (user) => user.image_url ?? "/images/profile/profilefive.png";
</script>
<template>
    <div class="header">
        <div class="d-flex justify-space-between align-center mb-4">
            <h1 class="tiggie-title">Teacher</h1>

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
            <!-- :route="
                                    route(
                                        'organisations-teacher.show'
                                    )
                                " -->
            <v-col
                cols="6"
                md="3"
                v-for="teacher in datas.data"
                :key="teacher.id"
            >
                <TeacherAvatar
                    class="py-2"
                    :route="
                        route('organisations-teacher.show', {
                            organisations_teacher: teacher.id,
                            route: 'home',
                        })
                    "
                    :image="userImage(teacher)"
                    :title="teacher.full_name"
                    :phone_number="teacher.contact_number"
                    :storage="`${teacher.used_storage}/ ${teacher.allocated_storage_limit}`"
                />
            </v-col>
        </VRow>
        <VRow class="d-flex justify-center align-center">
            <VPagination
                v-model="serverPage"
                size="small"
                :total-visible="5"
                :length="datas.last_page"
                @next="onPageChange"
                @prev="onPageChange"
                @click="onPageChange"
                variant="outlined"
            />
        </VRow>
    </div>
</template>
