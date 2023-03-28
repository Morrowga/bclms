<template>
    <AdminLayout :auth="auth">
        <div class="flex flex-wrap justify-content-center gap-2 mb-2">
            <ConfirmDialog group="positionDialog"></ConfirmDialog>
        </div>
        <div class="card flex justify-content-center">
            <Toast />
        </div>

        <div
            class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14"
        >
            <div class="flex flex-col mb-10">
                <div class="relative">
                    <vue-good-table
                        class="data-table"
                        :columns="columns"
                        :rows="props.permissions"
                        styleClass="vgt-table striped"
                        :pagination-options="{
                            enabled: true,
                        }"
                        :search-options="{
                            enabled: true,
                        }"
                        :line-numbers="true"
                    >
                        <template #table-actions>
                            <Link :href="route('permissions.create')">
                                <AddIcon />
                            </Link>
                        </template>
                        <template #table-row="props">
                            <div v-if="props.column.field == 'permission'" class="flex flex-wrap">
                                <span
                                    v-for="permission in props.row.permissions"
                                    :key="permission.id"
                                    class="bg-blue-100 mt-2 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                    {{ permission.name }}
                                </span>
                            </div>
                            <div v-if="props.column.field == 'action'" class="flex flex-nowrap">
                                <Link :href="route('permissions.edit', {id: props.row.id,})">
                                    <IconButton buttonColor="yellow">
                                        <i class="pi pi-icon pi-file-edit"></i>
                                    </IconButton>
                                </Link>
                                <IconButton
                                    @click="destroy(props.row.id)"
                                    buttonColor="red">
                                    <i class="pi pi-icon pi-delete-left" style="font-size: 1rem"></i>
                                </IconButton>
                            </div>
                        </template>
                    </vue-good-table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { onMounted } from "vue";
import AdminLayout from "@dashboard/AdminLayout.vue";
import IconButton from "@Composables/IconButton.vue";

import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
let Confirm = useConfirm();
let toast = useToast();

let props = defineProps(["permissions", "flash", "auth"]);

// delete record
function destroy(id) {
    Confirm.require({
        group: "positionDialog",
        message: "Do you want to delete this record?",
        header: "Delete Confirmation",
        icon: "pi pi-info-circle",
        position: "center",
        accept: () => {
            router.delete(`permissions/${id}`, {
                onSuccess: () => {
                    toast.add({
                        severity: "success",
                        summary: "Delected",
                        detail: "Permission Delected successfully",
                        life: 3000,
                    });
                },
            });
        },
        reject: () => {
            toast.add({
                severity: "success",
                summary: "Rejected",
                detail: "You have rejected",
                life: 3000,
            });
        },
    });
}

let columns = [
    {
        label: "Name",
        field: "name",
    },
    {
        label: "Guard Name",
        field: "guard_name",
    },
    {
        label: "action",
        field: "action",
    },
];
onMounted(() => {
    if (props?.flash?.successMessage) {
        toast.add({
            severity: "success",
            summary: "Role created",
            detail: props?.flash?.successMessage,
            life: 3000,
        });
    }
});
</script>
<style scoped>
.data-table :deep(.vgt-wrap__footer select) {
    width: 80px;
}
.data-table :deep(.vgt-wrap__footer .footer__row-count::after) {
    display: none;
}
.data-table :deep(.vgt-global-search form) {
    width: 25%;
}
</style>
