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
import { toastAlert } from "@Composables/useToastAlert";
import Swal from "sweetalert2";

let props = defineProps(["organizations", "flash", "auth"]);
let flash = computed(() => usePage().props.flash);

let serverPage = ref(props.organizations.meta.current_page ?? 1);
let serverPerPage = ref(10);

// ## delete organization
const deleteOrganization = (id) => {
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
      router.delete(`organizations/${id}`, {
        onSuccess: () => {
          toastAlert({
            title: flash?.value.successMessage,
          });
        },
      });
    }
  });
};

let columns = [
  {
    label: "ORGANIZATION",
    field: "name",
    sortable: false,
  },
  {
    label: "CONTACT EMAIL",
    field: "contact_email",
    sortable: false,
  },
  {
    label: "PLAN",
    field: "plan",
    sortable: false,
  },
  {
    label: "STATUS",
    field: "created_at",
    sortable: false,
  },
  {
    label: "ACTION",
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
  perPage: props.organizations?.meta?.per_page,
  setCurrentPage: props?.organizations?.meta?.current_page,
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
          <VBtn variant="outlined" color="secondary">Export</VBtn>

          <VSpacer />

          <div class="app-user-search-filter d-flex align-center gap-6">
            <!-- 👉 Search  -->
            <VTextField
              @keyup.enter="searchItems"
              v-model="serverParams.search"
              placeholder="Search Organizations"
              density="compact"
            />
            <!-- 👉 Add User button -->
            <Create :flash="flash" />
          </div>
        </VCardText>
        <VDivider />

        <vue-good-table
          class="user-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.organizations.meta.total"
          styleClass="vgt-table "
          :pagination-options="options"
          :rows="props.organizations.data"
          :columns="columns"
          :select-options="{
            enabled: true,
          }"
        >
          <template #table-row="props">
            <!-- <span>{{props.row}}</span> -->
            <div v-if="props.column.field == 'action'">
              <div class="d-flex">
                <!-- <Edit :user="props.row" :roles="roles_name" :flash="flash" /> -->
                <VBtn
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2"
                  variant="text"
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
                  >Showing {{ props.organizations.meta.from }} to
                  {{ props.organizations.meta.to }} of
                  {{ props.organizations.meta.total }} entries</span
                >
                <div class="d-flex">
                  <div class="d-flex align-center">
                    <span class="me-2">Show</span>
                    <VSelect
                      v-model="serverPerPage"
                      density="compact"
                      :items="options.perPageDropdown"
                    ></VSelect>
                  </div>
                  <VPagination
                    v-model="serverPage"
                    size="small"
                    :total-visible="5"
                    :length="props.organizations.meta.last_page"
                    @next="onPageChange"
                    @prev="onPageChange"
                    @click="onPageChange"
                  />
                </div>
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
