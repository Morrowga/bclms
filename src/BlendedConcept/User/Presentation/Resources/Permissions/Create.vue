<template>
    <AdminLayout>
        <div
            class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14"
        >
            <div class="flex flex-col mb-10">
                <div class="relative">
                    <h1
                        class="text-left align-middle mt-4 mb-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                    >
                        Permission Create
                    </h1>
                    <form @submit.prevent="saveForm">
                        <div class="grid grid-cols-12 gap-2 align-items-center">
                            <div class="col-span-12 sm:col-span-6">
                                <p
                                    id="filled_error_help"
                                    class="mt-2 text-xs italic text-red-600 dark:text-red-400 pt-4"
                                >
                                    permission need at least one underscore (
                                    ‘_’ ) for creation
                                </p>
                                <NoLabelInput
                                    type="name"
                                    v-model="form.name"
                                    :error="form.errors?.name"
                                    placeholder="Name"
                                />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-12 gap-2 align-items-center">
                            <div class="col-span-12 sm:col-span-6 mt-5">
                                <span class="p-float-label">
                                    <Textarea class="w-full"
                                        v-model="form.description"
                                        autoResize
                                        rows="3"
                                    />
                                    <label>Description</label>
                                </span>
                            </div>
                        </div>

                        

                        <div
                            class="flex justify-end items-center p-6 space-x-2 rounded-b dark:border-gray-600"
                        >
                            <Link :href="route('permissions.index')">
                                <DefaultButton title="Back" />
                            </Link>
                            <DefaultButton
                                buttonColor="blue"
                                title="Create"
                                type="submit"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from "@dashboard/AdminLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import NoLabelInput from "@Composables/NoLabelInput.vue";
import DefaultButton from "@Composables/DefaultButton.vue";
import Textarea from "primevue/textarea";
let props = defineProps(["errors"]);
let form = useForm({
    name: "",
    description: "",
});
let saveForm = () => {
    form.post(route("permissions.store"), {
        onSuccess: () => {},
        onError: (error) => {
            form.setError("name", error?.name),
                form.setError("guard_name", error?.guard_name);
        },
    });
};
</script>
