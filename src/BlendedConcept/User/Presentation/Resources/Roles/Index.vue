<template>
  <AdminLayout>
    <div class="flex flex-wrap justify-content-center gap-2 mb-2">
      <ConfirmDialog group="positionDialog"></ConfirmDialog>
    </div>
    <div class="card flex justify-content-center">
      <Toast />
    </div>
    <div
      class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-4"
    >
      <div class="flex flex-col">
        <div class="relative overflow-x-auto">
          <vue-good-table
            class="data-table"
            mode="remote"
            @page-change="onPageChange"
            @column-filter="onColumnFilter"
            @per-page-change="onPerPageChange"
            :totalRows="props.roles.meta.total"
            :line-numbers="true"
            styleClass="vgt-table striped"
            :pagination-options="options"
            :rows="props.roles.data"
            :columns="columns"
          >
            <template #table-column="props">
              <span
                class="whitespace-nowrap"
                v-if="props.column.label == 'Guard Name'"
              >
                {{ props.column.label }}
              </span>
              <span v-else>
                {{ props.column.label }}
              </span>
            </template>
            <template #table-actions>
              <div class="flex">
                <div class="relative w-full mr-3">
                  <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                  >
                    <svg
                      aria-hidden="true"
                      class="w-5 h-5 text-gray-500 dark:text-gray-400"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </div>
                  <input
                    type="text"
                    id="simple-search"
                    @keyup.enter="loadItems"
                    v-model="serverParams.search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search"
                  />
                </div>
                <Link
                  :href="route('roles.create')"
                  v-if="checkPermission('create_role')"
                >
                  <AddIcon />
                </Link>
              </div>
            </template>
            <template #table-row="props">
              <div
                v-if="props.column.field == 'permission'"
                class="flex flex-wrap"
                style="max-width: 600px"
              >
                <span
                  v-for="permission in props.row.permissions"
                  :key="permission.id"
                  class="bg-blue-100 mt-2 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300"
                  >{{ permission.name }}</span
                >
              </div>
              <div
                v-if="props.column.field == 'description'"
                class="flex flex-wrap"
              >
                <span>{{ truncatedText(props.row.description) }}</span>
              </div>
              <div
                v-if="props.column.field == 'action'"
                class="flex flex-nowrap"
              >
                <IconButton
                  buttonColor="blue"
                  v-if="checkPermission('show_role')"
                >
                  <i class="pi pi-icon pi-eye"></i>
                </IconButton>
                <Link
                  :href="
                    route('roles.edit', {
                      id: props.row.id,
                    })
                  "
                >
                  <IconButton
                    buttonColor="yellow"
                    v-if="checkPermission('edit_role')"
                  >
                    <i class="pi pi-icon pi-file-edit"></i>
                  </IconButton>
                </Link>
                <IconButton
                  @click="deleteRole(props.row.id)"
                  buttonColor="red"
                  v-if="checkPermission('delete_role')"
                >
                  <i
                    class="pi pi-icon pi-delete-left"
                    style="font-size: 1rem"
                  ></i>
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
import AdminLayout from "@dashboard/AdminLayout.vue";
import { computed, onMounted, defineProps, watch, ref } from "vue";
import { router } from "@inertiajs/core";
let props = defineProps([
  "roles",
  "flash",
  "permissions",
  "auth",
  "roles_name",
]);
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { usePage } from "@inertiajs/vue3";
let Confirm = useConfirm();
let toast = useToast();
let permissions = computed(() => usePage().props.auth.data.permissions);
//for datable configuration
let columns = [
  {
    label: "Name",
    field: "name",
    sortable: false,
    filterOptions: {
      styleClass: "class1", // class to be added to the parent th element
      enabled: true, // enable filter for this column
      placeholder: "Filter All", // placeholder for filter input
      filterDropdownItems: props.roles_name, // dropdown (with selected values) instead of text input
      trigger: "enter", //only trigger on enter not on keyup
    },
  },
  {
    label: "Permission",
    field: "permission",
    sortable: false,
  },
  {
    label: "Description",
    field: "description",
    sortable: false,
  },
  {
    label: "Guard Name",
    field: "guard_name",
    sortable: false,
  },
  {
    label: "Action",
    field: "action",
    sortable: false,
  },
];
//initial state
let serverParams = ref({
  columnFilters: {},
  search: "",
  sort: {
    field: "",
    type: "",
  },
  page: 1,
  perPage: 10,
});

// options for datatable
let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.roles.meta.per_page,
  setCurrentPage: props.roles.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});
//deleting role

//updateParams
let updateParams = (newProps) => {
  serverParams.value = Object.assign({}, serverParams.value, newProps);
};
//page change on pagination
let onPageChange = (params) => {
  updateParams({ page: params.currentPage });
  loadItems();
};

// perpage change selectbox
let onPerPageChange = (params) => {
  updateParams({ page: params.currentPage });
};

// filter folumn by name
let onColumnFilter = (params) => {
  updateParams(params);
  serverParams.value.page = 1;
  loadItems();
};

// query params to controller
let getQueryParams = () => {
  let data = {
    page: serverParams.value.page,
    perPage: serverParams.value.perPage,
    search: serverParams.value.search,
  };

  for (const [key, value] of Object.entries(serverParams.value.columnFilters)) {
    if (value) {
      data[key] = value;
    }
  }
  return data;
};
// load items is what brings back the rows from server
let loadItems = () => {
  router.get(route(route().current()), getQueryParams(), {
    replace: false,
    preserveState: true,
    preserveScroll: true,
  });
};
//truncatedText
let truncatedText = (text) => {
  if (text) {
    if (text?.length <= 30) {
      return text;
    } else {
      return text?.substring(0, 30) + "...";
    }
  }
};
//check permission
let checkPermission = (permission) => {
  return permissions.value.includes(permission);
};
//deleting role
let deleteRole = (id) => {
  Confirm.require({
    group: "positionDialog",
    message: "Do you want to delete this record?",
    header: "Delete Confirmation",
    icon: "pi pi-info-circle",
    position: "center",
    accept: () => {
      router.delete(`roles/${id}`, {
        onSuccess: () => {
          toast.add({
            severity: "success",
            summary: "Delected",
            detail: "Roles Delected successfully",
            life: 3000,
          });
        },
      });
    },
    reject: () => {
      toast.add({
        severity: "error",
        summary: "Rejected",
        detail: "You have rejected",
        life: 3000,
      });
    },
  });
};
onMounted(() => {
  //fire alert when user make actions
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
