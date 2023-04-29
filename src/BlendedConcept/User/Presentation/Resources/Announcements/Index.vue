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
let props = defineProps([
  "announcements",
  "flash",
  "auth",
  "users",
  "organizations",
]);
console.log("ann", props.users);
const form = useForm({
  title: "",
  message: "",
  created_by: "",
  send_to: "",
  _method: "",
});
let currentAnnouncement = ref();
const isAddNewAnnouncementDrawerVisible = ref(false);
const isEditAnnouncementDrawerVisible = ref(false);
let serverPage = ref(props.announcements.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
let serverPerPage = ref(10);
//## end variable section
let serverError = ref({
  title: "",
});

//## start add announcement and save in database
const addNewAnnouncement = (announcementData) => {
  form.title = announcementData.title;
  form.message = announcementData.message;
  form.created_by = announcementData.created_by;
  form.send_to = announcementData.send_to;
  form._method = "POST";
  form.post(route("announcements.store"), {
    onSuccess: (data) => {
      toastAlert({
        title: props.flash?.successMessage,
      });
      isAddNewAnnouncementDrawerVisible.value = false;
    },
    onError: (error) => {
      serverError.value.title = error?.title;
    },
  });
};
//## end Announcement and save in database

//## start update announcement and update in database
const updateAnnouncement = (announcementData) => {
  form.title = announcementData.title;
  form.message = announcementData.message;
  form.created_by = announcementData.created_by;
  form.send_to = announcementData.send_to;
  form._method = "PUT";
  form.post(
    route("announcements.update", {
      id: currentAnnouncement.value.id,
    }),
    {
      onSuccess: () => {
        toastAlert({
          title: props.flash?.successMessage,
        });
        isEditAnnouncementDrawerVisible.value = false;
      },
      onError: (error) => {
        serverError.value.title = error?.title;
      },
    }
  );
};
//## end update announcement and update in database

//## start delete announcement and delete in database
const deleteAnnouncement = (id) => {
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
      form.delete(`announcements/${id}`, {
        onSuccess: () => {
          toastAlert({
            title: props.flash?.successMessage,
          });
        },
      });
    }
  });
};
//## end delete announcement and delete in database

//## start open model for edit
const openEditModel = (announcement) => {
  serverError.value.name = "";
  currentAnnouncement.value = announcement;
  isEditAnnouncementDrawerVisible.value = true;
};
//## end open model for edit

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
  perPage: props.announcements.meta.per_page,
  setCurrentPage: props.announcements.meta.current_page,
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
            <VBtn
              @click="isAddNewAnnouncementDrawerVisible = true"
              v-if="permissions.includes('create_announcement')"
            >
              Add Announcement
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
                <VBtn
                  density="compact"
                  icon="mdi-pencil"
                  class="ml-2"
                  color="secondary"
                  variant="text"
                  v-if="permissions.includes('edit_announcement')"
                  @click="openEditModel(props.row)"
                >
                </VBtn>

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

      <!-- 👉 Add New Announcement -->
      <Create
        :serverError="serverError"
        :users="props.users"
        :organizations="props.organizations"
        v-model:isDrawerOpen="isAddNewAnnouncementDrawerVisible"
        @data="addNewAnnouncement"
      />
      <Edit
        :users="props.users"
        :organizations="props.organizations"
        :serverError="serverError"
        v-model:isDrawerOpen="isEditAnnouncementDrawerVisible"
        @data="updateAnnouncement"
        :announcement="currentAnnouncement"
      />
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
