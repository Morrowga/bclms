<script setup>
import Create from "./Create.vue";
import { useUserListStore } from "@/views/apps/user/useUserListStore";
import { avatarText } from "@core/utils/formatters";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import MoreBtn from "@core/components/MoreBtn.vue";
import { computed, defineProps } from "vue";
let props = defineProps(["roles", "flash", "auth"]);
let permissions = computed(() => usePage().props.auth.data.permissions);
const form = useForm({
  name: "",
  description: "",
  _method: "",
});
let currentPermission = ref();
// 👉 search filters
const names = [];
const isAddNewUserDrawerVisible = ref(false);
const isEditUserDrawerVisible = ref(false);
let serverPage = ref(props.roles.meta.current_page ?? 1);
let serverPerPage = ref(10);

const addNewUser = (userData) => {
  form.name = userData.name;
  form.description = userData.description;
  form._method = "POST";
  form.post(route("roles.store"), {
    onSuccess: () => {},
    onError: (error) => {
      console.log(error);
    },
  });
};
const updateUser = (userData) => {
  console.log(userData);
  form.name = userData.name;
  form.description = userData.description;
  form._method = "PUT";
  form.post(
    route("roles.update", {
      id: currentPermission.value.id,
    }),
    {
      onSuccess: () => {},
      onError: (error) => {
        console.log(error);
      },
    }
  );
};
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
      router.delete(`roles/${id}`, {
        onSuccess: () => {},
      });
    }
  });
};

const openEditModel = (permission) => {
  console.log(permission);
  currentPermission.value = permission;
  isEditUserDrawerVisible.value = true;
};
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
//updateParams
let updateParams = (newProps) => {
  serverParams.value = Object.assign({}, serverParams.value, newProps);
};
//page change on pagination
let onPageChange = () => {
  updateParams({ page: serverPage.value });
  loadItems();
};

// perpage change selectbox
let onPerPageChange = (value) => {
  serverPage.value = 1;
  updateParams({ page: 1, perPage: value });
  loadItems();
};
watch(serverPerPage, function (value) {
  onPerPageChange(value);
});
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
//search items
let searchItems = () => {
  updateParams({ page: 1 });
  loadItems();
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
// delete record
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
              :items="[10, 20, 50]"
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

            <!-- 👉 Add user button -->
            <Create />
          </div>
        </VCardText>

        <VDivider />

        <vue-good-table
          class="data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.roles.meta.total"
          styleClass="vgt-table"
          :pagination-options="options"
          :rows="props.roles.data"
          :columns="columns"
        >
          <template #table-row="props">
            <div
              v-if="props.column.field == 'permission'"
              class="flex flex-wrap"
              style="max-width: 600px"
            >
              <v-chip
                v-for="permission in props.row.permissions"
                :key="permission.id"
                class="ma-2"
                color="primary"
                size="small"
                >{{ permission.name }}</v-chip
              >
            </div>
            <div
              v-if="props.column.field == 'description'"
              class="flex flex-wrap"
            >
              <span>{{ truncatedText(props.row.description) }}</span>
            </div>
            <div v-if="props.column.field == 'action'" class="flex flex-nowrap">
              <div class="d-flex">
                <VBtn
                  density="compact"
                  icon="mdi-pencil"
                  class="ml-2 bg-success"
                >
                </VBtn>

                <VBtn density="compact" icon="mdi-trash" class="ml-2 bg-error">
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

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
