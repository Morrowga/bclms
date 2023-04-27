<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";

let props = defineProps(['users']);
//## start datatable section
let columns = [
  {
    label: "USER",
    field: "name",
    sortable: false,
  },
  {
    label: "EMAIL",
    field: "email",
    sortable: false,
  },
  {
    label: "ROLE",
    field: "role",
    sortable: false,
  },
  {
    label: "PLAN",
    field: "plan",
    sortable: false,
  },
  {
    label: "STATUS",
    field: "status",
    sortable: false,
  },
  {
    label: "ACTION",
    field: "action",
    sortable: false,
  },
];

let rows = props.users;

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

const selectionChanged = (data) => {
  console.log(data.selectedRows);
};
</script>
<template>
  <section>
    <VCard>
      <VCardText class="d-flex flex-wrap gap-4">
        <!-- 👉 Export button -->
        <div class="d-flex align-center">
          <v-btn prepend-icon="mdi-export" variant="outlined" color="secondary"
            >Export</v-btn
          >
        </div>

        <VSpacer />

        <div class="app-user-search-filter d-flex justify-end align-center gap-6">
          <!-- 👉 Search  -->
          <!-- <VTextField placeholder="Search Role" density="compact" /> -->

          <!-- 👉 View More button -->
          <v-btn>View More</v-btn>
        </div>
      </VCardText>

      <VDivider />

      <vue-good-table
        class="role-data-table"
        styleClass="vgt-table"
        v-on:selected-rows-change="selectionChanged"
        :columns="columns"
        :rows="rows"
        :select-options="{
          enabled: true,
        }"
        :pagination-options="{
          enabled: true,
        }"
      >
        <template #table-row="dataProps">
          <div v-if="dataProps.column.field == 'user'" class="flex flex-nowrap">
            <VListItem class="pa-0">
              <!-- 👉 Avatar  -->
              <template #prepend>
                <VAvatar rounded :size="38" class="me-3" :image="avatar4" />
              </template>

              <!-- 👉 Title and Subtitle -->
              <VListItemTitle class="text-sm font-weight-semibold mb-1">
                {{ dataProps.row.user }}
              </VListItemTitle>

              <VListItemSubtitle
                class="text-xs text-no-wrap d-flex align-center"
              >
                <span> {{ dataProps.row.email }}</span>
              </VListItemSubtitle>
            </VListItem>
          </div>
          <div
            v-if="dataProps.column.field == 'role'"
            class="flex flex-nowrap"
          >
          <VChip
              size="small"
              color="primary">

            {{ dataProps.row?.roles[0]?.name }}
         </VChip>
         </div>
          <div
            v-if="dataProps.column.field == 'plan'"
            class="flex flex-nowrap"
          >
           &minus;
         </div>
          <div
            v-if="dataProps.column.field == 'status'"
            class="flex flex-nowrap"
          >
            <VChip
              size="small"
              color="success"
              v-if="dataProps.row.email_verified_at"
              >
              verify
              </VChip
            >
          </div>
          <div
            v-if="dataProps.column.field == 'action'"
            class="flex flex-nowrap"
          >
            <div class="d-flex">
              <VBtn
                variant="text"
                color="secondary"
                density="compact"
                icon="mdi-eye-outline"
                class="ml-2"
              >
              </VBtn>
            </div>
          </div>
        </template>
      </vue-good-table>

      <VDivider />
    </VCard>
  </section>
</template>

<style lang="scss" >
.vgt-table th {
  font-size: 10pt !important;
}
.vgt-table th.vgt-checkbox-col {
  background: rgb(var(--v-theme-surface)) !important;
  padding: 15px;
  border-right: none;
  border-bottom: 1px solid #dcdfe6;
}
.vgt-wrap__footer
{
  background: rgb(var(--v-theme-surface)) !important;
  border:none;
   color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

</style>
