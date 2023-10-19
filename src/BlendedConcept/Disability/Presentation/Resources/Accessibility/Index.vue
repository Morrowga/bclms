<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
let props = defineProps(["devices", "flash"]);

//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
        sortable: false,
    },
    {
        label: "Disability",
        field: "disability",
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

// let rows = [
//     {
//         name: "Eye-Gaze",
//         disability: "Dyslexia",
//         description:
//             "Specific learning disabilities  that affect reading and language-based skills",
//         status: true,
//     },
//     {
//         name: "Eye-Gaze",
//         disability: "Attention Deficit/Hyperactivity Disorder",
//         description:
//             "Trouble paying attention, controlling impulsive behaviors and overly-active",
//         status: true,
//     },
//     {
//         name: "Eye-Gaze",
//         disability: "Dyscalculia",
//         description: "Affects the ability to understand and learn math facts",
//         status: false,
//     },
//     {
//         name: "Eye-Gaze",
//         disability: "Dyspraxia",
//         description: "Problem with movement, coordination, language and speech",
//         status: true,
//     },
// ];

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

serverPage.value = ref(props.devices.meta.current_page ?? 1);
serverPerPage.value = ref(10);

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.devices?.meta?.per_page,
    setCurrentPage: props?.devices?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});
let filters = ref(null);
let filterDatas = ref([
    { title: "Name", value: "name" },
    { title: "Description", value: "description" },
    { title: "Disability", value: "disability" },
    { title: "Status", value: "status" },
]);
const form = useForm({
    status: "",
    _method: "DELETE",
});
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
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

const goRoute = (route) => {
    router.get(route);
};
// const deleteItem = () => {
//     isConfirmedDialog({
//         denyButtonText: "Set Inactive",
//         onConfirm: () => {
//             // alert("good to go");
//         },
//     });
// };
const deleteItem = (status, id) => {
    if (status == "ACTIVE") {
        form.status = "INACTIVE";
        isConfirmedDialog({
            denyButtonText: form.status == "ACTIVE" ? "Active" : "Inactive",
            onConfirm: () => {
                form.post(route("accessibility_device.destroy", id), {
                    onSuccess: () => {
                        SuccessDialog({ title: props.flash?.successMessage });
                    },
                });
            },
        });
    } else {
        form.status = "ACTIVE";
        isConfirmedDialog({
            icon: "success",
            color: "#48BC65",
            denyButtonColor: "#48BC65",
            denyButtonText: form.status == "ACTIVE" ? "Active" : "Inactive",
            onConfirm: () => {
                form.post(route("accessibility_device.destroy", id), {
                    onSuccess: () => {
                        SuccessDialog({ title: props.flash?.successMessage });
                    },
                });
            },
        });
    }
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Accessibility Devices</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText
                                class="d-flex flex-wrap gap-4 align-center"
                            >
                                <!-- 👉 Export button -->

                                <VSpacer />

                                <div class="search-field">
                                    <VTextField
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
                                            v-model="filters"
                                            placeholder="Sort By"
                                            :datas="filterDatas"
                                            density="compact"
                                            item_title="title"
                                            item_value="value"
                                        />
                                        <!-- 👉 Add button -->
                                        <DefaultBtn
                                            title="Add Device"
                                            @click="
                                                goRoute(
                                                    route(
                                                        'accessibility_device.create'
                                                    )
                                                )
                                            "
                                        />
                                    </div>
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                @column-filter="onColumnFilter"
                                :totalRows="props.devices.meta.total"
                                :selected-rows-change="selectionChanged"
                                :pagination-options="options"
                                :rows="props.devices.data"
                                :columns="columns"
                                :select-options="{
                                    enabled: true,
                                    selectOnCheckboxOnly: true,
                                }"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'disability'
                                        "
                                        class="flex flex-wrap max-w-600"
                                    >
                                        <v-chip
                                            v-for="disability in dataProps.row
                                                .disability_types"
                                            :key="disability.id"
                                            class="ma-2"
                                            color="primary"
                                            size="small"
                                            >{{ disability.name }}</v-chip
                                        >
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'status'
                                        "
                                        class="flex flex-wrap"
                                    >
                                        <VChip
                                            v-if="
                                                dataProps.row.status == 'ACTIVE'
                                            "
                                            color="success"
                                        >
                                            Active
                                        </VChip>

                                        <VChip color="warning" v-else>
                                            Inactive
                                        </VChip>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
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
                                                                route(
                                                                    'accessibility_device.edit',
                                                                    dataProps
                                                                        .row.id
                                                                )
                                                            )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Edit</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem
                                                    @click="
                                                        deleteItem(
                                                            dataProps.row
                                                                .status,
                                                            dataProps.row.id
                                                        )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Delete</VListItemTitle
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
                                            <span>
                                                Showing
                                                {{ props.devices.meta.from }}
                                                to
                                                {{ props.devices.meta.to }}
                                                of
                                                {{ props.devices.meta.total }}
                                                entries
                                            </span>
                                            <div class="d-flex">
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
                                                    >
                                                    </VSelect>
                                                </div>
                                                <VPagination
                                                    v-model="serverPage"
                                                    size="small"
                                                    :total-visible="5"
                                                    :length="
                                                        props.devices.meta
                                                            .last_page
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
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
