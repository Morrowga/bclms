<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage, Link } from "@inertiajs/vue3";
import { computed, defineProps, watch } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import { router } from "@inertiajs/core";
import { SuccessDialog } from "@actions/useSuccess";
import { isConfirmedDialog } from "@actions/useConfirm";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

let props = defineProps(["organisations", "flash", "auth"]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
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
serverPage.value = ref(props.organisations.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);
let filters = ref(null);

const roles = [
    "Name",
    "Teacher Usage",
    "Student Usage",
    "Storage Usage",
    "Status",
];

let columns = [
    {
        label: "Organisation Name",
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
    perPage: props.organisations?.per_page,
    setCurrentPage: props?.organisations?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
let selectionChanged = () => {};
let selectedRole = ref("");
const deleteOrganisation = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(route("organisations.destroy", id), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
            });
        },
    });
};
const maxTeacher = (organisation) => {
    return (
        organisation?.subscription?.b2b_subscription?.num_teacher_license ?? 0
    );
};
const maxStudent = (organisation) => {
    return (
        organisation?.subscription?.b2b_subscription?.num_student_license ?? 0
    );
};
const maxStorage = (organisation) => {
    return organisation?.subscription?.b2b_subscription?.storage_limit ?? 0;
};
const getPrice = (organisation) => {
    return organisation?.subscription?.stripe_price * 1000 ?? 0;
};
let filterDatas = ref([
    { title: "Name", value: "name" },
    { title: "Teacher Usage", value: "teacher_usage" },
    { title: "Student Usage", value: "student_usage" },
    { title: "Storage Usage", value: "storage_usage" },
    { title: "Status", value: "status" },
]);

watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
const showInfo = (e) => {
    // console.log(e);
    router.get(route("organisations.show", e.row.id));
};
</script>

<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title">Organisations</h1>
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

                    <div class="search-field">
                        <VTextField
                            placeholder="Search User ..."
                            density="compact"
                            variant="solo"
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                        />
                    </div>

                    <div
                        class="app-user-search-filter d-flex align-center gap-6"
                    >
                        <!-- 👉 Search  -->
                        <SelectBox
                            v-model="filters"
                            placeholder="Sort By"
                            :datas="filterDatas"
                            density="compact"
                            item_title="title"
                            item_value="value"
                        />
                        <!-- 👉 Add user button -->
                        <Link :href="route('organisations.create')">
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
                    :totalRows="props.organisations.total"
                    :pagination-options="options"
                    @column-filter="onColumnFilter"
                    :selected-rows-change="selectionChanged"
                    styleClass="vgt-table "
                    :rows="props.organisations.data"
                    :columns="columns"
                    :select-options="{
                        enabled: true,
                        selectOnCheckboxOnly: true,
                    }"
                    @row-click="showInfo"
                >
                    <template #table-row="props">
                        <div v-if="props.column.field == 'name'">
                            <span>{{ props.row?.name }}</span>
                        </div>
                        <div v-if="props.column.field == 'plan'">
                            <span>{{ props.row?.plan?.name }}</span>
                        </div>
                        <div v-if="props.column.field == 'teacher_usage'">
                            <VProgressLinear
                                color="yellow-darken-2"
                                :model-value="props.row?.teachers_count"
                                :max="maxTeacher(props.row)"
                                :height="8"
                            ></VProgressLinear>
                            <span
                                ><span class="text-warning"
                                    >{{ props.row?.teachers_count }} </span
                                >/{{ maxTeacher(props.row) }}</span
                            >
                        </div>
                        <div v-if="props.column.field == 'student_usage'">
                            <VProgressLinear
                                color="yellow-darken-2"
                                :model-value="props.row?.all_students_count"
                                :max="maxStudent(props.row)"
                                :height="8"
                            ></VProgressLinear>
                            <span
                                ><span class="text-warning"
                                    >{{ props.row?.all_students_count }} </span
                                >/{{ maxStudent(props.row) }}</span
                            >
                        </div>
                        <div v-if="props.column.field == 'storage_usage'">
                            <VProgressLinear
                                color="green"
                                :model-value="321"
                                :max="maxStorage(props.row)"
                                :height="8"
                            ></VProgressLinear>
                            <span
                                ><span class="text-green"
                                    >{{ props.row.used_storage }} MB </span
                                >/{{ maxStorage(props.row) }} MB</span
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
                                <VList v-if="user_role == 'BC Staff'">
                                    <VListItem
                                        @click="
                                            () =>
                                                router.get(
                                                    route(
                                                        'organisations.addSubscription',
                                                        props.row.id
                                                    )
                                                )
                                        "
                                    >
                                        <VListItemTitle
                                            >Add Subscription</VListItemTitle
                                        >
                                    </VListItem>
                                </VList>
                                <VList v-else>
                                    <VListItem
                                        @click="
                                            () =>
                                                router.get(
                                                    route(
                                                        'organisations.edit',
                                                        props.row.id
                                                    )
                                                )
                                        "
                                    >
                                        <VListItemTitle>Edit</VListItemTitle>
                                    </VListItem>
                                    <VListItem
                                        @click="
                                            deleteOrganisation(props.row.id)
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
                                    {{ props.organisations.from }} to
                                    {{ props.organisations.to }} of
                                    {{ props.organisations.total }}
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
                                        :length="props.organisations.last_page"
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

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.v-progress-linear {
    border-radius: 10px !important;
    color: #ffcc00 !important;
    background-color: #f4f4f4 !important;
}
</style>
