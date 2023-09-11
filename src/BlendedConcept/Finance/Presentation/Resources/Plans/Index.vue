<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ActivePlan from "./planstypes/ActivePlan.vue";
import InactivePlan from "./planstypes/InactivePlan.vue";
import { router } from "@inertiajs/core";
import { onColumnFilter } from "@Composables/useServerSideDatable.js";
let props = defineProps(["plans", "flash"]);
let tabName = ref("active");
const isActiveTab = (tabNameEnter) => {
    return tabName.value == tabNameEnter
        ? "primary"
        : "inactive-tab inactive-border";
};
const activeTab = (tabNameEnter) => {
    tabName.value = tabNameEnter;
    onColumnFilter({
        columnFilters: {
            status: tabNameEnter,
        },
    });
};
onMounted(() => {
    onColumnFilter({
        columnFilters: {
            status: "active",
        },
    });
});
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">
                Subscription plans
                <v-tooltip
                    text="Drag rows to re-arrange the order subscription plans are shown"
                >
                    <template v-slot:activator="{ props }">
                        <VIcon
                            icon="mdi-information-variant-circle"
                            size="30"
                            v-bind="props"
                        ></VIcon>
                    </template>
                </v-tooltip>
            </h1>
            <VRow>
                <VCol cols="12" md="8">
                    <div
                        class="d-flex align-center flex-wrap"
                        style="gap: 10px"
                    >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('active')"
                            @click="activeTab('active')"
                            >Active</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('inactive')"
                            @click="activeTab('inactive')"
                            >Inactive</VBtn
                        >
                    </div>
                </VCol>
                <VCol cols="12" md="4">
                    <div
                        class="d-flex justify-start justify-md-end align-center"
                    >
                        <Link :href="route('plans.create')" class="text-white">
                            <VBtn class="tiggie-btn" height="40">
                                Add Subscription Plan
                            </VBtn>
                        </Link>
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" sm="12" lg="12" v-if="tabName == 'active'">
                    <ActivePlan :active_plans="props.plans" :flash="flash" />
                </VCol>
                <VCol cols="12" sm="12" lg="12" v-if="tabName == 'inactive'">
                    <InactivePlan
                        :inactive_plans="props.plans"
                        :flash="flash"
                    />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
