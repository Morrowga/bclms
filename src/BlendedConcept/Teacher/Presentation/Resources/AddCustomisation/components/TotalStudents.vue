<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
let props = defineProps(["users"]);
//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Education Level",
        field: "education_level",
        sortable: false,
    },
    {
        label: "Age",
        field: "age",
        sortable: false,
    },
    {
        label: "Disability Type",
        field: "disability_types",
        sortable: false,
    },
];

let rows = [
    {
        image: "/images/studentavatar.png",
        name: "User One",
        disability_types: [
            {
                title: "Organisation",
            },
            {
                title: "User",
            },
        ],
        education_level: "K1",
        age: "9",
    },
    {
        image: "/images/studentavatar.png",
        name: "User Two",
        disability_types: [
            {
                title: "Organisation",
            },
            {
                title: "User",
            },
        ],
        education_level: "K1",
        age: "10",
    },
    {
        image: "/images/studentavatar.png",
        name: "User Three",
        disability_types: [
            {
                title: "Organisation",
            },
            {
                title: "User",
            },
        ],
        education_level: "K2",
        age: "12",
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
                        v-if="dataProps.column.field == 'name'"
                        class="d-flex flex-nowrap align-center gap-20"
                    >
                        <img :src="dataProps.row.image" class="std-img" />
                        <span>{{ dataProps.row.name }}</span>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'disability_types'"
                        class="flex flex-nowrap"
                    >
                        <div
                            v-for="data in dataProps.row.disability_types"
                            :key="data.title"
                            class="chip mr-2"
                        >
                            <div class="chip-content">{{ data.title }}</div>
                        </div>
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
            <div class="d-flex justify-center">
                <Pagination />
            </div>
        </VCard>
    </section>
</template>

<style scoped>
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
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
}

.chip-content {
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
.std-img {
    width: 60px;
    height: 60px;
}
</style>
