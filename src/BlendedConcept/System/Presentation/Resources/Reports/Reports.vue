<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import UserDemographic from "./components/UserDemographic.vue";
import Organisation from "./components/Organisation.vue";
import Usage from "./components/Usage.vue";
import BookInteractivity from "./components/BookInteractivity.vue";
import Subscribers from "./components/Subscribers.vue";
import { ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import axios from '@axios'

let tabName = ref("");
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
const isActiveTab = (tabNameEnter) => {
    return tabName.value == tabNameEnter
        ? "primary"
        : "inactive-tab inactive-border";
};
const activeTab = (tabNameEnter) => {
    tabName.value = tabNameEnter;
};

onMounted(() => {
    if (
        user_role.value == "Organisation Admin" ||
        user_role == "BC Super Admin" ||
        user_role == "BC Staff"
    ) {
        tabName.value = "user_demographic";
    } else {
        tabName.value = "usage";
    }
});

const exportExcel = async () => {
    try {
        const response = await axios.post('/reports/excel', null, {
            responseType: 'blob', // Specify the response type as a blob
        });

        // Create a blob URL for the response data
        const url = window.URL.createObjectURL(new Blob([response.data]));

        // Create an anchor element to trigger the download
        const a = document.createElement('a');
        a.href = url;
        a.download = 'excel-reports.xlsx'; // Set the desired file name
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();

        // Cleanup and remove the anchor element
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

    } catch (error) {
        console.error('Error downloading file:', error);
    }
}

const exportGame = async () => {
    try {
        const response = await axios.post('/reports/game-score', null, {
            responseType: 'blob', // Specify the response type as a blob
        });

        // Create a blob URL for the response data
        const url = window.URL.createObjectURL(new Blob([response.data]));

        // Create an anchor element to trigger the download
        const a = document.createElement('a');
        a.href = url;
        a.download = 'game-reports.xlsx'; // Set the desired file name
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();

        // Cleanup and remove the anchor element
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

    } catch (error) {
        console.error('Error downloading file:', error);
    }
}

const exportStorybook = async () => {
    try {
        const response = await axios.post('/reports/storybook-score', null, {
            responseType: 'blob', // Specify the response type as a blob
        });

        // Create a blob URL for the response data
        const url = window.URL.createObjectURL(new Blob([response.data]));

        // Create an anchor element to trigger the download
        const a = document.createElement('a');
        a.href = url;
        a.download = 'book-reports.xlsx'; // Set the desired file name
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();

        // Cleanup and remove the anchor element
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

    } catch (error) {
        console.error('Error downloading file:', error);
    }
}

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="6">
                    <span
                        v-if="
                            user_role == 'BC Super Admin' ||
                            user_role == 'BC Staff'
                        "
                        class="tiggie-title"
                        >Export Data</span
                    >
                    <span v-else class="report-text ruddy-bold">Reports</span>
                </VCol>
                <VCol cols="6"  v-if="
                    user_role == 'Organisation Admin' || user_role == 'B2C Parent' || user_role == 'Teacher' || user_role == 'BC Subscriber' || user_role == 'Both Parent'
                ">
                <div class="text-right">
                    <VBtn prepend-icon="mdi-download" @click="exportGame" class="ruddy-bold text-white">Game Export</VBtn>
                    <VBtn prepend-icon="mdi-download" @click="exportStorybook" class="ruddy-bold text-white mx-2">Storybook Export</VBtn>
                    <VBtn prepend-icon="mdi-download" @click="exportExcel" class="ruddy-bold text-white mx-2">Export</VBtn>
                </div>
                </VCol>
                <VCol cols="12">
                    <div class="d-flex align-center flex-wrap gap-10">
                        <VBtn
                            v-if="
                                user_role == 'Organisation Admin' ||
                                user_role == 'BC Super Admin' ||
                                user_role == 'BC Staff'
                            "
                            variant="flat"
                            rounded
                            :color="isActiveTab('user_demographic')"
                            @click="activeTab('user_demographic')"
                            >User Demographic</VBtn
                        >
                        <VBtn
                            v-if="
                                user_role == 'BC Super Admin' ||
                                user_role == 'BC Staff'
                            "
                            variant="flat"
                            rounded
                            :color="isActiveTab('subscriber')"
                            @click="activeTab('subscriber')"
                            >Subscriber</VBtn
                        >
                        <VBtn
                            v-if="
                                user_role == 'Organisation Admin' ||
                                user_role == 'BC Super Admin' ||
                                user_role == 'BC Staff'
                            "
                            variant="flat"
                            rounded
                            :color="isActiveTab('organisation')"
                            @click="activeTab('organisation')"
                            >Organisation</VBtn
                        >
                        <VBtn
                            v-if="
                                user_role == 'BC Super Admin' ||
                                user_role == 'Organisation Admin' ||
                                user_role == 'BC Staff' ||
                                user_role == 'Teacher' ||
                                user_role == 'BC Subscriber'
                            "
                            variant="flat"
                            rounded
                            :color="isActiveTab('usage')"
                            @click="activeTab('usage')"
                            >Usage</VBtn
                        >
                        <VBtn
                            v-if="
                                user_role == 'BC Super Admin' ||
                                user_role == 'Organisation Admin' ||
                                user_role == 'BC Staff' ||
                                user_role == 'Teacher' ||
                                user_role == 'BC Subscriber'
                            "
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
                <VCol cols="12" v-if="tabName == 'subscriber'">
                    <Subscribers />
                </VCol>
                <VCol cols="12" v-if="tabName == 'organisation'">
                    <Organisation />
                </VCol>
                <VCol cols="12" v-if="tabName == 'usage'">
                    <Usage />
                </VCol>
                <VCol cols="12" v-if="tabName == 'book_interactivity'">
                    <VRow>
                        <VCol cols="12" md="4">
                            <VSelect
                                placeholder="Select/Student Class"
                                :items="[]"
                                rounded
                                variant="solo"
                            >
                            </VSelect>
                        </VCol>
                    </VRow>
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
