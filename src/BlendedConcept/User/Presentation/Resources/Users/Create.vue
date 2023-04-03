<template>
   <AdminLayout>
   <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14">
            <div class="flex flex-col mb-10">
                <div class="relative">
                    <form @submit.prevent="saveForm">
                        <div class="grid grid-cols-12 gap-y-2">
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-left pb-5 align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                                >
                                    User Particulars
                                </h1>


                                <NoLabelSelectInput
                                  v-model="form.role"
                                  :datas="props.roles"
                                  :error="form.errors?.role"
                                  defaultSelected="Please Select Role"/>

                                <NoLabelInput
                                    v-model="form.name"
                                    placeholder="Name"
                                    :type="number"
                                    :error="form.errors?.name"
                                    class="pb-5 pt-5"
                                />
                                <NoLabelInput
                                    v-model="form.contact_number"
                                    placeholder="Contact Number"
                                    :error="form.errors?.contact_number"
                                    class="pb-5"
                                />
                                <NoLabelInput
                                    type="email"
                                    v-model="form.email"
                                    placeholder="Email"
                                    :error="form.errors?.email"
                                    class="pb-5"
                                />
                                <NoLabelInput
                                    type="password"
                                    v-model="form.password"
                                    placeholder="Password"
                                    :error="form.errors?.password"
                                    class="pb-5"
                                />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                                >
                                    Add Profile Picture
                                </h1>

                                <ImageUpload v-model="form.image"/>
                                <div
                                    class="flex justify-end items-center p-6 space-x-2 rounded-b dark:border-gray-600"
                                >
                                    <Link :href="route('users.index')">
                                        <DefaultButton
                                            title="Back"
                                            type="button"
                                        />
                                    </Link>
                                    <DefaultButton
                                        type="submit"
                                        title="Create"
                                        buttonColor="blue"
                                    />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </AdminLayout>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AdminLayout from "@dashboard/AdminLayout.vue";
import Dropdown from "primevue/dropdown"
import ImageUpload  from "@Composables/ImageUpload.vue"
import NoLabelSelectInput from "@Composables/NoLabelSelectInput.vue";
import NoLabelInput from "@Composables/NoLabelInput.vue";
import DefaultButton from "@Composables/DefaultButton.vue";
let props = defineProps(["roles", "errors"]);

let form = useForm({
    name: "",
    contact_number: "",
    email: "",
    role: "selected",
    image: null,
    password: "",
});




let saveForm = () => {
    form.post(route("users.store"), {
        onSuccess: () => {},
        onError: (error) => {
            form.setError("role", error?.role);
            form.setError("name", error?.name);
            form.setError("email", error?.email);
            form.setError("password", error?.password);
            form.setError("contact_number", error?.contact_number);
        },
    });
};
</script>
