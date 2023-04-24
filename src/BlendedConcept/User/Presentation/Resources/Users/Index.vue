<script setup>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import { useUserListStore } from "@/views/apps/user/useUserListStore";
import { avatarText } from "@core/utils/formatters";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import MoreBtn from "@core/components/MoreBtn.vue";
import { computed, defineProps } from "vue";
let props = defineProps(["users", "roles_name", "flash", "auth"]);
let users = computed(() => usePage().props.auth.data.users);
import Swal from "sweetalert2";
let currentPermission = ref();
let serverPage = ref(props.users.meta.current_page ?? 1);
let serverPerPage = ref(10);
// ## add users
const addNewUser = (userData) => {
  console.log(userData);
  form.name = userData.name;
  form.description = userData.description;
  form._method = "POST";
  form.post(route("users.store"), {
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
    route("users.update", {
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
// ## delete user
const deleteUser = (id) => {
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
      router.delete(`users/${id}`, {
        onSuccess: () => {},
      });
    }
  });
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
    //   filterDropdownItems: props.users_name, // dropdown (with selected values) instead of text input
    //   trigger: "enter", //only trigger on enter not on keyup
    // },
  },
  {
    label: "email",
    field: "email",
    sortable: false
    // filterOptions: {
    //   styleClass: "class1", // class to be added to the parent th element
    //   enabled: true, // enable filter for this column
    //   placeholder: "Filter All", // placeholder for filter input
    //   filterDropdownItems: props.users_name, // dropdown (with selected values) instead of text input
    //   trigger: "enter", //only trigger on enter not on keyup
    // },
  },
  {
    label: "Roles",
    field: "roles",
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
    label: "Register At",
    field: "created_at",
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
  perPage: props.users?.meta?.per_page,
  setCurrentPage: props?.users?.meta?.current_page,
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
              placeholder="Search Users"
              density="compact"
            />
            <!-- 👉 Add User button -->
            <Create :roles="roles_name" />
          </div>
        </VCardText>

        <VDivider />

        <vue-good-table
          class="user-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.users.meta.total"
          styleClass="vgt-table "
          :pagination-options="options"
          :rows="props.users.data"
          :columns="columns"
        >
          <template #table-row="props">
            <!-- <span>{{props.row}}</span> -->
            <div v-if="props.column.field == 'roles'" class="flex flex-wrap">
              <VChip
                color="primary"
                v-for="role in props.row.roles"
                :key="role.id"
              >
                {{ role.name }}
              </VChip>
            </div>
            <div
              v-if="props.column.field == 'created_at'"
              class="flex flex-wrap"
            >
              {{ moment(props.row.created_at).format("DD-MM-YYYY h:mm A") }}
            </div>
            <div v-if="props.column.field == 'action'">
              <div class="d-flex">
                <Edit :user="props.row" :roles="roles_name" />

                <VBtn
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2 bg-error"
                  v-if="props.row.roles[0].name !== 'superadmin'"
                  @click="deleteUser(props.row.id)"
                >
                </VBtn>
              </div>
            </div>
          </template>
          <template #pagination-bottom>
            <VRow class="pa-4">
              <VCol cols="12" class="d-flex justify-space-between">
                <span
                  >Showing {{ props.users.meta.from }} to
                  {{ props.users.meta.to }} of
                  {{ props.users.meta.total }} entries</span
                >
                <VPagination
                  v-model="serverPage"
                  size="small"
                  :total-visible="5"
                  :length="props.users.meta.last_page"
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
.user-data-table table.vgt-table {
  background-color: rgb(var(--v-theme-surface));
  border-color: rgb(var(--v-theme-surface));
}
.user-data-table table.vgt-table td {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.user-data-table table.vgt-table thead th {
  background: rgb(var(--v-theme-surface)) !important;
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
