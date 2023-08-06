<script setup>
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import {  usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";

import deleteItem from "@Composables/useDeleteItem.js";
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
//## start variable section
let props = defineProps([
  "announcements",
  "flash",
  "auth",
  "users",
  "organizations",
]);
let currentAnnouncement = ref();
const isAddNewAnnouncementDrawerVisible = ref(false);
const isEditAnnouncementDrawerVisible = ref(false);
serverPage.value = ref(props.announcements.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
serverPerPage.value = ref(10);


//## start delete announcement and delete in database
const deleteAnnouncement = (id) => {
  deleteItem(id, "announcements");
};
//## end delete announcement and delete in database

//start datatable section
let columns = [
  {
    label: "TITLE",
    field: "title",
    sortable: false,
  },
  {
    label: "MESSAGE",
    field: "message",
    sortable: false,
  },
  {
    label: "ANNOUNCEMENT BY",
    field: "created_by",
    sortable: false,
  },
  {
    label: "ANNOUNCEMENT To",
    field: "send_to",
    sortable: false,
  },

  {
    label: "ACTION",
    field: "action",
    sortable: false,
  },
];

//## options for datatable
let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.announcements.meta.per_page,
  setCurrentPage: props.announcements.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

//## watch per page change in datatable
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
          <!-- 👉 Search  -->
          <VTextField
            @keyup.enter="searchItems"
            v-model="serverParams.search"
            placeholder="Search Announcement"
            density="compact"
          />
          <VSpacer />

          <div class="app-user-search-filter d-flex justify-end align-center">
            <!-- 👉 Add Announcement button -->
            <VBtn v-if="permissions.includes('create_organization')" class="tiggie-btn">
                            <Link :href="route('announcements.create')" class="text-white"> Add New </Link>
            </VBtn>
          </div>
        </VCardText>

        <VDivider />

        <vue-good-table
          class="announcement-data-table"
          mode="remote"
          @column-filter="onColumnFilter"
          :totalRows="props.announcements.meta.total"
          styleClass="vgt-table"
          :pagination-options="options"
          :rows="props.announcements.data"
          :columns="columns"
        >
          <template #table-row="props">
            <div v-if="props.column.field == 'title'" class="flex flex-wrap">
              <span class="">{{ props.row.title }}</span>
            </div>
            <div v-if="props.column.field == 'message'" class="flex flex-wrap">
              <span>{{ truncatedText(props.row.message) }}</span>
            </div>
            <div
              v-if="props.column.field == 'created_by'"
              class="flex flex-wrap"
            >
              <span>{{ truncatedText(props.row.created_by.name) }}</span>
            </div>
            <div v-if="props.column.field == 'send_to'" class="flex flex-wrap">
              <span>{{ truncatedText(props.row.send_to.name) }}</span>
            </div>

            <div v-if="props.column.field == 'action'">
              <div class="d-flex">
                <Edit
                  :users="users"
                  :flash="flash"
                  :organizations="organizations"
                  :announcement="props.row"
                />

                <VBtn
                  density="compact"
                  icon="mdi-trash"
                  class="ml-2"
                  color="secondary"
                  variant="text"
                  v-if="permissions.includes('delete_announcement')"
                  @click="deleteAnnouncement(props.row.id)"
                >
                </VBtn>
              </div>
            </div>
          </template>
          <template #pagination-bottom>
            <VRow class="pa-4">
              <VCol cols="12" class="d-flex justify-space-between">
                <span
                  >Showing {{ props.announcements.meta.from }} to
                  {{ props.announcements.meta.to }} of
                  {{ props.announcements.meta.total }} entries</span
                >
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
                      :length="props.announcements.meta.last_page"
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
  </AdminLayout>
</template>

<style lang="scss">
//## style for darkmode
.announcement-data-table table.vgt-table {
  background-color: rgb(var(--v-theme-surface));
  border-color: rgb(var(--v-theme-surface));
}
.announcement-data-table table.vgt-table td {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.announcement-data-table table.vgt-table thead th {
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
