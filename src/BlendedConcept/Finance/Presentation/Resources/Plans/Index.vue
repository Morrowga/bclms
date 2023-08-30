<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ActivePlan from "./planstypes/ActivePlan.vue";
import InactivePlan from "./planstypes/InactivePlan.vue";
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">
                Subscription plans
                <v-tooltip text="Drag rows to re-arrange the order subscription plans are shown">
                    <template v-slot:activator="{ props }">
                        <VIcon icon="mdi-information-variant-circle-outline" size="30" v-bind="props"></VIcon>
                    </template>
                </v-tooltip>
                <!-- icon="mdi-information-variant-circle" -->
            </h1>

            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <ActivePlan />
                </VCol>
                <VCol cols="12" sm="12" lg="12">
                    <InactivePlan />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
