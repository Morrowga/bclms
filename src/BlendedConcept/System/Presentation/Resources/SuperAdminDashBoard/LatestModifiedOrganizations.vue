<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import avatar4 from "@images/avatars/avatar-4.png";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { isConfirmedDialog } from "@actions/useConfirm";

let props = defineProps(["organization"]);

//## start datatable section
let columns = [
    {
        label: "Organisation",
        field: "name",
        sortable: false,
    },
    {
        label: "Email",
        field: "contact_email",
        sortable: false,
    },
    {
        label: "Contact Number",
        field: "contact_number",
        sortable: false,
    },
    {
        label: "Admin",
        field: "admin",
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

let rows = props.organization;


const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const deleteOrganization = () => {
    isConfirmedDialog({
        title: "",
        icon: "warning",
        confirmButtonText: "Save",
        denyButtonText: "Yes,delete it",
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
                        placeholder="Search Organisation"
                        density="compact"
                        width="100"
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
                        v-if="dataProps.column.field == 'contact_number'"
                        class="flex flex-nowrap"
                    >
                        {{ dataProps.row.contact_number }}
                    </div>
                    <Link
                        :href="route('users.show', { id: 1 })"
                        v-if="dataProps.column.field == 'admin'"
                        class="flex flex-nowrap text-secondary"
                    >
                        <VAvatar
                            rounded
                            :size="38"
                            class="me-3"
                            :image="avatar4"
                        />
                        {{ dataProps.row.name }}
                        <!-- <VChip size="small" color="primary">organization</VChip> -->
                    </Link>
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
                                    @click="() => router.get(route('organizations.edit',dataProps.row.id))">
                                    <VListItemTitle>Edit</VListItemTitle>
                                </VListItem>
                                <VListItem @click="deleteOrganization()">
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


</style>
