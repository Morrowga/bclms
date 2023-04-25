<script setup>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import { toastAlert } from "@Composables/useToastAlert";

//## start variable section
let props = defineProps(["roles", "permissions", "auth", "flash"]);
let permissions = computed(() => usePage().props.auth.data.permissions);
const form = useForm({
  name: "",
  description: "",
  _method: "",
});
let currentPermission = ref();
let serverPage = ref(props.roles.meta.current_page ?? 1);
let serverPerPage = ref(10);
//## end variable section

//## start datatable section
let columns = [
  {
    label: "Name",
    field: "name",
    sortable: false,
    // filterOptions: {
    //   styleClass: "class1", // class to be added to the parent th element
    //   enabled: true, // enable filter for this column
    //   placeholder: "Filter All", // placeholder for filter input
    //   filterDropdownItems: props.roles_name, // dropdown (with selected values) instead of text input
    //   trigger: "enter", //only trigger on enter not on keyup
    // },
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
  perPage: props.roles.meta.per_page,
  setCurrentPage: props.roles.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

//## updateParams
let updateParams = (newProps) => {
  serverParams.value = Object.assign({}, serverParams.value, newProps);
};

//## delete role and delete in database
const deleteRole = (id) => {
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
      form.delete(`roles/${id}`, {
        onSuccess: () => {
          toastAlert({
            title: props.flash?.successMessage,
          });
        },
      });
    }
  });
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

//## watch per page change
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
              placeholder="Search Role"
              density="compact"
            />

            <!-- 👉 Add permission button -->
            <Create :permissions="props.permissions" :flash="flash" />
          </div>
        </VCardText>

        <VDivider />

        <vue-good-table
          class="role-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.roles.meta.total"
          styleClass="vgt-table"
          :pagination-options="options"
          :rows="props.roles.data"
          :columns="columns"
        >
          <template #table-row="dataProps">
            <div
              v-if="dataProps.column.field == 'permission'"
              class="flex flex-wrap"
              style="max-width: 600px"
            >
              <v-chip
                v-for="permission in dataProps.row.permissions"
                :key="permission.id"
                class="ma-2"
                color="primary"
                size="small"
                >{{ permission.name }}</v-chip
              >
            </div>
            <div
              v-if="dataProps.column.field == 'description'"
              class="flex flex-wrap"
            >
              <span>{{ truncatedText(dataProps.row.description) }}</span>
            </div>
            <div
              v-if="dataProps.column.field == 'action'"
              class="flex flex-nowrap"
            >
              <div class="d-flex">
                <Edit
                  :permissions="props.permissions"
                  :role="dataProps.row"
                  :flash="flash"
                />
                <VBtn
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2 bg-error"
                  @click="deleteRole(dataProps.row.id)"
                >
                </VBtn>
              </div>
            </div>
          </template>
          <template #pagination-bottom>
            <VRow class="pa-4">
              <VCol cols="12" class="d-flex justify-space-between">
                <span
                  >Showing {{ props.roles.meta.from }} to
                  {{ props.roles.meta.to }} of
                  {{ props.roles.meta.total }} entries</span
                >
                <VPagination
                  v-model="serverPage"
                  size="small"
                  :total-visible="5"
                  :length="props.roles.meta.last_page"
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
    </section>
  </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
  inline-size: 24.0625rem;
}
.role-data-table table.vgt-table {
  background-color: rgb(var(--v-theme-surface));
  border-color: rgb(var(--v-theme-surface));
}
.role-data-table table.vgt-table td {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.role-data-table table.vgt-table thead th {
  background: rgb(var(--v-theme-surface)) !important;
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
