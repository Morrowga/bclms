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
let props = defineProps(["permissions", "flash", "auth"]);
const searchQuery = ref("");
const selectedName = ref();
const rowPerPage = ref(10);
const currentPage = ref(1);
const totalPage = ref(1);
const totalUsers = ref(0);
const users = ref([]);
const form = useForm({
  name: "",
  description: "",
  _method: "",
});
let currentPermission = ref();
// 👉 Fetching users
const fetchUsers = () => {};

watchEffect(fetchUsers);

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value) currentPage.value = totalPage.value;
});

// 👉 search filters
const names = [];
const isAddNewUserDrawerVisible = ref(false);
const isEditUserDrawerVisible = ref(false);

// 👉 watching current page
watchEffect(() => {
  if (currentPage.value > totalPage.value) currentPage.value = totalPage.value;
});

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = users.value.length
    ? (currentPage.value - 1) * rowPerPage.value + 1
    : 0;
  const lastIndex =
    props.permissions.length + (currentPage.value - 1) * rowPerPage.value;

  return `${firstIndex}-${lastIndex} of ${totalUsers.value}`;
});

// SECTION Checkbox toggle
const selectedRows = ref([]);
const selectAllPermissions = ref(false);

// 👉 add/remove all checkbox ids in array
const selectUnselectAll = () => {
  selectAllPermissions.value = !selectAllPermissions.value;
  if (selectAllPermissions.value) {
    props.permissions.forEach((permission) => {
      if (!selectedRows.value.includes(`check${permission.id}`))
        selectedRows.value.push(`check${permission.id}`);
    });
  } else {
    selectedRows.value = [];
  }
};

// 👉 watch if checkbox array is empty all select should be uncheck
watch(
  selectedRows,
  () => {
    if (!selectedRows.value.length) selectAllPermissions.value = false;
  },
  { deep: true }
);

const addRemoveIndividualCheckbox = (checkID) => {
  if (selectedRows.value.includes(checkID)) {
    const index = selectedRows.value.indexOf(checkID);

    selectedRows.value.splice(index, 1);
  } else {
    selectedRows.value.push(checkID);
    selectAllPermissions.value = true;
  }
};

const addNewUser = (userData) => {
  form.name = userData.name;
  form.description = userData.description;
  form._method = "POST";
  form.post(route("permissions.store"), {
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
    route("permissions.update", {
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
      router.delete(`permissions/${id}`, {
        onSuccess: () => {},
      });
    }
  });
};
// const computedMoreList = computed(() => {
//   return (paramId) => [
//     {
//       title: "View",
//       value: "view",
//       prependIcon: "mdi-eye-outline",
//       to: {
//         name: "apps-user-view-id",
//         params: { id: paramId },
//       },
//     },
//     {
//       title: "Edit",
//       value: "edit",
//       prependIcon: "mdi-pencil-outline",
//     },
//     {
//       title: "Delete",
//       value: "delete",
//       prependIcon: "mdi-delete-outline",
//     },
//   ];
// });
const perPageChange = (e) => {
  alert("hello");
};
const openEditModel = (permission) => {
  console.log(permission);
  currentPermission.value = permission;
  isEditUserDrawerVisible.value = true;
};
</script>

<template>
  <AdminLayout>
    <section>
      <VCard>
        <VCardText class="d-flex flex-wrap gap-4">
          <!-- 👉 Export button -->
          <VBtn
            variant="tonal"
            color="secondary"
            prepend-icon="mdi-tray-arrow-up"
          >
            Export
          </VBtn>

          <VSpacer />

          <div class="app-user-search-filter d-flex align-center gap-6">
            <!-- 👉 Search  -->
            <VTextField
              v-model="searchQuery"
              placeholder="Search User"
              density="compact"
            />

            <!-- 👉 Add user button -->
            <VBtn @click="isAddNewUserDrawerVisible = true"> Add User </VBtn>
          </div>
        </VCardText>

        <VDivider />

        <VTable class="text-no-wrap table-header-bg rounded-0">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th scope="col" style="width: 3rem">
                <VCheckbox
                  :model-value="selectAllPermissions"
                  :indeterminate="
                    permissions.length !== selectedRows.length &&
                    !!selectedRows.length
                  "
                  class="mx-1"
                  @click="selectUnselectAll"
                />
              </th>
              <th scope="col">Name</th>
              <th scope="col">ACTIONS</th>
            </tr>
          </thead>

          <!-- 👉 table body -->
          <tbody>
            <tr v-for="permission in props.permissions" :key="permission.id">
              <!-- 👉 Checkbox -->
              <td>
                <VCheckbox
                  :id="`check${permission.id}`"
                  :model-value="selectedRows.includes(`check${permission.id}`)"
                  class="mx-1"
                  @click="addRemoveIndividualCheckbox(`check${permission.id}`)"
                />
              </td>

              <!-- 👉 User -->
              <td>
                <div class="d-flex align-center">
                  <div class="d-flex flex-column">
                    <h6 class="text-sm">
                      <Link href="#" class="font-weight-medium user-list-name">
                        {{ permission.name }}
                      </Link>
                    </h6>
                    <span class="text-xs">@{{ permission.name }}</span>
                  </div>
                </div>
              </td>
              <!-- 👉 Actions -->
              <td class="text-center" style="width: 5rem">
                <div class="d-flex">
                  <!-- <VBtn density="compact" icon="mdi-eye" class="ml-2"> </VBtn> -->
                  <VBtn
                    density="compact"
                    icon="mdi-pencil"
                    class="ml-2 bg-success"
                    @click="openEditModel(permission)"
                  >
                  </VBtn>

                  <VBtn
                    density="compact"
                    icon="mdi-trash"
                    class="ml-2 bg-error"
                    @click="deletePermission(permission.id)"
                  >
                  </VBtn>
                </div>
              </td>
            </tr>
          </tbody>

          <!-- 👉 table footer  -->
          <tfoot v-show="!permissions.length">
            <tr>
              <td colspan="7" class="text-center">No data available</td>
            </tr>
          </tfoot>
        </VTable>

        <VDivider />
      </VCard>

      <!-- 👉 Add New User -->
      <Create
        v-model:isDrawerOpen="isAddNewUserDrawerVisible"
        @user-data="addNewUser"
      />
      <Edit
        v-model:isDrawerOpen="isEditUserDrawerVisible"
        @user-data="updateUser"
        :permission="currentPermission"
      />
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
