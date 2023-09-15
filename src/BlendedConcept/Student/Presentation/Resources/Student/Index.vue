<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import exportFromJSON from "export-from-json";
let props = defineProps([
    "students",
    "flash",
    "auth",
    "sytemErrorMessage",
    "tenant",
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
serverPage.value = ref(props.students.meta.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);
const deleteStudent = (id) => {
    deleteItem(id, "students");
};

let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Parent’s Email",
        field: "email",
        sortable: false,
    },
    {
        label: "Type",
        field: "type",
        sortable: false,
    },
    {
        label: "Organisation / Parent",
        field: "organization",
        sortable: false,
    },
];

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.students?.meta?.per_page,
    setCurrentPage: props?.students?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
const fullName = (user) => {
    return (user?.first_name ?? "") + " " + (user?.last_name ?? "");
};
const exportUser = () => {
    const array = props.students.data;
    let data = array.map(
        ({ image, media, organizations, user, deleted_at, ...rest }) => rest
    );
    const fileName = "Export Students";
    const exportType = exportFromJSON.types.csv;
    if (data) exportFromJSON({ data, fileName, exportType });
    return;
};
</script>

<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Students</h1>
            <SystemErrorAlert
                :sytemErrorMessage="sytemErrorMessage"
                v-if="sytemErrorMessage"
            />
            <section>
                <VCard>
                    <VCardText class="d-flex flex-wrap gap-4">
                        <!-- 👉 Export button -->
                        <!-- <IconOutlineBtn icon="mdi-export-variant" title="Export" /> -->
                        <VBtn
                            variant="tonal"
                            color="primary"
                            prepend-icon="mdi-tray-arrow-up"
                            @click="exportUser()"
                        >
                            Export
                        </VBtn>

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
                                class="app-user-search-filter d-flex align-center justify-end gap-3 width-200"
                            >
                                <selectBox
                                    placeholder="Sort By"
                                    density="compact"
                                    variant="outlined"
                                    :datas="[
                                        'Name',
                                        'Email',
                                        'Contact Number',
                                        'Role',
                                        'Status',
                                    ]"
                                />
                                <!-- 👉 Add User button -->
                            </div>
                        </div>
                    </VCardText>
                    <VDivider />

                    <vue-good-table
                        class="user-data-table"
                        mode="remote"
                        @column-filter="onColumnFilter"
                        :totalRows="props.students.meta.total"
                        :selected-rows-change="selectionChanged"
                        styleClass="vgt-table "
                        :pagination-options="options"
                        :rows="props.students.data"
                        :columns="columns"
                        :select-options="{
                            enabled: true,
                            selectOnCheckboxOnly: true,
                        }"
                    >
                        <template #table-row="props">
                            <div v-if="props.column.field == 'name'">
                                <div class="d-flex flex-row gap-2">
                                    <img
                                        src="/images/defaults/avator.png"
                                        class="user-profile-image"
                                    />
                                    <span>{{ fullName(props.row?.user) }}</span>
                                </div>
                            </div>
                            <div v-if="props.column.field == 'email'">
                                <div class="d-flex flex-row gap-2">
                                    <span>{{
                                        props.row?.organizations?.[0]
                                            ?.contact_email ?? "-"
                                    }}</span>
                                </div>
                            </div>
                            <div v-if="props.column.field == 'type'">
                                <div v-if="props.row.organizations.length > 0">
                                    <span>Organization</span>
                                </div>
                                <div v-else>
                                    <span>BC</span>
                                </div>
                            </div>
                            <div v-if="props.column.field == 'organization'">
                                <div class="">
                                    <div
                                        v-if="
                                            props.row.organizations.length > 0
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('organizations.show', {
                                                    id: props.row
                                                        .organizations?.[0]?.id,
                                                })
                                            "
                                        >
                                            <span
                                                class="text-default-color cu-pointer"
                                                >{{
                                                    props.row.organizations?.[0]
                                                        ?.name ?? "-"
                                                }}</span
                                            >
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <Link
                                            :href="
                                                route('users.show', { id: 1 })
                                            "
                                            class="d-flex flex-row gap-2 text-default-color"
                                        >
                                            <img
                                                src="/images/defaults/avator.png"
                                                class="user-profile-image"
                                            />
                                            <span>
                                                {{ props.row.organization }}
                                            </span>
                                        </Link>
                                    </div>
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
                                        {{ props.students.meta.from }} to
                                        {{ props.students.meta.to }} of
                                        {{ props.students.meta.total }}
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
                                                props.students.meta.last_page
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
</style>
