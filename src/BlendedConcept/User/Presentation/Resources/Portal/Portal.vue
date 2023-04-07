<template>
  <FrontendLayout>
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
  </FrontendLayout>
</template>
<script setup>
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import AnalyticsCongratulationsJohn from "@/views/dashboard/analytics/AnalyticsCongratulationsJohn.vue";
import EcommerceSalesOverview from "@/views/dashboard/ecommerce/EcommerceSalesOverview.vue";
</script>
