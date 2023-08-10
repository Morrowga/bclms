<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";

let props = defineProps(["users"]);
//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "User Types",
        field: "user_types",
        sortable: false,
    },
    {
        label: "Completion Status",
        field: "status",
        sortable: false,
    },
    {
        label: "Date Created",
        field: "date",
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
        name: "User One",
        user_types: [
            {
                title: "Organization",
            },
            {
                title: "User",
            },
        ],
        status: "success",
        date: "17/11/2023",
    },
    {
        name: "User Two",
        user_types: [
            {
                title: "Organization",
            },
            {
                title: "User",
            },
        ],
        status: "success",
        date: "17/11/2023",
    },
    {
        name: "User Three",
        user_types: [
            {
                title: "Organization",
            },
            {
                title: "User",
            },
        ],
        status: "success",
        date: "17/11/2023",
    },
];

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
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex flex-wrap gap-4">
                <!-- 👉 Export button -->
                <div class="d-flex align-center">
                    <v-btn
                        prepend-icon="mdi-export"
                        variant="outlined"
                        color="secondary"
                        >Export</v-btn
                    >
                </div>

                <VSpacer />
                <div class="d-flex">
                    <v-select
                        label="Sort By"
                        class="w-100"
                        density="compact"
                        :items="[]"
                    ></v-select>
                    <div
                        class="app-user-search-filter d-flex justify-end align-center gap-6"
                    >
                        <Link :href="route('users.index')">
                            <v-btn>Manage Surveys</v-btn>
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
                :rows="rows"
                :select-options="{
                    enabled: true,
                }"
                :pagination-options="{
                    enabled: true,
                }"
            >
                <template #table-row="dataProps">
                    <div
                        v-if="dataProps.column.field == 'user_types'"
                        class="flex flex-nowrap"
                    >
                        <VChip
                            v-for="data in dataProps.row.user_types"
                            :key="data.title"
                            size="small"
                            class="info"
                            color="info"
                            >{{ data.title }}</VChip
                        >
                    </div>
                    <div v-if="dataProps.column.field == 'status'">
                        <VProgressLinear
                            color="primary"
                            model-value="80"
                            :height="8"
                        ></VProgressLinear>
                        <span>30/50 Users </span>
                    </div>
                    <div v-if="dataProps.column.field == 'action'">
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
                                <VListItem>
                                    <VListItemTitle>View</VListItemTitle>
                                </VListItem>
                                <VListItem>
                                    <VListItemTitle>Edit</VListItemTitle>
                                </VListItem>
                                <VListItem>
                                    <VListItemTitle>Delete</VListItemTitle>
                                </VListItem>
                            </VList>
                        </VMenu>
                    </div>
                </template>
            </vue-good-table>

            <VDivider />
        </VCard>
    </section>
</template>

<style lang="scss">
.vgt-table th {
    font-size: 10pt !important;
}
.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}
.vgt-wrap__footer {
    background: rgb(var(--v-theme-surface)) !important;
    border: none;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
