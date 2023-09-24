<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
// import Edit from "./Edit.vue";
let props = defineProps(["surveyResults"]);

//## start datatable section
let columns = [
    {
        label: "Users",
        field: "users",
        sortable: false,
    },
    // {
    //     label: "User Type",
    //     field: "user_type",
    //     sortable: false,
    // },
    {
        label: "Name of Survey",
        field: "question",
        sortable: false,
    },
    {
        label: "Date Submitted",
        field: "response_datetime",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

const items = ref([
    {
        title: "Edit",
        value: "edit",
    },
    {
        title: "Delete",
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
let filters = ref(null);
let filterDatas = ref([
    { title: "User", value: "user" },
    { title: "User Type", value: "user_type" },
    { title: "Name Of Surveys", value: "title" },
    { title: "Date Submitted", value: "created_at" },
]);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const goRoute = (route) => {
    router.get(route);
};
const deleteItem = () => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            // alert("good to go");
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Survey Results</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->
                                <div class="search-field">
                                    <VTextField
                                        placeholder="Search Surveys"
                                        density="compact"
                                        variant="solo"
                                    />
                                </div>
                                <VSpacer />
                                <VSpacer />

                                <div
                                    class="app-user-search-filter d-flex align-center justify-end gap-3 width-20"
                                >
                                    <selectBox
                                        v-model="filters"
                                        placeholder="Sort By"
                                        :datas="filterDatas"
                                        density="compact"
                                        item_title="title"
                                        item_value="value"
                                    />
                                </div>
                            </VCardText>
                            <VDivider />
                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                v-on:selected-rows-change="selectionChanged"
                                :columns="columns"
                                :rows="props.surveyResults.data"
                                :select-options="{
                                    enabled: false,
                                }"
                                :pagination-options="{ enabled: true }"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="dataProps.column.field == 'user'"
                                    >
                                        <span>{{
                                            dataProps.row.user.name
                                        }}</span>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'question'
                                        "
                                    >
                                        {{
                                            formatDate(
                                                dataProps.row.question.survey
                                                    .title
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'response_datetime'
                                        "
                                    >
                                        {{
                                            formatDate(
                                                dataProps.row.response_datetime
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VBtn
                                            variant="text"
                                            density="compact"
                                            icon="mdi-trash"
                                            class="ml-2"
                                            color="secondary"
                                            @click="deleteItem()"
                                        >
                                        </VBtn>
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
