<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, onUpdated } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";
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
let props = defineProps(["students", "storybook", "version"]);

serverPage.value = ref(props.students.meta.current_page ?? 1);
let permissions = computed(() => usePage().props.auth.data.permissions);
serverPerPage.value = ref(10);

let options = ref({
  enabled: true,
  mode: "pages",
  perPage: props.students.meta.per_page,
  setCurrentPage: props.students.meta.current_page,
  perPageDropdown: [10, 20, 50, 100],
  dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
  onPerPageChange(value);
});

let columns = [
  {
    label: "Name",
    field: "name",
    sortable: false,
  },
  {
    label: "Education Level",
    field: "education_level",
    sortable: false,
  },
  {
    label: "Age",
    field: "age",
    sortable: false,
  },
  {
    label: "Disability Type",
    field: "disability_types",
    sortable: false,
  },
];

const form = useForm({
  storybook_version_id: props.storybook.id,
  student_ids: [],
});

const selectionChanged = (data) => {
  form.student_ids = data.selectedRows.map((item) => item.student_id);
};

const assignStudent = () => {

  form.post(route("storybookassignment"), {
    onSuccess: () => {
      SuccessDialog({ title: "Assign StoryBook Version Success" });
    },
    onError : (error) => {
        console.log(error)
    }
  });
};
</script>
<template>
  <section>
    <h1 class="assign-std mb-4">StoryBook Versions</h1>
    <v-card max-width="20%" height="300px">
      <v-card-title class="position-relative">
        <v-img :src="storybook.thumbnail_img" />
      </v-card-title>
      <v-card-text>
        <h1 class="font-weight-bold text-h6 text-center pb-4">
          {{ version.name }}
        </h1>
        <p class="text-truncate">
          {{ version.description }}
        </p>
      </v-card-text>
    </v-card>
  </section>
  <section>
    <h1 class="assign-std mb-4">Assign Students</h1>
    <VCard>
      <VCardText class="d-flex flex-wrap gap-4">
        <v-text-field
          @keyup.enter="searchItems"
          v-model="serverParams.search"
          density="compact"
          variant="solo"
          label="Search templates"
          append-inner-icon="mdi-magnify"
          single-line
          hide-details
        ></v-text-field>
      </VCardText>
      <VDivider />

      <vue-good-table
        class="role-data-table"
        styleClass="vgt-table"
        v-on:selected-rows-change="selectionChanged"
        @column-filter="onColumnFilter"
        :totalRows="props.students.meta.total"
        :pagination-options="options"
        :columns="columns"
        :rows="students.data"
        :select-options="{
          enabled: true,
        }"
      >
        <template #table-row="dataProps">
          <div
            v-if="dataProps.column.field == 'name'"
            class="d-flex flex-nowrap align-center gap-10"
          >
            <img :src="dataProps.row.image" class="assign-std-width-high" />
            <span>{{ dataProps.row.full_name }}</span>
          </div>
          <div v-if="dataProps.column.field == 'age'">
            <span>10</span>
          </div>
          <div
            v-if="dataProps.column.field == 'disability_types'"
            class="flex flex-nowrap"
          >
            <div
              v-for="data in dataProps.row.disability_types"
              :key="data.id"
              class="chip mr-2"
            >
              <v-chip prepend-icon="mdi-circle-outline">
                {{ data.name }}
              </v-chip>
            </div>
          </div>
        </template>
        <template #pagination-bottom>
          <VRow class="pa-4">
            <VCol cols="12" class="d-flex justify-space-between">
              <span>
                Showing {{ props.students.meta.from }} to
                {{ props.students.meta.to }} of
                {{ props.students.meta.total }} entries
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
                    :length="props.students.meta.last_page"
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
  <section class="mt-5">
    <v-row>
      <v-col cols="12" class="d-flex justify-center">
        <SecondaryBtn
          class="mr-4"
          title="Back"
          @click="router.get(route('teacher_storybook.show'))"
        />
        <PrimaryBtn title="Assign" :isLink="false" @click="assignStudent()" />
      </v-col>
    </v-row>
  </section>
</template>

<style scoped>
.vgt-table th {
  font-size: 10pt !important;
}
.vgt-table th.vgt-checkbox-col {
  background: rgb(var(--v-theme-surface)) !important;
  padding: 15px;
  border-right: none;
  border-bottom: 1px solid #dcdfe6;
}
.vgt-wrap__footer {
  background: rgb(var(--v-theme-surface)) !important;
  border: none;
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
.chip {
  display: inline-flex;
  flex-direction: row;
  background-color: #e5e5e5;
  border: none;
  cursor: default;
  height: 36px;
  outline: none;
  padding: 0;
  font-size: 14px;
  color: #333333;
  font-family: "Open Sans", sans-serif;
  white-space: nowrap;
  align-items: center;
  border-radius: 16px;
  vertical-align: middle;
  text-decoration: none;
  justify-content: center;
}

.chip-content {
  cursor: inherit;
  display: flex;
  align-items: center;
  user-select: none;
  white-space: nowrap;
  padding-left: 12px;
  padding-right: 12px;
}
.assign-std {
  color: var(--text, #161616);
  /* H3 Ruddy */

  font-size: 40px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
}
.assign-std-width-high {
  width: 60px;
  height: 60px;
}

.position-relative {
  position: relative;
}

.position-absolute {
  position: absolute;
  right: 10px;
  top: 5px;
}
</style>
