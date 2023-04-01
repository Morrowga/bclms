<template>
  <AdminLayout>
    <form @submit.prevent="updateRole(props.role.id)">
      <div
        class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14"
      >
        <div class="flex mb-4">
          <span class="text-xl">Update</span>
        </div>
        <div class="flex flex-col mb-10">
          <div class="relative">
            <div class="grid grid-cols-12 gap-y-2">
              <div class="col-span-12">
                <div class="mb-6 flex-auto">
                  <NoLabelInput
                    placeholder="Enter Role Name"
                    v-model="form.name"
                    :error="form.errors?.name"
                  />
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
                          <th scope="col" class="px-4 py-4">
                            <div class="flex items-center">
                              <input
                                :id="'check-all-edit' + props.role.id"
                                type="checkbox"
                                @click="selectAll"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                              />
                              <span
                                for="default-checkbox"
                                class="ml-2 font-medium text-gray-900 dark:text-gray-300"
                                >MODULE</span
                              >
                            </div>
                          </th>
                          <th scope="col" class="px-6 py-3">
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
                            <div class="flex items-center">
                              <input
                                :id="role.id + '-edit-checkbox-' + item.key"
                                @click="selectByModule(item.name, item.key)"
                                type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                              />
                              <span
                                for="default-checkbox"
                                class="ml-2 font-medium text-gray-900 dark:text-gray-300 uppercase"
                              >
                                {{ item.name }}
                              </span>
                            </div>
                          </td>
                          <td class="px-4 py-4">
                            <div class="grid grid-cols-4">
                              <div
                                v-for="permission in item.permissions"
                                :key="permission.id"
                                class="flex items-center mt-2"
                              >
                                <input
                                  v-model="form.selectedIds"
                                  :value="permission.id"
                                  id="default-checkbox"
                                  type="checkbox"
                                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <span
                                  for="default-checkbox"
                                  class="ml-2 font-medium text-gray-900 uppercase dark:text-gray-300"
                                  >{{ permission.name.split("_")[0] }}</span
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
            <Textarea
              class="w-full"
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
            <DefaultButton title="Back" />
          </Link>
          <DefaultButton buttonColor="blue" title="Save" type="submit" />
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
<script setup>
import { ref, watch, defineEmits, onMounted, defineProps, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@dashboard/AdminLayout.vue";
import NoLabelInput from "@Composables/NoLabelInput.vue";
import DefaultButton from "@Composables/DefaultButton.vue";
import Textarea from "primevue/textarea";
let emit = defineEmits(["created"]);
let props = defineProps(["permissions", "role"]);
let module_arr = ref([]);
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
  name: props.role.name,
  description: props.role.description,
  selectedIds: [],
});

// uncheck modules when selectedIds array is empty
let watchSelectedIds = watch(form.selectedIds, (value) => {
  if (value.length <= 0) {
    document.getElementById("check-all-edit" + props.role.id).checked = false;
  }
});

// select all permissions
let selectAll = () => {
  form.selectedIds = [];
  let isChecked = document.getElementById(
    "check-all-edit" + props.role.id
  ).checked;
  if (isChecked) {
    modules.value.forEach((item, index) => {
      document.getElementById(
        `${props.role.id}-edit-checkbox-${index}`
      ).checked = true;
      selectByModule(item, index);
    });
  } else {
    modules.value.forEach((item, index) => {
      document.getElementById(
        `${props.role.id}-edit-checkbox-${index}`
      ).checked = false;
    });
    form.selectedIds = [];
  }
};
//select permission by module
let selectByModule = (item, index) => {
  let isChecked = document.getElementById(
    `${props.role.id}-edit-checkbox-${index}`
  ).checked;
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
        form.selectedIds = form.selectedIds.filter((item) => item != per.id);
      }
    });
  }
};
//updateRole
let updateRole = (id) => {
  if (!form.name) {
    form.setError("name", "Name field is required!");
  }
  form.put(route("roles.update", { id: id }), form, {
    onSuccess: () => {
      form.reset();
    },
    onError: (error) => {
      form.setError("name", error?.name);
    },
  });
};
onMounted(() => {
  props.role.permissions.filter((rp) => form.selectedIds.push(rp.id));
  form.name = props.role.name;
});
</script>
