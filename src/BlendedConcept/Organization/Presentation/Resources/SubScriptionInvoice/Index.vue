<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import B2cUser from "./B2cUser.vue"
import OrganizationUser from "./OrganizationUser.vue"
</script>
<template>
  <AdminLayout>
    <h1 class="tiggie-title mb-4">Subscription<V-icon icon="mdi-information-variant-circle"/></h1>
    <h4 class="tiggie-subtitle">B2C Users</h4>
    <VRow>
      <VCol cols="12">
        <B2cUser/>
      </VCol>
    </VRow>
    <h4 class="tiggie-subtitle mt-5">Organizations</h4>
    <VRow>
        <VCol cols="12">
            <OrganizationUser/>
        </VCol>
    </VRow>
  </AdminLayout>
</template>
