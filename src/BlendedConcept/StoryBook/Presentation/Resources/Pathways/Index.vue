<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
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
let props = defineProps(["pathways", "flash"]);
let flash = computed(() => usePage().props?.flash);
//## start datatable section
let columns = [
    {
        label: "ID",
        field: "id",
        sortable: false,
    },
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
        label: "Storybooks",
        field: "storybooks",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];
serverPage.value = ref(props.pathways.meta.current_page ?? 1);
serverPerPage.value = ref(10);

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.pathways?.meta?.per_page,
    setCurrentPage: props?.pathways?.meta?.current_page,
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
const deletePathway = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            router.delete(route("pathways.destroy", id), {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
            });
        },
    });
};
const selectionChanged = (data) => {
    // console.log(data.selectedRows);
};
const goEdit = (id) => {
    router.get(route("pathways.edit", id));
};
const showInfo = (e) => {
    router.get(
        route("pathways.show", {
            id: e.row.id,
        })
    );
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Pathways</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->
                                <div class="search-field">
                                    <VTextField
                                        placeholder="Search Pathway"
                                        density="compact"
                                        variant="solo"
                                        @keyup.enter="searchItems"
                                        v-model="serverParams.search"
                                    />
                                </div>
                                <VSpacer />
                                <div
                                    class="app-user-search-filter d-flex justify-end align-center"
                                >
                                    <div class="d-flex flex-row flex-end gap-2">
                                        <!-- 👉 Search  -->

                                        <!-- 👉 Add User button -->
                                        <VBtn class="tiggie-btn">
                                            <Link
                                                v-if="
                                                    checkPermission(
                                                        'create_pathway'
                                                    )
                                                "
                                                :href="route('pathways.create')"
                                                class="text-white"
                                            >
                                                Add New
                                            </Link>
                                        </VBtn>
                                    </div>
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                @column-filter="onColumnFilter"
                                :totalRows="props.pathways.meta.total"
                                :selected-rows-change="selectionChanged"
                                :pagination-options="options"
                                :rows="props.pathways.data"
                                :columns="columns"
                                :select-options="{
                                    enabled: true,
                                    selectOnCheckboxOnly: true,
                                }"
                                @row-click="showInfo"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="dataProps.column.field == 'name'"
                                    >
                                        {{ dataProps.row.name }}
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'storybooks'
                                        "
                                    >
                                        <v-chip
                                            v-for="storybook in dataProps.row
                                                .storybooks"
                                            :key="storybook.name"
                                            class="ma-2"
                                            color="primary"
                                            size="small"
                                            >{{ storybook.name }}
                                        </v-chip>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'rewards_issued'
                                        "
                                    >
                                        <VProgressLinear
                                            color="yellow-darken-2"
                                            class="custom-progress"
                                            model-value="80"
                                            :height="8"
                                        >
                                        </VProgressLinear>
                                        <span
                                            ><span class="text-warning">8 </span
                                            >/10</span
                                        >
                                        Users
                                    </div>

                                    <div
                                        v-if="
                                            dataProps.column.field == 'status'
                                        "
                                    >
                                        <VChip color="secondary">
                                            Active
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
                                                    v-if="
                                                        checkPermission(
                                                            'edit_pathway'
                                                        )
                                                    "
                                                    @click="
                                                        goEdit(dataProps.row.id)
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Edit</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem
                                                    v-if="
                                                        checkPermission(
                                                            'delete_pathway'
                                                        )
                                                    "
                                                    @click="
                                                        deletePathway(
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
                                                {{ props.pathways.meta.from }}
                                                to
                                                {{ props.pathways.meta.to }}
                                                of
                                                {{ props.pathways.meta.total }}
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
                                                        props.pathways.meta
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

<style scoped>
.custom-progress {
    width: 70%;
}
</style>
