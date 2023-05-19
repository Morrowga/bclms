<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
let props = defineProps(["organizations", "flash", "auth"]);
import {
  serverParams,
  onColumnFilter,
  searchItems,
  onPageChange,
  onPerPageChange,
  serverPage,
  serverPerPage,
} from "@Composables/useServerSideDatable.js";
let flash = computed(() => usePage().props.flash);
serverPage.value = ref(props.organizations.meta.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);
import Create from "./Create.vue";
import Edit from "./Edit.vue";

const deleteOrganization = (id) => {
  deleteItem(id, "organizations");
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
    label: "ACTION",
    field: "action",
    sortable: false,
  },
];

let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.organizations?.meta?.per_page,
  setCurrentPage: props?.organizations?.meta?.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
  onPerPageChange(value);
});
</script>


<template>
  <AdminLayout>
    <section>
      <VCard>
        <VCardText class="d-flex flex-wrap gap-4">
          <!-- 👉 Export button -->
          <VBtn prepend-icon="mdi-export" variant="outlined" color="secondary"
            >Export</VBtn
          >
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
            <Create
              :flash="flash"
              v-if="permissions.includes('create_organization')"
            />
          </div>
        </VCardText>
        <VDivider />

        <vue-good-table
          class="user-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.organizations.meta.total"
          :selected-rows-change="selectionChanged"
          styleClass="vgt-table "
          :pagination-options="options"
          :rows="props.organizations.data"
          :columns="columns"
          :select-options="{
            enabled: true,
            selectOnCheckboxOnly: true,
          }"
        >
          <template #table-row="props">
            <div v-if="props.column.field == 'plan'">
              <span>{{ props.row?.plan?.name }}</span>
            </div>
            <div v-if="props.column.field == 'action'">
              <div class="d-flex">
                <Edit
                  :organization="props.row"
                  :flash="flash"
                  v-if="permissions.includes('edit_organization')"
                />
                <VBtn
                  v-if="permissions.includes('delete_organization')"
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2"
                  color="secondary"
                  variant="text"
                  @click="deleteOrganization(props.row.id)"
                >
                </VBtn>
              </div>
            </div>
          </template>
          <template #pagination-bottom>
            <VRow class="pa-4">
              <VCol cols="12" class="d-flex justify-space-between">
                <span>
                  Showing
                  {{ props.organizations.meta.from }} to
                  {{ props.organizations.meta.to }} of
                  {{ props.organizations.meta.total }}
                  entries
                </span>
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
