<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { defineProps } from "vue";
import UpdateSubscrptionStatus from "./components/UpdateSubscrptionStatus.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { SuccessDialog } from "@actions/useSuccess";

let props = defineProps();

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

let rows = [
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: "02/08/23",
        plan: 1,
        status: 1,
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: "02/08/23",
        plan: 0,
        status: 0,
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: "02/08/23",
        plan: 1,
        status: 1,
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: "02/08/23",
        plan: 0,
        status: 1,
    },
];

const items = ["Foo", "Bar"];
const getInvoice = () => {
    SuccessDialog({ title: "You have successfully downloaded invoice" });
};
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
                v-on:selected-rows-change="selectionChanged"
                :columns="columns"
                :rows="rows"
                :select-options="{
                    enabled: true,
                }"
                :pagination-options="{ enabled: true }"
            >
                <template #table-row="dataProps">
                    <div v-if="dataProps.column.field === 'user'">
                        <div class="d-flex flex-row gap-2">
                            <img
                                src="/images/defaults/avator.png"
                                class="user-profile-image"
                            />
                            <span>Jordan Stevenson</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'plan'">
                        <div class="d-flex flex-row align-center gap-2">
                            <span
                                v-if="dataProps.row.plan"
                                class="d-flex flex-row justify-center align-center gap-2"
                            >
                                <img src="/images/icons/freeplan.svg" />
                                <span>free plan</span>
                            </span>
                            <span
                                v-else
                                class="d-flex flex-row align-center gap-2"
                            >
                                <img src="/images/icons/proplan.svg" />
                                <span>pro plan</span>
                            </span>
                            <span>{{ dataProps.column.field }}</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'status'">
                        <div v-if="dataProps.row.status">
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
                                    @click="
                                        () =>
                                            router.get(
                                                route('organizations.show', {
                                                    id: props.row.id,
                                                })
                                            )
                                    "
                                >
                                    <UpdateSubscrptionStatus />
                                </VListItem>
                                <VListItem @click="getInvoice()">
                                    <VListItemTitle>Get Invoice</VListItemTitle>
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

.app-user-search-filter .v-input__control {
    // height: 50px !important;
    top: 10px !important;
}

.app-user-search-filter .v-input__control .v-label.v-field-label {
    top: 10px !important;
}
</style>
