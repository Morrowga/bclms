<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { defineProps } from "vue";
import UpdateSubscrptionStatus from "./components/UpdateSubscrptionStatus.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { SuccessDialog } from "@actions/useSuccess";

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
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
//## start datatable section
let columns = [
    {
        label: "User",
        field: "user",
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
        label: "Plan",
        field: "plan",
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
const getInvoice = () => {
    SuccessDialog({ title: "You have successfully downloaded invoice" });
};

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const fullName = (user) => {
    return (user?.first_name ?? "") + " " + (user?.last_name ?? "");
};
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex justify-end align-center flex-wrap gap-4">
                <!-- 👉 Export button -->

                <div class="search-field">
                    <VTextField
                        placeholder="Search User ..."
                        density="compact"
                        variant="solo"
                    />
                </div>
                <div class="sort-field">
                    <!-- 👉 Search  -->
                    <!-- <VSelect
                            v-model="selectedRole"
                            label="Sort By"
                            :items="roles"
                            density="compact"
                        /> -->
                    <SelectBox
                        :datas="[
                            'User',
                            'Start Date',
                            'End Date',
                            'Plan',
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
                    <div v-if="dataProps.column.field === 'user'">
                        <div class="d-flex flex-row gap-2">
                            <img
                                src="/images/defaults/avator.png"
                                class="user-profile-image"
                            />
                            <span>{{
                                fullName(dataProps.row.b2c_subscription?.user)
                            }}</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'plan'">
                        <span>{{
                            dataProps.row.b2c_subscription?.plan?.name
                        }}</span>
                    </div>
                    <div v-if="dataProps.column.field == 'status'">
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
                                <VListItem
                                    @click="() => {}"
                                    v-if="user_role == 'BC Superadmin'"
                                >
                                    <UpdateSubscrptionStatus
                                        :subscription="dataProps.row"
                                        :key="dataProps.row.id"
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
