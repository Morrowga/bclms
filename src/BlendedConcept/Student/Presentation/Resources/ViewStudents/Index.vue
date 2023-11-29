<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { checkPermission } from "@actions/useCheckPermission";
import { checkB2c } from "@actions/useCheckB2c";

import { usePage } from "@inertiajs/vue3";
let props = defineProps(["students"]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
import {
    onColumnFilter,
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";
let roles = [];
let selectedRole = null;
let filters = ref(null);
let filterDatas = ref([
    { title: "A-Z", value: "asc" },
    { title: "Z-A", value: "desc" },
    {
        title: "Contact Number",
        value: "contact_number",
    },
]);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <div class="d-flex justify-space-between align-center mb-10">
                <h1 class="heading ruddy-bold fs-40">
                    {{ checkB2c() ? "Children" : "Students" }}
                </h1>

                <Link
                    :href="route('teacher_students.create')"
                    v-if="checkPermission('create_teacherStudent')"
                >
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

            <div class="d-flex justify-end align-center mb-4">
                <v-spacer></v-spacer>
                <div class="search-field">
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                        variant="solo"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                    ></v-text-field>
                </div>

                <div class="sort-field">
                    <selectBox
                        v-model="filters"
                        placeholder="Sort By"
                        :datas="filterDatas"
                        density="compact"
                        item_title="title"
                        item_value="value"
                    />
                </div>
            </div>
            <VRow>
                <VCol
                    cols="2"
                    class="pe-2"
                    v-for="item in props.students.data"
                    :key="item"
                >
                    <StudentProfile
                        :studentInfo="{
                            id: item.student_id,
                            name: item.user.full_name,
                            contact_number: item.parent?.user?.contact_number,
                            img: item.user.profile_pic,
                        }"
                    />
                </VCol>
            </VRow>
            <div v-if="checkB2c()">
                <div class="d-flex justify-center my-4">
                    <Link :href="route('learning-portal')">
                        <v-btn
                            variant="flat"
                            rounded
                            color="#FF8015"
                            class="text-white"
                            >Enter Kids Mode</v-btn
                        >
                    </Link>
                </div>
            </div>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.heading {
    color: #000 !important;
}
</style>
