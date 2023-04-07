<template>
  <!-- for superadmin dashboard check -->
  <AdminLayout>
    <div>
      <v-row class="align-stretch">
        <v-col cols="12" md="6" class="d-flex">
          <AnalyticsCongratulationsJohn class="flex-grow-1" />
        </v-col>
        <v-col cols="12" md="6" class="d-flex">
          <EcommerceSalesOverview class="flex-grow-1" />
        </v-col>
      </v-row>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import AnalyticsCongratulationsJohn from "@/views/dashboard/analytics/AnalyticsCongratulationsJohn.vue";
import EcommerceSalesOverview from "@/views/dashboard/ecommerce/EcommerceSalesOverview.vue";
</script>
