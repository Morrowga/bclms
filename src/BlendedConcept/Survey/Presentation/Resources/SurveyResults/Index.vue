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

// import Edit from "./Edit.vue";
let props = defineProps();

//## start datatable section
let columns = [
    {
        label: "Users",
        field: "users",
        sortable: false,
    },
    {
        label: "User Type",
        field: "user_type",
        sortable: false,
    },
    {
        label: "Name of Survey",
        field: "name_of_survey",
        sortable: false,
    },
    {
        label: "Date Submitted",
        field: "date_submitted",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

let rows = [
    {
        users: "Albert Leon",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
    },
    {
        users: "Alic",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
    },
    {
        users: "John",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
    },
    {
        users: "Miran",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
    },
    {
        users: "Ellar",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
    },
    {
        users: "Manic",
        user_type: "Student",
        name_of_survey: "Happiness survey",
        date_submitted: "20/09/2023",
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

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const goRoute = (route) => {
    router.get(route);
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
                                <VTextField
                                    placeholder="Search Users"
                                    density="compact"
                                />
                                <VSpacer />
                                <VSpacer />

                                <div
                                    class="app-user-search-filter d-flex align-center justify-end gap-3"
                                    style="width: 20%"
                                >
                                    <selectBox
                                        :datas="[]"
                                        placeholder="Sort By"
                                        density="compact"
                                        variant="solo"
                                    />
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                v-on:selected-rows-change="selectionChanged"
                                :columns="columns"
                                :rows="rows"
                                :select-options="{
                                    enabled: false,
                                }"
                                :pagination-options="{ enabled: true }"
                            >
                                <template #table-row="dataProps">
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
