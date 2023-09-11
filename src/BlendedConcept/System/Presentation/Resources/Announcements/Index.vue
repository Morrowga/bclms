<script setup>
import Create from "./Create.vue";
// import Edit from "./Edit.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import { isConfirmedDialog } from "@actions/useConfirm";
import deleteItem from "@Composables/useDeleteItem.js";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    truncatedText,
} from "@Composables/useServerSideDatable.js";
//## start variable section
let props = defineProps([
    "announcements",
    "flash",
    "auth",
    "users",
    "organizations",
]);
let currentAnnouncement = ref();
console.log(props.announcements)
const isAddNewAnnouncementDrawerVisible = ref(false);
const isEditAnnouncementDrawerVisible = ref(false);
serverPage.value = ref(props.announcements.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
serverPerPage.value = ref(10);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);

//## end delete announcement and delete in database

//start datatable section
let columns = [
    {
        label: "Title",
        field: "title",
        sortable: false,
    },
    {
        label: "Message",
        field: "message",
        sortable: false,
    },
    {
        label: "Announcement by",
        field: "author_id",
        sortable: false,
    },
    {
        label: "Announment to",
        field: "target_role_id",
        sortable: false,
    },
    {
        label: "Announment Icon",
        field: "icon",
        sortable: false,
    },
      {
        label: "Action",
        field: "action",
        sortable: false,
    },
];

//## options for datatable
let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.announcements.meta.per_page,
    setCurrentPage: props.announcements.meta.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

//## watch per page change in datatable
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

const checkUserRole = () => {
    return user_role.value == "BC Super Admin" || user_role.value == "BC Staff";
};

const deleteAnnouncement = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete('announcements/' + id, {
                onSuccess: () => {},
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <VContainer :fluid="checkUserRole()">
            <h1 class="tiggie-title mb-4">Announcements</h1>
            <section>
                <VCard>
                    <VCardText class="d-flex flex-wrap gap-4">
                        <!-- 👉 Export button -->
                        <!-- 👉 Search  -->
                        <div class="search-field">
                            <VTextField
                                @keyup.enter="searchItems"
                                v-model="serverParams.search"
                                placeholder="Search Announcement"
                                density="compact"
                                variant="solo"
                            />
                        </div>
                        <VSpacer />

                        <div
                            class="app-user-search-filter d-flex justify-end align-center"
                        >
                            <!-- 👉 Add Announcement button -->
                            <VBtn class="tiggie-btn">
                                <Link
                                    :href="route('announcements.create')"
                                    class="text-white"
                                >
                                    Add Announcement
                                </Link>
                            </VBtn>
                        </div>
                    </VCardText>

                    <VDivider />

                    <vue-good-table
                        class="announcement-data-table"
                        mode="remote"
                        @column-filter="onColumnFilter"
                        :totalRows="props.announcements.meta.total"
                        styleClass="vgt-table"
                        :pagination-options="options"
                        :rows="props.announcements.data"
                        :columns="columns"
                    >
                        <template #table-row="props">
                            <div
                                v-if="props.column.field == 'title'"
                                class="flex flex-wrap"
                            >
                                <div class="d-flex flex-row gap-2">
                                    <img
                                    src="/images/icons/award-02.svg"
                                        class="user-profile-image"
                                    />
                                    <span class="pt-1">{{
                                        props.row.title
                                    }}</span>
                                </div>
                            </div>
                            <div
                                v-if="props.column.field == 'message'"
                                class="flex flex-wrap"
                            >
                                <span>{{
                                    truncatedText(props.row.message)
                                }}</span>
                            </div>
                            <div
                                v-if="props.column.field == 'author_id'"
                                class="flex flex-wrap"
                            >
                                <span>{{
                                    truncatedText(props.row.author_id.name)
                                }}</span>
                            </div>
                            <div
                                v-if="props.column.field == 'target_role_id'"
                                class="flex flex-wrap"
                            >
                                <span>{{
                                    truncatedText(props.row.target_role_id.name)
                                }}</span>
                            </div>
                            <div
                                v-if="props.column.field == 'icon'"
                                class="flex flex-wrap"
                            >
                                <span class="text-center">
                                    <VIcon :icon="props.row.icon"></VIcon>
                                </span>
                            </div>
                            <div v-if="props.column.field == 'action'">
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
                                                        'announcements.edit',props.row.id
                                                    )
                                                )
                                        "
                                    >
                                        <VListItemTitle>Edit</VListItemTitle>
                                    </VListItem>
                                    <VListItem
                                        @click="
                                            deleteAnnouncement(props.row.id)
                                        "
                                    >
                                        <VListItemTitle>Delete</VListItemTitle>
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
                                    <span
                                        >Showing
                                        {{ props.announcements.meta.from }} to
                                        {{ props.announcements.meta.to }} of
                                        {{ props.announcements.meta.total }}
                                        entries</span
                                    >
                                    <div>
                                        <div class="d-flex align-center">
                                            <span class="me-2">Show</span>
                                            <VSelect
                                                v-model="serverPerPage"
                                                density="compact"
                                                :items="options.perPageDropdown"
                                            ></VSelect>
                                            <VPagination
                                                v-model="serverPage"
                                                size="small"
                                                :total-visible="5"
                                                :length="
                                                    props.announcements.meta
                                                        .last_page
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
        </VContainer>
    </AdminLayout>
</template>

<style lang="scss">
//## style for darkmode
.announcement-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}
.announcement-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.announcement-data-table table.vgt-table thead th {
    background: rgb(var(--v-theme-surface)) !important;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.text-capitalize {
    text-transform: capitalize;
}

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
