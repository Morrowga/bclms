<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
let props = defineProps([
    "classrooms",
    "students",
    "teachers",
    "flash",
    "auth",
]);
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
let flash = computed(() => usePage().props.flash);
serverPage.value = ref(props.classrooms.meta.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);
import Create from "./Create.vue";
import Edit from "./Edit.vue";

const deleteClassRoom = (id) => {
    deleteItem(id, "classrooms");
};

let columns = [
    {
        label: "NAME",
        field: "name",
        sortable: false,
    },
    {
        label: "TEACHER",
        field: "teacher",
        sortable: false,
    },
    {
        label: "Contact Number",
        field: "contact_number",
        sortable: false,
    },
    {
        label: "Number Of Student",
        field: "nofstudent",
        sortable: false,
    },

    {
        label: "ACTION",
        field: "action",
        sortable: false,
    },
];

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.classrooms?.meta?.per_page,
    setCurrentPage: props?.classrooms?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
</script>

<template>
    <AdminLayout>
        <section>
            <VCard>
                <VCardText class="d-flex flex-wrap gap-4">
                    <!-- 👉 Export button -->
                    <VBtn
                        prepend-icon="mdi-export"
                        variant="outlined"
                        color="secondary"
                        >Export</VBtn
                    >
                    <VSpacer />
                    <div
                        class="app-user-search-filter d-flex align-center gap-6"
                    >
                        <!-- 👉 Search  -->
                        <VTextField
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                            placeholder="Search Student"
                            density="compact"
                        />
                        <!-- 👉 Add User button -->
                        <Create
                            :flash="flash"
                            :students="students"
                            :teachers="teachers"
                            v-if="permissions.includes('create_classroom')"
                        />
                    </div>
                </VCardText>
                <VDivider />

                <vue-good-table
                    class="user-data-table"
                    mode="remote"
                    @column-filter="onColumnFilter"
                    :totalRows="props.classrooms.meta.total"
                    :selected-rows-change="selectionChanged"
                    styleClass="vgt-table "
                    :pagination-options="options"
                    :rows="props.classrooms.data"
                    :columns="columns"
                    :select-options="{
                        enabled: true,
                        selectOnCheckboxOnly: true,
                    }"
                >
                    <template #table-row="props">
                        <div v-if="props.column.field == 'teacher'">
                            <VChip color="primary">
                                {{ props.row.teacher.name }}
                            </VChip>
                        </div>
                        <div v-if="props.column.field == 'contact_number'">
                            <span>
                                {{ props.row.teacher.contact_number }}
                            </span>
                        </div>
                         <div v-if="props.column.field == 'nofstudent'">
                            <span>
                                {{ props.row.students.length }}
                            </span>
                        </div>
                        <div v-if="props.column.field == 'action'">
                            <div class="d-flex">
                                <Edit
                                    :students="students"
                                    :teachers="teachers"
                                    :classroom="props.row"
                                    :flash="flash"
                                    v-if="
                                        permissions.includes('edit_classroom')
                                    "
                                />
                                <VBtn
                                    v-if="
                                        permissions.includes('delete_classroom')
                                    "
                                    density="compact"
                                    icon="mdi-trash"
                                    class="ml-2"
                                    color="secondary"
                                    variant="text"
                                    @click="deleteClassRoom(props.row.id)"
                                >
                                </VBtn>
                            </div>
                        </div>
                    </template>
                    <template #pagination-bottom>
                        <VRow class="pa-4">
                            <VCol
                                cols="12"
                                class="d-flex justify-space-between"
                            >
                                <span>
                                    Showing
                                    {{ props.classrooms.meta.from }} to
                                    {{ props.classrooms.meta.to }} of
                                    {{ props.classrooms.meta.total }}
                                    entries
                                </span>
                                <div class="d-flex">
                                    <div class="d-flex align-center">
                                        <span class="me-2">Show</span>
                                        <VSelect
                                            v-model="serverPerPage"
                                            density="compact"
                                            :items="options.perPageDropdown"
                                        ></VSelect>
                                    </div>
                                    <VPagination
                                        v-model="serverPage"
                                        size="small"
                                        :total-visible="5"
                                        :length="
                                            props.classrooms.meta.last_page
                                        "
                                        @next="onPageChange"
                                        @prev="onPageChange"
                                        @click="onPageChange"
                                    />
                                </div>
                            </VCol>
                        </VRow>
                    </template>
                </vue-good-table>
                <VDivider />
            </VCard>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.text-capitalize {
    text-transform: capitalize;
}
.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}
.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.user-data-table table.vgt-table thead th {
    background: rgb(var(--v-theme-surface)) !important;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
