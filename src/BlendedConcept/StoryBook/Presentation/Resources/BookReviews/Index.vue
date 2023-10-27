<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import BookReviewDetails from "./components/BookReviewDetails.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { checkPermission } from "@actions/useCheckPermission";
let props = defineProps(["bookreviews"]);

import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";

let columns = [
    {
        label: "Reviewer",
        field: "reviewer",
        sortable: false,
    },
    {
        label: "Book",
        field: "book",
        sortable: false,
    },
    {
        label: "Stars",
        field: "stars",
        sortable: false,
    },
    {
        label: "Title",
        field: "title",
        sortable: false,
    },
    {
        label: "Date",
        field: "date",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

const isDiability = ref(false);
const isEditDiability = ref(false);
let isDialogVisible = ref(false);

let filters = ref(null);
let filterDatas = ref([
    { title: "Reviewers", value: "reviewers" },
    { title: "Book", value: "book" },
    { title: "Date", value: "given_on" },
]);

serverPage.value = ref(props.bookreviews.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
serverPerPage.value = ref(10);
let page = usePage();
let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.bookreviews.meta.per_page,
    setCurrentPage: props.bookreviews.meta.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

const storybooksDetails = ref([]);

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
const showDetail = (params) => {
    console.log(params.row);
    storybooksDetails.value = params.row;
    isDialogVisible.value = !isDialogVisible.value;
};
const deleteReview = () => {
    isConfirmedDialog({
        denyButtonText: "Set Inactive",
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Book Reviews</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText
                                class="d-flex flex-wrap gap-4 align-center"
                            >
                                <!-- 👉 Export button -->
                                <!-- 👉 Search  -->
                                <VSpacer />

                                <div class="search-field">
                                    <VTextField
                                        @keyup.enter="searchItems"
                                        placeholder="Search Reviews"
                                        density="compact"
                                        class="pr-2"
                                        variant="solo"
                                    />
                                </div>
                                <div
                                    class="app-user-search-filter d-flex justify-end align-center gap-4"
                                >
                                    <selectBox
                                        v-model="filters"
                                        placeholder="Sort By"
                                        :datas="filterDatas"
                                        density="compact"
                                        item_title="title"
                                        item_value="value"
                                    />
                                    <!-- 👉 Add Announcement button -->
                                    <VBtn class="tiggie-btn"> Delete </VBtn>

                                    <BookReviewDetails
                                        :bookreviews="storybooksDetails"
                                        :isDialogVisible="isDialogVisible"
                                    />
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                v-on:selected-rows-change="selectionChanged"
                                :columns="columns"
                                :rows="bookreviews.data"
                                :select-options="{
                                    enabled: false,
                                }"
                                :pagination-options="{ enabled: true }"
                                v-on:row-click="showDetail"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="
                                            dataProps.column.field == 'reviewer'
                                        "
                                    >
                                        <p>
                                            {{
                                                dataProps.row.users[0].full_name
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        v-if="dataProps.column.field == 'book'"
                                    >
                                        <p>
                                            {{
                                                dataProps?.row?.storybooks?.name
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        v-if="dataProps.column.field == 'title'"
                                    >
                                        <p>
                                            {{ dataProps?.row?.feedback }}
                                        </p>
                                    </div>
                                    <div
                                        v-if="dataProps.column.field == 'date'"
                                    >
                                        <p>
                                            {{
                                                moment(
                                                    dataProps.row.give_on
                                                ).format("DD-MM-YYYY")
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        v-if="dataProps.column.field == 'stars'"
                                    >
                                        <VRating
                                            readonly
                                            :model-value="dataProps.row.stars"
                                            active-color="#4C4E64"
                                        />
                                    </div>

                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VBtn
                                            v-if="
                                                checkPermission('delete_review')
                                            "
                                            variant="text"
                                            class="text-secondary"
                                            @click="deleteReview"
                                        >
                                            <VIcon
                                                icon="mdi-trash-can-outline"
                                                size="21"
                                            />
                                        </VBtn>
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
                                                {{
                                                    props.bookreviews.meta.from
                                                }}
                                                to
                                                {{ props.bookreviews.meta.to }}
                                                of
                                                {{
                                                    props.bookreviews.meta.total
                                                }}
                                                entries
                                            </span>
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
                                                            props.bookreviews
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
.custom-progress {
    width: 70%;
}
:deep(.role-data-table .vgt-left-align) {
    vertical-align: middle !important;
    cursor: pointer;
}
</style>
