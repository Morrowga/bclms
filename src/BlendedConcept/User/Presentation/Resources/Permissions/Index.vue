<script setup>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";

//## start variable section
let props = defineProps(["permissions", "flash", "auth"]);
let permissions = computed(() => usePage().props.auth.data.permissions);
const form = useForm({
  name: "",
  description: "",
  _method: "",
});
let currentPermission = ref();
const isAddNewPermissionDrawerVisible = ref(false);
const isEditPermissionDrawerVisible = ref(false);
let serverPage = ref(props.permissions.meta.current_page ?? 1);
let serverPerPage = ref(10);
//## end variable section
let serverError = ref({
  name: "",
});
//## start add permission and save in database
const addNewPermission = (userData) => {
  form.name = userData.name;
  form.description = userData.description;
  form._method = "POST";
  form.post(route("permissions.store"), {
    onSuccess: () => {
      isAddNewPermissionDrawerVisible.value = false;
    },
    onError: (error) => {
      serverError.value.name = error?.name;
    },
  });
};
//## end permission and save in database

//## start update permission and update in database
const updatePermission = (userData) => {
  console.log(userData);
  form.name = userData.name;
  form.description = userData.description;
  form._method = "PUT";
  form.post(
    route("permissions.update", {
      id: currentPermission.value.id,
    }),
    {
      onSuccess: () => {
        isEditPermissionDrawerVisible.value = false;
      },
      onError: (error) => {
        serverError.value.name = error?.name;
      },
    }
  );
};
//## end update permission and update in database

//## start delete permission and delete in database
const deletePermission = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`permissions/${id}`, {
        onSuccess: () => {},
      });
    }
  });
};
//## end delete permission and delete in database

//## start open model for edit
const openEditModel = (permission) => {
  serverError.value.name = "";
  currentPermission.value = permission;
  isEditPermissionDrawerVisible.value = true;
};
//## end open model for edit

//start datatable section
let columns = [
  {
    label: "Permission Name",
    field: "name",
    sortable: false,
    // filterOptions: {
    //   styleClass: "class1", // class to be added to the parent th element
    //   enabled: true, // enable filter for this column
    //   placeholder: "Filter All", // placeholder for filter input
    //   filterDropdownItems: ["access", "edit", "show", "create", "delete"], // dropdown (with selected values) instead of text input
    //   trigger: "enter", //only trigger on enter not on keyup
    // },
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
  // {
  //   label: "Action",
  //   field: "action",
  //   sortable: false,
  // },
];
//## initial state
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

//## options for datatable
let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.permissions.meta.per_page,
  setCurrentPage: props.permissions.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

//## updateParams
let updateParams = (newProps) => {
  serverParams.value = Object.assign({}, serverParams.value, newProps);
};

//## page change on pagination
let onPageChange = () => {
  updateParams({ page: serverPage.value });
  loadItems();
};

//## perpage change selectbox
let onPerPageChange = (value) => {
  serverPage.value = 1;
  updateParams({ page: 1, perPage: value });
  loadItems();
};

//## watch per page change in datatable
watch(serverPerPage, function (value) {
  onPerPageChange(value);
});

//## filter folumn by name
let onColumnFilter = (params) => {
  updateParams(params);
  serverParams.value.page = 1;
  loadItems();
};

//## query params to controller
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

//## search items
let searchItems = () => {
  updateParams({ page: 1 });
  loadItems();
};
//## load items is what brings back the rows from server
let loadItems = () => {
  router.get(route(route().current()), getQueryParams(), {
    replace: false,
    preserveState: true,
    preserveScroll: true,
  });
};
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
//## end datatable section
</script>

<template>
  <AdminLayout>
    <section>
      <VCard>
        <VCardText class="d-flex flex-wrap gap-4">
          <!-- 👉 Export button -->
          <div class="d-flex align-center">
            <span class="me-2">Show</span>
            <VSelect
              v-model="serverPerPage"
              density="compact"
              :items="options.perPageDropdown"
            ></VSelect>
          </div>

          <VSpacer />

          <div class="app-user-search-filter d-flex align-center gap-6">
            <!-- 👉 Search  -->
            <VTextField
              @keyup.enter="searchItems"
              v-model="serverParams.search"
              placeholder="Search Permission"
              density="compact"
            />

            <!-- 👉 Add Permission button -->
            <!-- <VBtn @click="isAddNewPermissionDrawerVisible = true">
              Add Permission
            </VBtn> -->
          </div>
        </VCardText>

        <VDivider />

        <vue-good-table
          class="permission-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.permissions.meta.total"
          styleClass="vgt-table "
          :pagination-options="options"
          :rows="props.permissions.data"
          :columns="columns"
        >
          <template #table-row="props">
            <div v-if="props.column.field == 'name'" class="flex flex-wrap">
              <span class="">{{ props.row.name }}</span>
            </div>
            <div
              v-if="props.column.field == 'description'"
              class="flex flex-wrap"
            >
              <span>{{ truncatedText(props.row.description) }}</span>
            </div>
            <div v-if="props.column.field == 'action'">
              <div class="d-flex">
                <!-- <VBtn
                  density="compact"
                  icon="mdi-pencil"
                  class="ml-2 bg-success"
                  @click="openEditModel(props.row)"
                >
                </VBtn> -->

                <!-- <VBtn
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2 bg-error"
                  @click="deletePermission(props.row.id)"
                >
                </VBtn> -->
              </div>
            </div>
          </template>
          <template #pagination-bottom>
            <VRow class="pa-4">
              <VCol cols="12" class="d-flex justify-space-between">
                <span
                  >Showing {{ props.permissions.meta.from }} to
                  {{ props.permissions.meta.to }} of
                  {{ props.permissions.meta.total }} entries</span
                >
                <VPagination
                  v-model="serverPage"
                  size="small"
                  :total-visible="5"
                  :length="props.permissions.meta.last_page"
                  @next="onPageChange"
                  @prev="onPageChange"
                  @click="onPageChange"
                />
              </VCol>
            </VRow>
          </template>
        </vue-good-table>

        <VDivider />
      </VCard>

      <!-- 👉 Add New Permission -->
      <Create
        :serverError="serverError"
        v-model:isDrawerOpen="isAddNewPermissionDrawerVisible"
        @data="addNewPermission"
      />
      <Edit
        :serverError="serverError"
        v-model:isDrawerOpen="isEditPermissionDrawerVisible"
        @data="updatePermission"
        :permission="currentPermission"
      />
    </section>
  </AdminLayout>
</template>

<style lang="scss">
//## style for darkmode
.permission-data-table table.vgt-table {
  background-color: rgb(var(--v-theme-surface));
  border-color: rgb(var(--v-theme-surface));
}
.permission-data-table table.vgt-table td {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.permission-data-table table.vgt-table thead th {
  background: rgb(var(--v-theme-surface)) !important;
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.app-user-search-filter {
  inline-size: 24.0625rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
