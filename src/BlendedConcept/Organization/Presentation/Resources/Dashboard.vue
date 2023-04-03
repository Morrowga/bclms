<template>
  <OrganizationDashboard />
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; // optional
import Row from "primevue/row";
import OrganizationDashboard from "@Layouts/Dashboard/OrganizationDashboard.vue";

let auth = computed(() => usePage().props.auth);
</script>
