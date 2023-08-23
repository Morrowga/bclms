<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";

let props = defineProps(["organization"]);

//## start datatable section
let columns = [
    {
        label: "USER",
        field: "name",
        sortable: false,
    },
    {
        label: "EMAIL",
        field: "contact_email",
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

let rows = props.organization;

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

                <VTextField placeholder="Search User ..." density="compact" />

                <div class="app-user-search-filter d-flex align-center gap-6">
                    <!-- 👉 Search  -->
                    <VSelect
                        v-model="selectedRole"
                        label="Sort By"
                        :items="roles"
                        density="compact"
                    />
                    <!-- 👉 Add user button -->
                    <Link :href="route('organizations.index')">
                        <VBtn height="40" density="compact">
                            <span class="text-uppercase text-white">
                                View More
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
                :pagination-options="{
                    enabled: true,
                }"
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
                        v-if="dataProps.column.field == 'plan'"
                        class="flex flex-nowrap"
                    >
                        {{ dataProps.row.plan.name }}
                    </div>
                    <div
                        v-if="dataProps.column.field == 'role'"
                        class="flex flex-nowrap"
                    >
                        <VChip size="small" color="primary">organization</VChip>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'status'"
                        class="flex flex-nowrap"
                    >
                        <VChip size="small" color="danger"> pending </VChip>
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
                                    <VListItemTitle>View</VListItemTitle>
                                </VListItem>
                                <VListItem
                                    @click="
                                        () =>
                                            router.get(
                                                route('organizations.test.edit')
                                            )
                                    "
                                >
                                    <VListItemTitle>Edit</VListItemTitle>
                                </VListItem>
                                <VListItem
                                    @click="deleteOrganization(props.row.id)"
                                >
                                    <VListItemTitle>Delete</VListItemTitle>
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

<style lang="scss" scoped>
.vgt-table th {
    font-size: 10pt !important;
}

.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}

.rounded-select .v-select__selections {
    border-radius: 50% !important;
    /* Adjust the border radius as needed */
}

// ::v-deep .v-select .v-field--variant-outlined
// {
//     border: 1px solid var(--line, #E5E5E5);
//     background: var(--surface, #F6F6F6);
//     border-radius:100px;
//     outline: none !important;
// }
</style>
