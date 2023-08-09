<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
// import avatar4 from "@images/avatars/avatar-4.png";
import AnswerSupport from "./components/AnswerSupport.vue";

let props = defineProps();

//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Request",
        field: "request",
        sortable: false,
    },
    {
        label: "Date",
        field: "date",
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
        name: "Jordan Stevenson",
        request: "The computer is saying ‘press any key’ but I’m struggling to find it",
        date: '02/08/23',
        status: 1
    },
    {
        name: "Jordan Stevenson",
        request: "The computer is saying ‘press any key’ but I’m struggling to find it",
        date: '02/08/23',
        status: 1
    },
    {
        name: "Jordan Stevenson",
        request: "The computer is saying ‘press any key’ but I’m struggling to find it",
        date: '02/08/23',
        status: 1
    },
    {
        name: "Jordan Stevenson",
        request: "The computer is saying ‘press any key’ but I’m struggling to find it",
        date: '02/08/23',
        status: 1
    }
];


const items = [
    'Foo',
    'Bar',
]

const isAnswerTechnicalSupport = ref(false);


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
    <AdminLayout>
        <VRow>
            <VCol cols="6">
                <h1 class="tiggie-title">Technical Support Requests</h1>
            </VCol>
            <VCol cols="12">
                <section>
                    <VCard>
                        <VCardText class="d-flex flex-wrap gap-4">
                            <VSpacer />
                            <div class="app-user-search-filter d-flex justify-end align-center gap-6">
                                <VTextField placeholder="Search Organizations" density="compact" />
                                <VBtn class="tiggie-btn" @click="isAnswerTechnicalSupport = true">
                                    Delete
                                </VBtn>
                            </div>
                        </VCardText>
                        <VDivider />
                        <vue-good-table class="role-data-table" styleClass="vgt-table"
                            v-on:selected-rows-change="selectionChanged" :columns="columns" :rows="rows"
                            :select-options="{ enabled: true, }" :pagination-options="{ enabled: true, }">
                            <template #table-row="dataProps">
                                <div v-if="dataProps.column.field === 'user'">
                                    <div class="d-flex flex-row gap-2 ">
                                        <img src="/images/defaults/avator.png" class="user-profile-image" />
                                        <span>Jordan Stevenson</span>
                                    </div>
                                </div>
                                <div v-if="dataProps.column.field == 'status'">
                                    <VChip color="success">
                                        Active
                                    </VChip>
                                </div>
                                <div v-if="dataProps.column.field == 'action'">
                                    <VIcon icon="mdi-trash-can-outline" size="21" />
                                </div>
                            </template>
                        </vue-good-table>
                        <AnswerSupport v-model:isDialogVisible="isAnswerTechnicalSupport" :user-data="user" :form="form"
                            @submit="hanleSubmit" />
                        <VDivider />
                    </VCard>
                </section>
            </VCol>
        </VRow>
    </AdminLayout>
</template>
