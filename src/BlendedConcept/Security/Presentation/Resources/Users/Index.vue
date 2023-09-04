<script setup>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import IconOutlineBtn from "@mainRoot/components/Buttons/IconOutlineBtn.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import ImportUser from "./components/ImportUser.vue";
import { router } from "@inertiajs/core";
import { isConfirmedDialog } from "@actions/useConfirm";

import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
let props = defineProps([
    "users",
    "roles_name",
    "flash",
    "auth",
    "organizations",
]);
let flash = computed(() => usePage().props.flash);
let users = computed(() => usePage().props.auth.data.users);
let permissions = computed(() => usePage().props.auth.data.permissions);
let currentPermission = ref();
serverPage.value = ref(props.users.meta.current_page ?? 1);
serverPerPage.value = ref(10);
console.log(props.users, "hello testing");

const deleteUser = (id) => {
    deleteItem(id, "users");
};

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

let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Email",
        field: "email",
        sortable: false,
    },
    {
        label: "Organizations",
        field: "orgainzations",
        sortable: false,
    },
    {
        label: "Roles",
        field: "roles",
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
//## options for datatable
let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.users.meta.per_page,
    setCurrentPage: props.users.meta.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
const viewInfoRow = (id) => {
    router.get(route("users.show", { id: id }));
};
const setInactive = () => {
    isConfirmedDialog({
        denyButtonText: "Set Inactive",
    });
};
</script>

<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-2">Users</h1>
            <VCard>
                <VCardText class="d-flex flex-wrap gap-4">
                    <!-- 👉 Export button -->
                    <!-- <IconOutlineBtn icon="mdi-export-variant" title="Export" /> -->
                    <VBtn
                        variant="tonal"
                        color="primary"
                        prepend-icon="mdi-tray-arrow-up"
                    >
                        Export
                    </VBtn>
                    <VSpacer />
                    <VSpacer />
                    <div class="search-field">
                        <VTextField
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                            placeholder="Search Users"
                            density="compact"
                            variant="solo"
                        />
                    </div>

                    <div class="d-flex">
                        <div
                            class="app-user-search-filter d-flex align-center justify-end gap-3"
                        >
                            <selectBox
                                :datas="[
                                    'Name',
                                    'Email',
                                    'Contact Number',
                                    'Role',
                                    'Status',
                                ]"
                                placeholder="Sort By"
                                density="compact"
                                variant="outlined"
                            />
                            <!-- 👉 Add User button -->
                            <!-- <Create
                                :organizations="organizations"
                                :roles="roles_name"
                                :flash="flash"
                                v-if="permissions.includes('create_user')"
                            /> -->
                            <ImportUser />
                        </div>
                    </div>
                </VCardText>

                <VDivider />

                <vue-good-table
                    class="user-data-table"
                    mode="remote"
                    @column-filter="onColumnFilter"
                    :totalRows="props.users.meta.total"
                    styleClass="vgt-table "
                    :pagination-options="options"
                    :rows="props.users.data"
                    :columns="columns"
                >
                    <template #table-row="props">
                        <div
                            v-if="props.column.field == 'name'"
                            style="cursor: pointer"
                            @click="viewInfoRow(props.row.id)"
                        >
                            <div class="d-flex flex-row gap-2">
                                <img
                                    src="/images/defaults/avator.png"
                                    class="user-profile-image"
                                />
                                <span>Jordan Stevenson</span>
                            </div>
                        </div>

                        <div v-if="props.column.field == 'orgainzations'">
                            <p class="">-</p>
                        </div>

                        <div
                            v-if="props.column.field == 'roles'"
                            class="d-flex flex-row gap-2 align-center"
                        >
                            <img src="/images/icons/bcicons.svg" />
                            <span
                                v-for="role in props?.row?.roles"
                                :key="role?.id"
                            >
                                {{ role?.name }}
                            </span>
                        </div>
                        <div
                            v-if="props.column.field == 'status'"
                            class="flex flex-wrap"
                        >
                            <VChip color="success"> Active </VChip>

                            <VChip color="warning" v-if="true == false">
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
                                    <VListItem @click="setInactive()">
                                        <VListItemTitle
                                            >Set Inactive</VListItemTitle
                                        >
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
                                <span
                                    >Showing {{ props.users.meta.from }} to
                                    {{ props.users.meta.to }} of
                                    {{ props.users.meta.total }} entries</span
                                >
                                <div>
                                    <div class="d-flex align-center">
                                        <span class="me-2">Show</span>
                                        <VSelect
                                            v-model="serverPerPage"
                                            density="compact"
                                            :items="options.perPageDropdown"
                                        >
                                        </VSelect>
                                        <VPagination
                                            v-model="serverPage"
                                            size="small"
                                            :total-visible="5"
                                            :length="props.users.meta.last_page"
                                            @next="onPageChange"
                                            @prev="onPageChange"
                                            @click="onPageChange"
                                        />
                                    </div>
                                </div>
                            </VCol>
                        </VRow>
                    </template>
                </vue-good-table>
                <VDivider />
            </VCard>
        </VContainer>
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

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
