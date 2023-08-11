<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
let props = defineProps(["students", "flash", "auth", 'sytemErrorMessage', 'tenant']);
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
import Create from "./Create.vue";
import Edit from "./Edit.vue";

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
    }
];

let rows = [
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Blended Concept",
        isOrganization: true,
    },
    {
        name: "Farhan Lim Mei Ling",
        email: "estelle.Bailey10@gmail.com",
        type: "Organization",
        organization: "Anderson Liew",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    },
    {
        name: "Tan Wei Jie",
        email: "susanna.Lind57@gmail.com",
        type: "Organization",
        organization: "Phoon Kai Ming",
        isOrganization: false,
    }
]

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.students?.meta?.per_page,
    setCurrentPage: props?.students?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

const items = ref([
    {
        title: 'name',
        value: 'Name',
    },
    {
        title: 'Type',
        value: 'type',
    },
    {
        title: "Organization's Parent",
        value: 'organazation_parent',
    },
    {
        title : "Parent's Email",
        value : "parent_email"
    }

])

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
</script>


<template>
    <AdminLayout>
        <h1 class="tiggie-title mb-4">Students</h1>
        <SystemErrorAlert :sytemErrorMessage="sytemErrorMessage" v-if="sytemErrorMessage" />
        <section>
            <VCard>
                <VCardText class="d-flex flex-wrap gap-4">
                    <!-- 👉 Export button -->
                    <VBtn variant="outlined" color="secondary">
                        <VIcon color="primary" icon="mdi-export" size="20" style="transform: rotate(270deg);"></VIcon>
                        <span class="text-primary pl-4">Export</span>
                    </VBtn>
                    <VSpacer />
                    <div class="app-user-search-filter d-flex align-center gap-6">
                        <!-- 👉 Search  -->
                        <VTextField @keyup.enter="searchItems" v-model="serverParams.search" placeholder="Search Student"
                            density="compact" />
                        <!-- 👉 Add User button -->
                        <VSelect :items="items" rounded="100%" density="compact"/>
                    </div>
                </VCardText>
                <VDivider />

                <vue-good-table class="user-data-table" mode="remote" @column-filter="onColumnFilter"
                    :totalRows="props.students.meta.total" :selected-rows-change="selectionChanged" styleClass="vgt-table "
                    :pagination-options="options" :rows="rows" :columns="columns" :select-options="{
                        enabled: true,
                        selectOnCheckboxOnly: true,
                    }">
                    <template #table-row="props">
                            <div v-if="props.column.field == 'name'">
                                <div class="d-flex flex-row gap-2">
                                        <img src="/images/defaults/avator.png" class="user-profile-image"/>
                                        <span>{{ props.row.name }}</span>
                                </div>
                            </div>
                            <div v-if="props.column.field == 'organization'">
                                <div class="">
                                    <div v-if="props.row.isOrganization">
                                        <p>{{ props.row.organization }}</p>
                                    </div>
                                    <div v-else class="d-flex flex-row gap-2">
                                        <img src="/images/defaults/avator.png" class="user-profile-image"/>
                                        <span>{{ props.row.organization }}</span>
                                    </div>
                                </div>
                            </div>
                    </template>
                    <template #pagination-bottom>
                        <VRow class="pa-4">
                            <VCol cols="12" class="d-flex justify-space-between">
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
                                        <VSelect v-model="serverPerPage" density="compact" :items="options.perPageDropdown">
                                        </VSelect>
                                    </div>
                                    <VPagination v-model="serverPage" size="small" :total-visible="5"
                                        :length="props.students.meta.last_page" @next="onPageChange" @prev="onPageChange"
                                        @click="onPageChange" />
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
