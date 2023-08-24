<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import UserDemographic from "./components/UserDemographic.vue";
import Organization from "./components/Organization.vue";
import Usage from "./components/Usage.vue";
import BookInteractivity from "./components/BookInteractivity.vue";
import { ref } from "vue";
let tabName = ref("user_demographic");
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
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <span class="report-text ruddy-bold">Reports</span>
                </VCol>
                <VCol cols="12">
                    <div
                        class="d-flex align-center flex-wrap"
                        style="gap: 10px"
                    >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('user_demographic')"
                            @click="activeTab('user_demographic')"
                            >User Demographic</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('organization')"
                            @click="activeTab('organization')"
                            >Organization</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('usage')"
                            @click="activeTab('usage')"
                            >Usage</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('book_interactivity')"
                            @click="activeTab('book_interactivity')"
                            >Book Interactivity</VBtn
                        >
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" v-if="tabName == 'user_demographic'">
                    <UserDemographic />
                </VCol>
                <VCol cols="12" v-if="tabName == 'organization'">
                    <Organization />
                </VCol>
                <VCol cols="12" v-if="tabName == 'usage'">
                    <Usage />
                </VCol>
                <VCol cols="12" v-if="tabName == 'book_interactivity'">
                    <BookInteractivity />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.report-text {
    color: var(--graphite, #282828) !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.inactive-border {
    border: 1px solid var(--line, #e5e5e5);
}
</style>
