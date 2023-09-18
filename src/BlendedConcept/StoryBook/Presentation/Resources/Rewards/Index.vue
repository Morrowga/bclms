<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import {
  serverParams,
  onColumnFilter,
  searchItems,
  onPageChange,
  onPerPageChange,
  serverPage,
  serverPerPage,
  truncatedText,
} from "@Composables/useServerSideDatable.js";

let props = defineProps(["rewards"]);

// for database script need

serverPage.value = ref(props.rewards.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
serverPerPage.value = ref(10);
let page = usePage();

let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.rewards.meta.per_page,
  setCurrentPage: props.rewards.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

//## watch per page change in datatable
watch(serverPerPage, function (value) {
  onPerPageChange(value);
});

// for datable script end

//## start datatable section
let columns = [
  {
    label: "Sticker",
    field: "sticker",
    sortable: false,
  },
  {
    label: "Name",
    field: "name",
    sortable: false,
  },
  {
    label: "Description",
    field: "description",
    sortable: false,
  },
  {
    label: "Gold Coins Required",
    field: "gold_coins_needed",
    sortable: false,
  },
  {
    label: "Silver Coins Required",
    field: "silver_coins_needed",
    sortable: false,
  },
  {
    label: "Status",
    field: "status",
    sortable: false,
  },
  {
    label: "",
    field: "action",
    sortable: false,
  },
];

const items = ref([
  {
    title: "Edit",
    value: "edit",
  },
  {
    title: "Delete",
    value: "delete",
  },
]);

const isDiability = ref(false);
const isEditDiability = ref(false);

const showDetail = (params) => {
  //  conso
  router.get(route("rewards.show", { id: params.row.id }));
};
const editRewards = (id) => {
  router.get(route("rewards.edit", { id: id }));
};

const form = useForm({
  id : ""
});

const setInactive = (id) => {
  form.id = id;
  isConfirmedDialog({
    denyButtonText: "Set Inactive",
    onConfirm: () => {
      // Assuming form.post is a valid function for making a POST request
      form.post(`changerewardStatus/${id}`, {
        onSuccess: () => {
          SuccessDialog({ title: flash?.successMessage });
          isDialogVisible.value = false;
        },
        onError: (error) => {
          console.log(error);
        },
      });
    },
  });
};


</script>
<template>
  <AdminLayout>
    <VContainer fluid>
      <h1 class="tiggie-title mb-4">Rewards</h1>
      <VRow>
        <VCol cols="12" sm="12" lg="12">
          <section>
            <VCard>
              <VCardText class="d-flex flex-wrap gap-4">
                <!-- 👉 Export button -->
                <!-- 👉 Search  -->
                <VSpacer />

                <div class="search-field">
                  <VTextField
                    @keyup.enter="searchItems"
                    v-model="serverParams.search"
                    placeholder="Search Announcement"
                    density="compact"
                    class="pr-2"
                    variant="solo"
                  />
                </div>
                <div
                  class="app-user-search-filter d-flex justify-end align-center"
                >
                  <SelectBox
                    :datas="['Name', 'Date Sticker', 'Rewards Issue', 'Status']"
                    placeholder="Sort By"
                    density="compact"
                    variant="solo"
                  />
                  <!-- 👉 Add Announcement button -->
                  <VBtn class="tiggie-btn">
                    <Link :href="route('rewards.create')" class="text-white">
                      Add Rewards
                    </Link>
                  </VBtn>
                </div>
              </VCardText>
              <VDivider />

              <vue-good-table
                class="role-data-table"
                styleClass="vgt-table"
                mode="remote"
                @column-filter="onColumnFilter"
                :totalRows="props.rewards.meta.total"
                :pagination-options="options"
                v-on:selected-rows-change="selectionChanged"
                :columns="columns"
                :rows="props.rewards.data"
                :select-options="{
                  enabled: false,
                }"
                v-on:row-click="showDetail"
              >
                <template #table-row="dataProps">
                  <div v-if="dataProps.column.field == 'sticker'">
                    <div class="d-flex flex-row gap-2">
                      <img src="/images/defaults/reward2.png" />
                    </div>
                  </div>

                  <div v-if="dataProps.column.field == 'status'">
                    <VChip
                      color="success"
                      variant="flat"
                      v-if="dataProps.row.status == 'ACTIVE'"
                    >
                      Active
                    </VChip>
                    <VChip color="error" variant="flat" v-else>
                      Inactive
                    </VChip>
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
                        <VListItem @click="editRewards(dataProps.row.id)">
                          <VListItemTitle>Update</VListItemTitle>
                        </VListItem>
                        <VListItem @click="setInactive(dataProps.row.id)">
                          <VListItemTitle>Set Inactive</VListItemTitle>
                        </VListItem>
                      </VList>
                    </VMenu>
                  </div>
                </template>
                <template #pagination-bottom>
                  <VRow class="pa-4">
                    <VCol cols="12" class="d-flex justify-space-between">
                      <span>
                        Showing {{ props.rewards.meta.from }} to
                        {{ props.rewards.meta.to }} of
                        {{ props.rewards.meta.total }} entries
                      </span>
                      <div>
                        <div class="d-flex align-center">
                          <span class="me-2">Show</span>
                          <VSelect
                            v-model="serverPerPage"
                            density="compact"
                            :items="options.perPageDropdown"
                          ></VSelect>
                          <VPagination
                            v-model="serverPage"
                            size="small"
                            :total-visible="5"
                            :length="props.rewards.meta.last_page"
                            @next="onPageChange"
                            @prev="onPageChange"
                            @click="onPageChange"
                          />
                        </div>
                      </div>
                    </VCol>
                  </VRow>
                </template>
              </vue-good-table>

              <VDivider />
            </VCard>
          </section>
        </VCol>
      </VRow>
    </VContainer>
  </AdminLayout>
</template>

<style scoped>
.custom-progress {
  width: 70%;
}
:deep(.role-data-table .vgt-left-align) {
  vertical-align: middle !important;
  cursor: pointer;
}
</style>
