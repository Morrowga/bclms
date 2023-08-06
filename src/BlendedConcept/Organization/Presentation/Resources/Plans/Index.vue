<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ActivePlan from "./planstypes/ActivePlan.vue"
import InactivePlan from "./planstypes/InactivePlan.vue"

</script>
<template>
  <AdminLayout>
    <h1 class="tiggie-title mb-4">Subscription plans &nbsp;<V-icon  icon="mdi-information-variant-circle" size="30"/></h1>
    <VRow>
      <VCol cols="12" sm="12" lg="12">
        <ActivePlan/>
      </VCol>
      <VCol cols="12" sm="12" lg="12">
        <InactivePlan/>
      </VCol>
    </VRow>
  </AdminLayout>
</template>
