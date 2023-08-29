<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { watch, defineProps, computed, ref } from "vue";
import { requiredValidator } from "@validators";
import { toastAlert } from "@Composables/useToastAlert";
import { router } from "@inertiajs/core";

//## start for form submit
let form = useForm({
    name: "",
    description: "",
    selectedIds: [],
});
let headers = [
    {
        title: "Permission Name",
        align: "start",
        sortable: false,
        key: "name",
    },
    {
        title: "Description",
        align: "start",
        sortable: false,
        key: "name",
    },
    {
        title: "Guard Name",
        align: "start",
        sortable: false,
        key: "name",
    },
    {
        title: "",
        key: "check-all",
    },
];
let props = defineProps(["permissions", "flash", "role", "exists_permissions"]);
let permissionsFilter = computed(() =>
    props.permissions.filter((item) => item.name?.includes(searchName.value))
);
let searchName = ref("");
const isFormValid = ref(false);
const refForm = ref();
const selectedIds = ref([]);
const check_all = ref(false);
//## end for form submit

//## start updateRole
let updateRole = (id) => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.put(route("roles.update", { id: id }), {
                onSuccess: () => {
                    toastAlert({
                        title: props.flash?.successMessage,
                    });
                    router.get(route("roles.index"));
                },
                onError: (error) => {
                    form.setError("name", error?.name);
                },
            });
            //## form.reset();
        }
    });
};
//## end updateRole
const insertIds = (id) => {
    const index = selectedIds.value.indexOf(id);

    if (index === -1) {
        selectedIds.value.push(id);
    } else {
        selectedIds.value.splice(index, 1);
    }
    form.selectedIds = selectedIds.value;
};

// const checkAll = (e) => {
//     check_all.value = !check_all.value;
//     selectedIds.value = [];
//     if (check_all.value) {
//         for (let i = 0; i < props.permissions.length; i++) {
//             const id = props.permissions[i].id;
//             selectedIds.value.push(id);
//         }
//     } else {
//         selectedIds.value = [];
//     }
//     console.log(selectedIds.value);
// };
const checkingExistsId = (id) => {
    let condition = props.exists_permissions.includes(id);
    return condition ? true : false;
};
onMounted(() => {
    form.selectedIds = props.exists_permissions;
    selectedIds.value = props.exists_permissions;
    form.name = props.role.name;
    form.description = props.role.description;
    console.log(form.selectedIds);
});
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-0">Edit Role</h1>

            <VForm
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="updateRole(props.role.id)"
            >
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isDialogVisible = false"
                />
                <VRow>
                    <VCol cols="12">
                        <VTextField
                            :error-messages="form.errors?.name"
                            label="Role Name"
                            v-model="form.name"
                            :rules="[requiredValidator]"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VTextarea
                            label="Description"
                            v-model="form.description"
                            :error-messages="form.errors?.description"
                        />
                    </VCol>
                    <VCol cols="12">
                        <div class="mb-6 flex-auto">
                            <h1 class="tiggie-title mb-2">
                                Assign Permission To Roles
                            </h1>
                            <div class="relative overflow-x-auto">
                                <VCard>
                                    <VCardTitle>
                                        <div class="mb-4">
                                            <VTextField
                                                placeholder="Search Permissions"
                                                v-model="searchName"
                                            >
                                            </VTextField>
                                        </div>
                                    </VCardTitle>
                                    <VCardText>
                                        <v-table fixed-header height="500">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-left"
                                                        v-for="header in headers"
                                                        :key="header"
                                                    >
                                                        {{ header.title }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="item in permissionsFilter"
                                                    :key="item.id"
                                                >
                                                    <td>{{ item.name }}</td>
                                                    <td>
                                                        {{ item.description }}
                                                    </td>
                                                    <td>
                                                        {{ item.guard_name }}
                                                    </td>
                                                    <td>
                                                        <v-checkbox
                                                            :model-value="
                                                                checkingExistsId(
                                                                    item.id
                                                                )
                                                            "
                                                            @click="
                                                                insertIds(
                                                                    item.id
                                                                )
                                                            "
                                                        ></v-checkbox>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-table>
                                    </VCardText>
                                </VCard>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="12" class="d-flex justify-center">
                        <VBtn
                            variant="outlined"
                            class="me-3"
                            color="secondary"
                            @click="router.get(route('roles.index'))"
                        >
                            Cancel
                        </VBtn>
                        <VBtn type="submit"> Update </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
