<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { ref, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";

import {
  serverParams,
  onColumnFilter,
  searchItems,
  onPageChange,
  onPerPageChange,
  serverPage,
  serverPerPage,
  loadItems,
} from "@Composables/useServerSideDatable.js";
// import avatar4 from "@images/avatars/avatar-4.png";
// let permissions = computed(() => usePage().props.auth.data.permissions);

let props = defineProps(["inactive_plans", "flash"]);
let flash = computed(() => usePage().props.flash)

const actions = ref([
  {
    title: "Edit",
    value: "edit",
  },
  {
    title: "Delete",
    value: "delete",
  },
]);
let columns = [
  {
    label: "",
    field: "id",
    sortable: false,
  },
  {
    label: "Plan Name",
    field: "name",
    sortable: false,
  },
  {
    label: "Description",
    field: "description",
    sortable: false,
  },
  {
    label: "Price",
    field: "price",
    sortable: false,
  },
  {
    label: "No. of Students",
    field: "num_student_profiles",
    sortable: false,
  },
  {
    label: "Storage Space",
    field: "storage_limit",
    sortable: false,
  },
  {
    label: "",
    field: "action",
    sortable: false,
  },
];
serverPage.value = ref(props.inactive_plans.meta.current_page ?? 1);
serverPerPage.value = ref(10);
const items = ["Foo", "Bar"];

let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.inactive_plans?.meta?.per_page,
  setCurrentPage: props?.inactive_plans?.meta?.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});
let form = useForm({
  status: "ACTIVE",
  _method: "PUT",
});
watch(serverPerPage, function (value) {
  onPerPageChange(value);
});
const selectionChanged = (data) => {
  console.log(data.selectedRows);
};

const deletePlan = () => {
    FlashMessage({ flash });
};
const setActive = (id) => {
  form.post(route("plans.change_status", id), {
    onSuccess: () => {
        FlashMessage({ flash });
      onColumnFilter({
        columnFilters: {
          status: "inactive",
        },
      });
    },
    onError: (error) => {},
  });
};
</script>
<template>
  <section>
    <VCard>
      <VCardText class="d-flex flex-wrap gap-4">
        <!-- 👉 Export button -->
        <div class="search-field">
          <VTextField
            @keyup.enter="searchItems"
            v-model="serverParams.search"
            density="compact"
            placeholder="Search Subscription Plans"
            variant="solo"
          />
        </div>
        <VSpacer />
      </VCardText>

      <VDivider />

      <vue-good-table
        class="role-data-table"
        mode="remote"
        @column-filter="onColumnFilter"
        :totalRows="props.inactive_plans.meta.total"
        :selected-rows-change="selectionChanged"
        styleClass="vgt-table "
        :pagination-options="options"
        :rows="props.inactive_plans.data"
        :columns="columns"
        :select-options="{
          enabled: true,
          selectOnCheckboxOnly: true,
        }"
      >
        <template #table-row="dataProps">
          <div v-if="dataProps.column.field === 'name'">
            <Link :href="route('plans.show', dataProps.row.id)">
              <p>{{ dataProps.row.name }}</p>
            </Link>
          </div>
          <div v-if="dataProps.column.field == 'action'">
            <VMenu location="end">
              <template #activator="{ props }">
                <VIcon
                  v-bind="props"
                  size="24"
                  icon="mdi-dots-horizontal"
                  color="black"
                  class="mt-n4"
                />
              </template>
              <VList>
                <VListItem @click="() => router.get(route('plans.edit', dataProps.row.id))">
                  <VListItemTitle>Edit</VListItemTitle>
                </VListItem>
                <VListItem @click="setActive(dataProps.row.id)">
                  <VListItemTitle>Set Active</VListItemTitle>
                </VListItem>
              </VList>
            </VMenu>
          </div>
        </template>
        <template #pagination-bottom>
          <VRow class="pa-4">
            <VCol cols="12" class="d-flex justify-space-between">
              <span>
                Showing
                {{ props.inactive_plans.meta.from }} to
                {{ props.inactive_plans.meta.to }} of
                {{ props.inactive_plans.meta.total }}
                entries
              </span>
              <div class="d-flex">
                <div class="d-flex align-center">
                  <span class="me-2">Show</span>
                  <VSelect
                    v-model="serverPerPage"
                    density="compact"
                    :items="options.perPageDropdown"
                  >
                  </VSelect>
                </div>
                <VPagination
                  v-model="serverPage"
                  size="small"
                  :total-visible="5"
                  :length="props.inactive_plans.meta.last_page"
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
</template>

<style lang="scss">
.vgt-table th {
  font-size: 10pt !important;
}

.inactive-plan-title {
  font-size: 20px !important;
  color: rgb(0, 0, 0, 0.6);
}

.vgt-table th.vgt-checkbox-col {
  background: rgb(var(--v-theme-surface)) !important;
  padding: 15px;
  border-right: none;
  border-bottom: 1px solid #dcdfe6;
}

// .v-input__control {
//     height: 50px !important;
//     top: 10px !important;
// }

// .v-input__control .v-label.v-field-label {
//     top: 10px !important;
// }
</style>
height: 50px !important;
