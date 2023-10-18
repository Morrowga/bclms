<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import B2cUser from "./B2cUser.vue";
import OrganisationUser from "./OrganisationUser.vue";
let tabName = ref("users");
const props = defineProps([
    "b2b_subscriptions",
    "flash",
    "b2c_subscriptions",
    "plans",
]);
const isActiveTab = (tabNameEnter) => {
    return tabName.value == tabNameEnter
        ? "primary"
        : "inactive-tab inactive-border";
};
const activeTab = (tabNameEnter) => {
    tabName.value = tabNameEnter;
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Subscription</h1>
            <VRow>
                <VCol cols="12" md="8">
                    <div class="d-flex align-center flex-wrap gap-10">
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('users')"
                            @click="activeTab('users')"
                            >B2C Users</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('organisations')"
                            @click="activeTab('organisations')"
                            >Organisations</VBtn
                        >
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" sm="12" lg="12" v-if="tabName == 'users'">
                    <B2cUser
                        :subscriptions="props.b2c_subscriptions"
                        :flash="props.flash"
                        :plans="props.plans"
                    />
                </VCol>
                <VCol
                    cols="12"
                    sm="12"
                    lg="12"
                    v-if="tabName == 'organisations'"
                >
                    <OrganisationUser
                        :subscriptions="props.b2b_subscriptions"
                        :flash="props.flash"
                    />
                </VCol>
            </VRow>
            <!-- <h4 class="tiggie-subtitle">B2C Users</h4>
            <VRow>
                <VCol cols="12">
                    <B2cUser />
                </VCol>
            </VRow>
            <h4 class="tiggie-subtitle mt-5">Organisations</h4>
            <VRow>
                <VCol cols="12">
                    <OrganisationUser />
                </VCol>
            </VRow> -->
        </VContainer>
    </AdminLayout>
</template>
