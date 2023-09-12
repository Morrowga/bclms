<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import UpdateB2bSubscription from "./components/UpdateB2bSubscription.vue";
import { SuccessDialog } from "@actions/useSuccess";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
const props = defineProps(["subscriptions", "flash"]);

//## start datatable section
let columns = [
    {
        label: "Organization Name",
        field: "org_name",
        sortable: false,
    },
    {
        label: "Teachers",
        field: "num_teacher_license",
        sortable: false,
    },
    {
        label: "Students",
        field: "num_student_license",
        sortable: false,
    },
    {
        label: "Storage",
        field: "storage_limit",
        sortable: false,
    },
    {
        label: "Start Date",
        field: "start_date",
        sortable: false,
    },
    {
        label: "End Date",
        field: "end_date",
        sortable: false,
    },
    {
        label: "Status",
        field: "stripe_status",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

serverPage.value = ref(props.subscriptions.meta.current_page ?? 1);
serverPerPage.value = ref(10);

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
let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.subscriptions?.meta?.per_page,
    setCurrentPage: props?.subscriptions?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});
let form = useForm({
    status: "INACTIVE",
    _method: "PUT",
});
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

const items = ["Foo", "Bar"];
const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
const getInvoice = () => {
    SuccessDialog({ title: "You have successfully downloaded invoice" });
};
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex align-center flex-wrap gap-4">
                <!-- 👉 Export button -->
                <VSpacer />
                <div class="search-field">
                    <VTextField
                        placeholder="Search Organisation ..."
                        density="compact"
                        variant="solo"
                    />
                </div>
                <div class="sort-field">
                    <SelectBox
                        :datas="[
                            'Name',
                            'Teachers',
                            'Students',
                            'Storage',
                            'Start Date',
                            'End Date',
                            'Status',
                        ]"
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
                @column-filter="onColumnFilter"
                :totalRows="props.subscriptions.meta.total"
                :selected-rows-change="selectionChanged"
                :pagination-options="options"
                :rows="props.subscriptions.data"
                :columns="columns"
                :select-options="{
                    enabled: true,
                    selectOnCheckboxOnly: true,
                }"
            >
                <template #table-row="dataProps">
                    <div v-if="dataProps.column.field == 'org_name'">
                        <span>{{ dataProps.row?.organization?.name }}</span>
                    </div>
                    <div v-if="dataProps.column.field == 'num_student_license'">
                        <span>{{
                            dataProps.row?.b2b_subscription
                                ?.num_student_license ?? 0
                        }}</span>
                    </div>
                    <div v-if="dataProps.column.field == 'num_teacher_license'">
                        <span>{{
                            dataProps.row?.b2b_subscription
                                ?.num_teacher_license ?? 0
                        }}</span>
                    </div>
                    <div v-if="dataProps.column.field == 'storage_limit'">
                        <span>{{
                            dataProps.row?.b2b_subscription?.storage_limit ?? 0
                        }}</span>
                    </div>
                    <div v-if="dataProps.column.field == 'stripe_status'">
                        <div v-if="dataProps.row.stripe_status == 'ACTIVE'">
                            <VChip color="success"> Active </VChip>
                        </div>
                        <div v-else>
                            <VChip color="secondary"> Inactive </VChip>
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
                                <VListItem @click="() => {}">
                                    <UpdateB2bSubscription
                                        :key="dataProps.row.id"
                                        :subscription="dataProps.row"
                                        :flash="props.flash"
                                    />
                                </VListItem>
                                <VListItem @click="getInvoice()">
                                    <VListItemTitle>Get Invoice</VListItemTitle>
                                </VListItem>
                            </VList>
                        </VMenu>
                    </div>
                </template>
                <template #pagination-bottom>
                    <VRow class="pa-4">
                        <VCol cols="12" class="d-flex justify-space-between">
                            <span>
                                Showing
                                {{ props.subscriptions.meta.from }} to
                                {{ props.subscriptions.meta.to }} of
                                {{ props.subscriptions.meta.total }}
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
                                    :length="props.subscriptions.meta.last_page"
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

.app-user-search-filter .v-input__control {
    // height: 50px !important;
    top: 10px !important;
}

.app-user-search-filter .v-input__control .v-label.v-field-label {
    top: 10px !important;
}
</style>
