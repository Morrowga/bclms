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
          <form @submit.prevent="updateForm(props.permission.id)">
            <div class="grid grid-cols-12 gap-2">
              <div class="sm:col-span-6 col-span-12">
                <p
                  id="filled_error_help"
                  class="mt-2 text-xs italic text-red-600 dark:text-red-400"
                >
                  permission need at least one underscore ( ‘_’ ) for creation
                </p>
                <NoLabelInput
                  type="name"
                  v-model="form.name"
                  :error="form.errors?.name"
                  placeholder="Name"
                />
              </div>
            </div>
            <div class="grid grid-cols-12 gap-2 mt-5">
                <div class="sm:col-span-6 col-span-12">
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
              <DefaultButton buttonColor="blue" title="Save" type="submit" />
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
import Textarea from "primevue/textarea";
import DefaultButton from "@Composables/DefaultButton.vue";
let props = defineProps(["errors", "permission"]);

let form = useForm({
  name:props.permission.name,
  description:props?.permission?.description
});
let updateForm = (id) => {
  form.put(route("permissions.update", id), {
    onSuccess: () => {},
    onError: (error) => {
      form.setError("name", error.name);
    },
  });
};
</script>
