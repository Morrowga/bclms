<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import B2cUser from "./B2cUser.vue"
</script>
<template>
  <AdminLayout>
    <h1 class="tiggie-title mb-4">Subscription plans<V-icon icon="mdi-information-variant-circle"/></h1>
    <h4>B2C Users</h4>
    <VRow>
      <VCol cols="12" sm="12" lg="12">
        <B2cUser/>
      </VCol>
    </VRow>
  </AdminLayout>
</template>
