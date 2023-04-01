<template>
    <AdminLayout :auth="auth">
        <form @submit.prevent="saveRole">
            <div
                class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14"
            >
                <div class="flex mb-4">
                    <span class="text-xl">Create</span>
                </div>
                <div class="flex flex-col mb-10">
                    <div class="relative">
                        <div class="grid grid-cols-12 gap-y-2">
                            <div class="col-span-12">
                                <div class="mb-6 flex-auto">
                                    <input
                                        v-model="form.name"
                                        id="role"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Enter Role Name"
                                    />

                                    <p
                                        v-if="form.errors?.name"
                                        class="mt-1 text-sm text-red-500 dark:text-red-300"
                                        id="file_input_help"
                                    >
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <div class="mb-6 flex-auto">
                                    <label
                                        for="permission"
                                        class="block mb-2 text-md font-medium text-gray-900 dark:text-white"
                                        >Assign Permission To Roles</label
                                    >

                                    <div class="relative overflow-x-auto">
                                        <table
                                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                                        >
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                            >
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="px-4 py-4"
                                                    >
                                                        <div
                                                            class="flex items-center"
                                                        >
                                                            <input
                                                                id="check-all"
                                                                type="checkbox"
                                                                @click="
                                                                    selectAll
                                                                "
                                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            />
                                                            <span
                                                                for="default-checkbox"
                                                                class="ml-2 font-medium text-gray-900 dark:text-gray-300"
                                                                >MODULE</span
                                                            >
                                                        </div>
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3"
                                                    >
                                                        <span
                                                            for="default-checkbox"
                                                            class="ml-2 font-medium text-gray-900 dark:text-gray-300"
                                                            >PERMISSIONS</span
                                                        >
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-xs">
                                                <tr
                                                    v-for="item in permissions_modules"
                                                    :key="item.key"
                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                                >
                                                    <td class="px-4 py-4">
                                                        <div
                                                            class="flex items-center"
                                                        >
                                                            <input
                                                                :id="
                                                                    'module-checkbox-' +
                                                                    item.key
                                                                "
                                                                @click="
                                                                    selectByModule(
                                                                        item.name,
                                                                        item.key
                                                                    )
                                                                "
                                                                type="checkbox"
                                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            />
                                                            <span
                                                                for="default-checkbox"
                                                                class="ml-2 font-medium text-gray-900 dark:text-gray-300 uppercase"
                                                                >{{
                                                                    item.name
                                                                }}</span
                                                            >
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4">
                                                        <div
                                                            class="grid grid-cols-4"
                                                        >
                                                            <div
                                                                v-for="permission in item.permissions"
                                                                :key="
                                                                    permission.id
                                                                "
                                                                class="flex items-center mt-2"
                                                            >
                                                                <input
                                                                    v-model="
                                                                        form.selectedIds
                                                                    "
                                                                    :value="
                                                                        permission.id
                                                                    "
                                                                    id="default-checkbox"
                                                                    type="checkbox"
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                                />
                                                                <span
                                                                    for="default-checkbox"
                                                                    class="ml-2 font-medium text-gray-900 uppercase dark:text-gray-300"
                                                                    >{{
                                                                        permission.name.split(
                                                                            "_"
                                                                        )[0]
                                                                    }}</span
                                                                >
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 mt-5">
                    <span class="p-float-label">
                        <Textarea class="w-full"
                            v-model="form.description"
                            autoResize
                            rows="3"
                        />
                        <label>Description</label>
                    </span>
                </div>
                <div
                    class="flex justify-end items-center p-6 space-x-2 rounded-b dark:border-gray-600"
                >
                    <Link :href="route('roles.index')">
                        <button
                            type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        >
                            Back
                        </button>
                    </Link>
                    <button
                        type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Create
                    </button>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@dashboard/AdminLayout.vue";
import { watch, defineEmits, defineProps, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { Link } from "@inertiajs/vue3";
import Textarea from "primevue/textarea";
const emit = defineEmits(["created"]);
let props = defineProps(["permissions", "errors", "auth"]);

console.log(props.permissions);
//get only module from permission
let modules = computed(() => {
    let permissions = [];
    props.permissions.forEach((permission) => {
        let perArray = permission.name.split("_");
        permissions.push(perArray[1]);
    });
    return new Set(permissions);
});

//get modules with related permission
let permissions_modules = computed(() => {
    let newArrays = [];
    modules.value.forEach((item, index) => {
        newArrays.push({
            key: index,
            name: item,
            permissions: props.permissions.filter((permission) =>
                permission.name.includes(item)
            ),
        });
    });
    return newArrays;
});
//for form submit
let form = useForm({
    name: "",
    description: "",
    selectedIds: [],
});
// uncheck modules when selectedIds array is empty
let watchSelectedIds = watch(form.selectedIds, (value) => {
    if (value.length <= 0) {
        document.getElementById("check-all").checked = false;
    }
});
// select all permissions
let selectAll = () => {
    form.selectedIds = [];
    let isChecked = document.getElementById("check-all").checked;
    if (isChecked) {
        modules.value.forEach((item, index) => {
            document.getElementById(`module-checkbox-${index}`).checked = true;
            selectByModule(item, index);
        });
    } else {
        modules.value.forEach((item, index) => {
            document.getElementById(`module-checkbox-${index}`).checked = false;
        });
        form.selectedIds = [];
    }
};
//select permission by module
let selectByModule = (item, index) => {
    let isChecked = document.getElementById(`module-checkbox-${index}`).checked;
    if (isChecked) {
        props.permissions.forEach((per) => {
            if (
                per.name.split("_")[1].includes(item) &&
                !form.selectedIds.includes(per.id)
            ) {
                form.selectedIds.push(per.id);
            }
        });
    } else {
        props.permissions.forEach((per) => {
            if (per.name.split("_")[1].includes(item)) {
                form.selectedIds = form.selectedIds.filter(
                    (item) => item != per.id
                );
            }
        });
    }
};
//save role
let saveRole = () => {
    if (!form.name) {
        form.setError("name", "Name field is required!");
    }
    form.post(route("roles.store"), form, {
        onSuccess: () => {
            form.reset();
        },
        onError: (error) => {
            form.setError("name", error?.name);
        },
    });
};
</script>
