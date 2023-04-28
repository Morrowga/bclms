<template>
    <!-- for superadmin dashboard check -->
    <AdminLayout :user="user" :user_role="current_user_role">
        <div v-if="current_user_role == 'BC Super Admin'">
            <!-- alert announment box -->

            <VAlert
            v-for="item in notifications"
            :key="item"
            variant="tonal"
            :type="item.type"
            v-model="isAlertVisible"
            closable
            close-label="Close Alert"
            >
                <template #text>
                    <p style="font-size:24px:">Success</p>
                    <p>{{item.data.message}}</p>
                </template>
            </VAlert>
            <!-- end announment  box-->
            <SuperAdminDashboard
                :orgainzations_users="props.orgainzations_users"
            >
            </SuperAdminDashboard>
        </div>
        <div v-else-if="current_user_role == 'BC Subscriber'">
            <TeacherOrParentDashboard> </TeacherOrParentDashboard>
        </div>
        <div v-else>
            <StaffDashboard></StaffDashboard>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import AnalyticsCongratulationsJohn from "@/views/dashboard/analytics/AnalyticsCongratulationsJohn.vue";
import EcommerceSalesOverview from "@/views/dashboard/ecommerce/EcommerceSalesOverview.vue";
import SuperAdminDashboard from "@Layouts/Dashboard/SuperAdminDashboard/SuperAdminDashboard.vue";
import StaffDashboard from "@Layouts/Dashboard/StaffDashboard.vue";
import TeacherOrParentDashboard from "@Layouts/Dashboard/TeacherOrParentDashboard.vue";
import { defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";
//## variable section
let props = defineProps(["current_user_role", "user", "orgainzations_users"]);
const isAlertVisible = ref(true)

let notifications = computed(() => usePage().props.notifications?.data);
console.log(notifications.value,"noti")
let unread_notifications_count = computed(
    () => usePage().props.unreadNotificationsCount
);

</script>
