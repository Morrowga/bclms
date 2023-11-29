<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import Create from "./LearningCreate.vue";
import Edit from "./LearningEdit.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
import { checkPermission } from "@actions/useCheckPermission";

let props = defineProps(["disabilityTypes", "flash"]);

const form = useForm({});
let user = ref({});
//## start datatable section
let columns = [
    {
        label: "Learning Need Type",
        field: "name",
        sortable: false,
    },
    {
        label: "Sub Learning Type",
        field: "sub_learning",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];
serverPage.value = ref(props.disabilityTypes.meta.current_page ?? 1);
serverPerPage.value = ref(10);

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.disabilityTypes?.meta?.per_page,
    setCurrentPage: props?.disabilityTypes?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
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
    // console.log(data.selectedRows);
};
const deleteItem = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(route("learning_need.destroy", id), {
                onSuccess: () => {
                    SuccessDialog({ title: props.flash?.successMessage });
                },
            });
        },
    });
};
const handleSubmit = ({ title }) => {
    SuccessDialog({ title: title });
};
</script>
<template>
    <VRow>
        <VCol cols="12" sm="12" lg="12">
            <section>
                <VCard>
                    <VCardText class="d-flex justify-end">
                        <!-- 👉 Export button -->
                        <div class="search-field">
                            <VTextField
                                label="Search Learning Need Type"
                                single-line
                                density="compact"
                                variant="solo"
                                @keyup.enter="searchItems"
                                v-model="serverParams.search"
                            />
                        </div>
                        <VSpacer />

                        <VBtn class="tiggie-btn mt-1 ml-2">
                            <Create
                                v-if="
                                    checkPermission('create_learning')
                                "
                            />
                        </VBtn>
                    </VCardText>

                    <VDivider />

                    <vue-good-table
                        class="role-data-table"
                        styleClass="vgt-table"
                        @column-filter="onColumnFilter"
                        :totalRows="props.disabilityTypes.meta.total"
                        :selected-rows-change="selectionChanged"
                        :pagination-options="options"
                        :rows="props.disabilityTypes.data"
                        :columns="columns"
                        :select-options="{
                            enabled: true,
                            selectOnCheckboxOnly: true,
                        }"
                    >
                        <template #table-row="dataProps">
                            <div
                                v-if="dataProps.column.field == 'sub_learning'"
                                class="flex flex-wrap max-w-600"
                            >
                                <v-chip
                                    v-for="sublearn in dataProps.row
                                        .sub_learnings"
                                    :key="sublearn"
                                    class="ma-2"
                                    color="primary"
                                    size="small"
                                    >{{ sublearn.name }}</v-chip
                                >
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
                                        <Edit
                                            v-if="
                                                checkPermission('edit_learning')
                                            "
                                            :disability_type="dataProps.row"
                                        />
                                        <VListItem
                                            v-if="
                                                checkPermission(
                                                    'delete_learning'
                                                )
                                            "
                                            @click="
                                                deleteItem(dataProps.row.id)
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
                                        {{ props.disabilityTypes.meta.from }}
                                        to
                                        {{ props.disabilityTypes.meta.to }}
                                        of
                                        {{ props.disabilityTypes.meta.total }}
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
                                                props.disabilityTypes.meta
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
</template>
