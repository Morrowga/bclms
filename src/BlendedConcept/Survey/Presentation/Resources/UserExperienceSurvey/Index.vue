<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { format } from 'date-fns';
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

// import Create from "./Create.vue";
// import Edit from "./Edit.vue";
let props = defineProps(['surveys']);

const formatDate = (dateString) => {
      // Parse the date string into a Date object
    const date = new Date(dateString);
    // Format the date using date-fns
    return format(date, 'dd/M/yyyy'); // Customize the format string as needed
}
//## start datatable section
let columns = [
    {
        label: "Name",
        field: "title",
        sortable: false,
    },
    {
        label: "User Types",
        field: "user_type",
        sortable: false,
    },
    {
        label: "Completion Status",
        field: "completion_status",
        sortable: false,
    },
    {
        label: "Date Created",
        field: "created_at",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

// let rows = [
//     {
//         name: "Happines Survey",
//         user_types: [
//             {
//                 name: "Organization Teachers",
//             },
//             {
//                 name: "B2C Users",
//             },
//         ],
//         completion_status: "testing",
//         date_created: "20/8/2023",
//     },
//     {
//         name: "Toy Story Feedback Survey",
//         user_types: [
//             {
//                 name: "Students",
//             },
//         ],
//         completion_status: "testing",
//         date_created: "20/8/2023",
//     },
//     {
//         name: "Website Experience Survey",
//         user_types: [
//             {
//                 name: "Organization Teachers",
//             },
//             {
//                 name: "B2C Users",
//             },
//         ],
//         completion_status: "testing",
//         date_created: "20/8/2023",
//     },
//     {
//         name: "Teacher Experience Survey",
//         user_types: [
//             {
//                 name: "Organization Teacher",
//             },
//             {
//                 name: "B2C Users",
//             },
//         ],
//         completion_status: "testing",
//         date_created: "20/8/2023",
//     },
//     {
//         name: "Food Survey",
//         user_types: [
//             {
//                 name: "Organization Teacher",
//             },
//             {
//                 name: "B2C Users",
//             },
//         ],
//         completion_status: "testing",
//         date_created: "20/8/2023",
//     },
// ];

const items = ref([
    {
        title: "User Type",
        value: "edit",
    },
    {
        title: "Date",
        value: "delete",
    },
]);

const isDiability = ref(false);
const isEditDiability = ref(false);

//## truncatedText
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 30) {
            return text;
        } else {
            return text?.substring(0, 30) + "...";
        }
    }
};

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
const deleteOrganization = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes, delete it!",
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">User Surveys</h1>
            <VRow justify="end">
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText
                                class="d-flex flex-wrap gap-4 align-center"
                            >
                                <VSpacer />
                                <div class="search-field">
                                    <VTextField
                                        @keyup.enter="searchItems"
                                        placeholder="Search Surveys"
                                        density="compact"
                                        variant="solo"
                                    />
                                </div>

                                <div class="d-flex">
                                    <div
                                        class="app-user-search-filter d-flex align-center justify-end gap-3"
                                    >
                                        <!-- 👉 Add User button -->
                                        <Create
                                            :organizations="organizations"
                                            :roles="roles_name"
                                            :flash="flash"
                                        />
                                        <SelectBox
                                            placeholder="Sort By"
                                            density="compact"
                                            :datas="[
                                                'Name',
                                                'Date Created',
                                                'Completion Status',
                                            ]"
                                        ></SelectBox>
                                        <Link
                                            :href="
                                                route(
                                                    'userexperiencesurvey.create'
                                                )
                                            "
                                        >
                                            <VBtn>
                                                <span
                                                    class="text-white pl-4 pr-4"
                                                >
                                                    Add Survey
                                                </span>
                                            </VBtn>
                                        </Link>
                                    </div>
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                v-on:selected-rows-change="selectionChanged"
                                :columns="columns"
                                :rows="props.surveys.data"
                                :select-options="{
                                    enabled: false,
                                }"
                                :pagination-options="{ enabled: true }"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="dataProps.column.field == 'title'"
                                    >
                                        <Link
                                            class="text-secondary"
                                            :href="
                                                route(
                                                    'userexperiencesurvey.create'
                                                )
                                            "
                                        >
                                            <span>{{
                                                dataProps.row.title
                                            }}</span>
                                        </Link>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'user_type'
                                        "
                                    >
                                    <!-- v-for="user_type in dataProps.row
                                                .user_type" -->
                                            <!-- :key="user_type" -->
                                        <v-chip
                                            class="ma-2"
                                            color="primary"
                                            size="small"
                                            >
                                            {{dataProps.row.user_type}}
                                        </v-chip>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'completion_status'
                                        "
                                    >
                                        <VProgressLinear
                                            color="yellow-darken-2"
                                            class="custom-progress"
                                            model-value="80"
                                            :height="8"
                                        >
                                        </VProgressLinear>
                                        <span
                                            ><span class="text-warning">8 </span
                                            >/10</span
                                        >
                                        Users
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'created_at'
                                        "
                                    >
                                       {{  formatDate(dataProps.row.created_at) }}
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VMenu location="end">
                                            <template #activator="{ props }">
                                                <VIcon
                                                    v-bind="props"
                                                    size="24"
                                                    icon="mdi-dots-horizontal"
                                                    color="black"
                                                    class="mt-n4"
                                                />
                                            </template>
                                            <VList>
                                                <VListItem
                                                    @click="
                                                        deleteOrganization(
                                                            dataProps.row.id
                                                        )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Delete</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem
                                                    @click="
                                                        router.get(
                                                            route(
                                                                'survey_results.view'
                                                            )
                                                        )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Result</VListItemTitle
                                                    >
                                                </VListItem>
                                            </VList>
                                        </VMenu>
                                    </div>
                                </template>
                            </vue-good-table>

                            <VDivider />
                        </VCard>
                    </section>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.custom-progress {
    width: 70%;
}
</style>
