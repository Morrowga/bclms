<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage, Link } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";

let props = defineProps(["organizations", "flash", "auth"]);
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
serverPage.value = ref(props.organizations.meta.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);

const deleteOrganization = (id) => {
    deleteItem(id, "organizations");
};

const roles = [
    'Name',
    'Teacher Usage',
    'Student Usage',
    'Storage Usage',
    'Status'
];

let columns = [
    {
        label: "Organization Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Teacher Usage",
        field: "teacher_usage",
        sortable: false,
    },
    {
        label: "Student Usage",
        field: "student_usage",
        sortable: false,
    },
    {
        label: "Storage Usage",
        field: "storage_usage",
        sortable: false,
    },
    {
        label: "Status",
        field: "status",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.organizations?.meta?.per_page,
    setCurrentPage: props?.organizations?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

// const deleteOrganization = () => {
// SuccessDialog({title:"Organization has been deleted"})

// }
</script>

<template>
    <AdminLayout>
        <section>
            <h1 class="tiggie-title">Organizations</h1>
            <VCard>
                <VCardText class="d-flex align-center flex-wrap gap-4">
                    <!-- 👉 Export button -->
                    <VBtn
                        variant="tonal"
                        color="primary"
                        prepend-icon="mdi-tray-arrow-up"
                    >
                        Export
                    </VBtn>

                    <VSpacer />

                    <VTextField
                        placeholder="Search User ..."
                        density="compact"
                    />

                    <div
                        class="app-user-search-filter d-flex align-center gap-6"
                    >
                        <!-- 👉 Search  -->
                        <VSelect
                            v-model="selectedRole"
                            label="Sort By"
                            :items="roles"
                            density="compact"
                        />
                        <!-- 👉 Add user button -->
                        <Link :href="route('organizations.create')">
                            <VBtn height="40" density="compact">
                                <span class="text-capatlize text-white">
                                    Add New
                                </span>
                            </VBtn>
                        </Link>
                    </div>
                </VCardText>
                <VDivider />

                <vue-good-table
                    class="user-data-table"
                    mode="remote"
                    @column-filter="onColumnFilter"
                    :totalRows="props.organizations.meta.total"
                    :selected-rows-change="selectionChanged"
                    styleClass="vgt-table "
                    :pagination-options="options"
                    :rows="props.organizations.data"
                    :columns="columns"
                    :select-options="{
                        enabled: true,
                        selectOnCheckboxOnly: true,
                    }"
                >
                    <template #table-row="props">
                        <div v-if="props.column.field == 'plan'">
                            <span>{{ props.row?.plan?.name }}</span>
                        </div>
                        <div v-if="props.column.field == 'teacher_usage'">
                            <VProgressLinear
                                color="yellow-darken-2"
                                model-value="80"
                                :height="8"
                            ></VProgressLinear>
                            <span><span class="text-warning">8 </span>/10</span>
                        </div>
                        <div v-if="props.column.field == 'student_usage'">
                            <VProgressLinear
                                color="yellow-darken-2"
                                model-value="80"
                                :height="8"
                            ></VProgressLinear>
                            <span
                                ><span class="text-warning">82 </span>/100</span
                            >
                        </div>
                        <div v-if="props.column.field == 'storage_usage'">
                            <VProgressLinear
                                color="green"
                                model-value="80"
                                :height="8"
                            ></VProgressLinear>
                            <span
                                ><span class="text-green">321 MD </span
                                >/1GB</span
                            >
                        </div>
                        <div v-if="props.column.field == 'status'">
                            <VChip color="success" class="v-chip">
                                Active
                            </VChip>
                        </div>
                        <div v-if="props.column.field == 'action'">
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
                                            () =>
                                                router.get(
                                                    route(
                                                        'organizations.show',
                                                        { id: props.row.id }
                                                    )
                                                )
                                        "
                                    >
                                        <VListItemTitle>View</VListItemTitle>
                                    </VListItem>
                                    <VListItem
                                        @click="
                                            () =>
                                                router.get(
                                                    route(
                                                        'organizations.test.edit'
                                                    )
                                                )
                                        "
                                    >
                                        <VListItemTitle>Edit</VListItemTitle>
                                    </VListItem>
                                    <VListItem
                                        @click="
                                            deleteOrganization(props.row.id)
                                        "
                                    >
                                        <VListItemTitle>Delete</VListItemTitle>
                                    </VListItem>
                                </VList>
                            </VMenu>
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
                                    {{ props.organizations.meta.from }} to
                                    {{ props.organizations.meta.to }} of
                                    {{ props.organizations.meta.total }}
                                    entries
                                </span>
                                <div class="d-flex">
                                    <div class="d-flex align-center">
                                        <span class="me-2">Show</span>
                                        <VSelect
                                            v-model="serverPerPage"
                                            density="compact"
                                            :items="options.perPageDropdown"
                                        >
                                        </VSelect>
                                    </div>
                                    <VPagination
                                        v-model="serverPage"
                                        size="small"
                                        :total-visible="5"
                                        :length="
                                            props.organizations.meta.last_page
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

// .user-data-table table.vgt-table thead  {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.v-progress-linear {
    border-radius: 10px !important;
    color: #ffcc00 !important;
    background-color: #f4f4f4 !important;
}
</style>
