<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
// import avatar4 from "@images/avatars/avatar-4.png";

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
        end_date: '02/08/23',
        plan: 1,
        status: 1
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: '02/08/23',
        plan: 0,
        status: 0
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: '02/08/23',
        plan: 1,
        status: 1
    },
    {
        user: "Jordan Stevenson",
        start_date: "02/07/23",
        end_date: '02/08/23',
        plan: 0,
        status: 1
    }
];


const items = [
    'Foo',
    'Bar',
]



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
            <VCardText class="d-flex flex-wrap gap-4">
                <!-- 👉 Export button -->
                <div class="d-flex align-center">
                    <v-btn prepend-icon="mdi-export" variant="outlined" color="secondary">Export</v-btn>
                </div>
                <VSpacer />

                <div class="app-user-search-filter d-flex justify-end align-center gap-6">

                    <VRow align="center">
                        <VCol cols="6">
                            <VTextField label="Search User" single-line />
                        </VCol>
                        <VCol cols="6">
                            <VSelect :items="items" :menu-props="{ transition: 'scroll-y-transition' }" label="Sort By"
                                class="rounded-select" />
                        </VCol>
                    </VRow>
                </div>
            </VCardText>

            <VDivider />

            <vue-good-table class="role-data-table" styleClass="vgt-table" v-on:selected-rows-change="selectionChanged"
                :columns="columns" :rows="rows" :select-options="{
                    enabled: true,
                }" :pagination-options="{
    enabled: true,
}">
                <template #table-row="dataProps">
                    <div v-if="dataProps.column.field === 'user'">
                        <div class="d-flex flex-row gap-2 ">
                            <img src="/images/defaults/avator.png" class="user-profile-image" />
                            <span>Jordan Stevenson</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'plan'">
                        <div class="d-flex flex-row  align-center gap-2">
                            <span v-if="dataProps.row.plan" class="d-flex flex-row justify-center align-center gap-2">
                                <img src="/images/icons/freeplan.svg" />
                                <span>free plan</span>
                            </span>
                            <span v-else class="d-flex flex-row align-center gap-2">
                                <img src="/images/icons/proplan.svg" />
                                <span>pro plan</span>
                            </span>
                            <span>{{ dataProps.column.field }}</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'status'">
                        <div v-if="dataProps.row.status">
                            <VChip color="secondary">
                                Active
                            </VChip>

                        </div>
                        <div v-else>
                            <VChip color="success">
                                Inactive
                            </VChip>

                        </div>
                    </div>
                </template>
            </vue-good-table>

            <VDivider />
        </VCard>
    </section>
</template>

<style lang="scss" >
.vgt-table th {
    font-size: 10pt !important;
}

.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}

.v-input__control {
    height: 50px !important;
    top: 10px !important;
}

.v-input__control .v-label.v-field-label {
    top: 10px !important;
}
</style>
