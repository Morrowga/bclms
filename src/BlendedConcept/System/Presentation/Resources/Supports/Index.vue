<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { defineProps } from "vue";
import avatar4 from "@images/avatars/avatar-4.png";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { router } from "@inertiajs/core";
import { isConfirmedDialog } from "@actions/useConfirm";
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

serverPage.value = ref(props.technicalSupportList.meta.current_page ?? 1);
serverPerPage.value = ref(10);
import AnswerSupport from "./components/AnswerSupport.vue";

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

const props = defineProps(["technicalSupportList"]);

const form = useForm({
    id: "",
    response: "",
    user_id: "",
    question: "",
});

const items = ["Foo", "Bar"];

const isAnswerTechnicalSupport = ref(false);

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.technicalSupportList?.meta?.per_page,
    setCurrentPage: props?.technicalSupportList?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});
let filters = ref(null);
let filterDatas = ref([
    { title: "Name", value: "name" },
    { title: "Date", value: "date" },
    { title: "Status", value: "status" },
]);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
const deleteSupport = () => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            router.delete(route("deleteSupportQuestion", form.id), {
                onSuccess: () => {
                    SuccessDialog({
                        title: "You have successfully deleted!",
                        color: "#17CAB6",
                    });
                },
                onError: () => {
                    console.log("something was wrong");
                },
            });
        },
    });
};

const onRowClick = (params) => {
    console.log(params);
    form.id = params.row.id;
    form.question = params.row.question;
    //disable event for deletePopUP
    if (params?.event?.target?.className?.includes("disablePopUp")) {
        return;
    }
    document.getElementsByClassName("clickLayNaw")[0].click();
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <VRow>
                <VCol cols="6">
                    <h1 class="tiggie-title">Technical Support Request</h1>
                </VCol>
                <VCol cols="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <VSpacer id="helloMarNayTae" />
                                <div
                                    class="d-flex justify-end align-center gap-3"
                                >
                                    <VTextField
                                        placeholder="Search Request"
                                        density="compact"
                                        style="width: 300px"
                                        variant="solo"
                                        @keyup.enter="searchItems"
                                        v-model="serverParams.search"
                                    />
                                    <SelectBox
                                        v-model="filters"
                                        placeholder="Sort By"
                                        :datas="filterDatas"
                                        density="compact"
                                        item_title="title"
                                        item_value="value"
                                        style="width: 150px"
                                    />
                                    <VBtn class="tiggie-btn"> Delete </VBtn>
                                </div>
                            </VCardText>
                            <VDivider />
                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                @column-filter="onColumnFilter"
                                :totalRows="
                                    props.technicalSupportList.meta.total
                                "
                                :selected-rows-change="selectionChanged"
                                :pagination-options="options"
                                :rows="props.technicalSupportList.data"
                                :columns="columns"
                                v-on:row-click="onRowClick"
                                :select-options="{
                                    enabled: true,
                                    selectOnCheckboxOnly: true,
                                }"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="dataProps.column.field == 'name'"
                                    >
                                        <div class="d-flex flex-row gap-2">
                                            <span>
                                                {{
                                                    dataProps.row.user
                                                        .first_name
                                                }}
                                                {{
                                                    dataProps.row.user.last_name
                                                }}
                                            </span>
                                        </div>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'request'
                                        "
                                        class="max-width-request"
                                    >
                                        <span class="text-wrap">{{
                                            dataProps.row.question
                                        }}</span>
                                    </div>
                                    <div
                                        v-if="dataProps.column.field == 'date'"
                                    >
                                        <span class="text-no-wrap">{{
                                            dataProps.row.date
                                        }}</span>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'status'
                                        "
                                    >
                                        <VChip
                                            color="success"
                                            v-if="!dataProps.row.has_responded"
                                            >Active</VChip
                                        >
                                        <VChip
                                            color="gray"
                                            v-if="dataProps.row.has_responded"
                                            >Closed</VChip
                                        >
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VBtn
                                            variant="text"
                                            class="text-secondary disablePopUp"
                                            @click="
                                                deleteSupport(dataProps.row.id)
                                            "
                                        >
                                            <VIcon
                                                icon="mdi-trash-can-outline"
                                                size="21"
                                                class="disablePopUp"
                                            />
                                        </VBtn>
                                    </div>
                                    <AnswerSupport :dataPropsRow="form" />
                                </template>
                                <template #pagination-bottom>
                                    <VRow class="pa-4">
                                        <VCol
                                            cols="12"
                                            class="d-flex justify-space-between"
                                        >
                                            <span
                                                >Showing
                                                {{
                                                    props.technicalSupportList
                                                        .meta.from
                                                }}
                                                to
                                                {{
                                                    props.technicalSupportList
                                                        .meta.to
                                                }}
                                                of
                                                {{
                                                    props.technicalSupportList
                                                        .meta.total
                                                }}
                                                entries</span
                                            >
                                            <div>
                                                <div
                                                    class="d-flex align-center"
                                                >
                                                    <span class="me-2"
                                                        >Show</span
                                                    >
                                                    <VSelect
                                                        v-model="serverPerPage"
                                                        density="compact"
                                                        :items="
                                                            options.perPageDropdown
                                                        "
                                                    ></VSelect>
                                                    <VPagination
                                                        v-model="serverPage"
                                                        size="small"
                                                        :total-visible="5"
                                                        :length="
                                                            props
                                                                .technicalSupportList
                                                                .meta.last_page
                                                        "
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
                    </section>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.txt-field {
    width: 300px !important;
}
.selectbox-width {
    width: 150px !important;
}
.max-width-request {
    max-width: 40% !important;
}
</style>
