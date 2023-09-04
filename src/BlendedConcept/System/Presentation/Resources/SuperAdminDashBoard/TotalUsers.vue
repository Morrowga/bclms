<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import avatar4 from "@images/avatars/avatar-4.png";
import { isConfirmedDialog } from "@actions/useConfirm";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

let props = defineProps(["users"]);
//## start datatable section
let columns = [
    {
        label: "USER",
        field: "name",
        sortable: false,
    },
    {
        label: "EMAIL",
        field: "email",
        sortable: false,
    },
    {
        label: "ROLE",
        field: "role",
        sortable: false,
    },
    {
        label: "PLAN",
        field: "plan",
        sortable: false,
    },
    {
        label: "STATUS",
        field: "status",
        sortable: false,
    },
    {
        label: "ACTION",
        field: "action",
        sortable: false,
    },
];

let rows = props.users;

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const handleSetInActive = () => {
    isConfirmedDialog({
        title: "",
        icon: "warning",
        confirmButtonText: "Save",
        denyButtonText: "Set Inactive",
    });
};
let selectedRole = ref("");
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex align-center flex-wrap gap-4">
                <!-- 👉 Export button -->
                <VBtn
                    variant="tonal"
                    color="primary"
                    prepend-icon="mdi-tray-arrow-up"
                >
                    Export
                </VBtn>

                <VSpacer />
                <div class="search-field">
                    <VTextField
                        placeholder="Search User ..."
                        density="compact"
                        variant="solo"
                    />
                </div>

                <div class="app-user-search-filter d-flex align-center gap-6">
                    <!-- 👉 Search  -->
                    <SelectBox
                        v-model="selectedRole"
                        placeholder="Sort By"
                        :datas="[
                            'Name',
                            'Email',
                            'Contact Number',
                            'Admin',
                            'Status',
                        ]"
                        density="compact"
                    />
                    <!-- 👉 Add user button -->
                    <Link :href="route('users.index')">
                        <VBtn height="40" density="compact">
                            <span class="text-uppercase text-white">
                                Vew More
                            </span>
                        </VBtn>
                    </Link>
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
                    <div
                        v-if="dataProps.column.field == 'user'"
                        class="flex flex-nowrap"
                    >
                        <VListItem class="pa-0">
                            <!-- 👉 Avatar  -->
                            <template #prepend>
                                <VAvatar
                                    rounded
                                    :size="38"
                                    class="me-3"
                                    :image="avatar4"
                                />
                            </template>

                            <!-- 👉 Title and Subtitle -->
                            <VListItemTitle
                                class="text-sm font-weight-semibold mb-1"
                            >
                                {{ dataProps.row.user }}
                            </VListItemTitle>

                            <VListItemSubtitle
                                class="text-xs text-no-wrap d-flex align-center"
                            >
                                <span> {{ dataProps.row.email }}</span>
                            </VListItemSubtitle>
                        </VListItem>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'role'"
                        class="flex flex-nowrap"
                    >
                        <VChip size="small" color="primary">
                            {{ dataProps.row?.roles[0]?.name }}
                        </VChip>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'plan'"
                        class="flex flex-nowrap"
                    >
                        &minus;
                    </div>
                    <div
                        v-if="dataProps.column.field == 'status'"
                        class="flex flex-nowrap"
                    >
                        <VChip
                            size="small"
                            color="success"
                            v-if="dataProps.row.email_verified_at"
                        >
                            verify
                        </VChip>
                        <VChip
                            size="small"
                            color="warning"
                            v-if="!dataProps.row.email_verified_at"
                        >
                            pending
                        </VChip>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'action'"
                        class="flex flex-nowrap"
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
                                <VListItem @click="handleSetInActive">
                                    <VListItemTitle
                                        >Set Inactive</VListItemTitle
                                    >
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

.vgt-wrap__footer {
    background: rgb(var(--v-theme-surface)) !important;
    border: none;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
