<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import DisabilityType from "./components/DisabilityType.vue";
import LearningType from "./components/LearningType.vue";
import Themes from "./components/Themes.vue";

let props = defineProps();
let tabName = ref("disability");
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
            <h1 class="tiggie-title mb-4">Manage Tag</h1>

            <VRow>
                <VCol cols="12">
                    <div
                        class="d-flex align-center flex-wrap"
                        style="gap: 10px"
                    >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('disability')"
                            @click="activeTab('disability')"
                            >Disability Types</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('learning')"
                            @click="activeTab('learning')"
                            >Learning Type</VBtn
                        >
                        <VBtn
                            variant="flat"
                            rounded
                            :color="isActiveTab('themes')"
                            @click="activeTab('themes')"
                            >Themes</VBtn
                        >
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" v-if="tabName == 'disability'">
                    <DisabilityType />
                </VCol>
                <VCol cols="12" v-if="tabName == 'learning'">
                    <LearningType />
                </VCol>
                <VCol cols="12" v-if="tabName == 'themes'">
                    <Themes />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
