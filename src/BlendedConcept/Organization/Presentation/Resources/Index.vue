<template>
  <!-- for superadmin dashboard check -->
  <AdminLayout :user="user" :user_role="current_user_role">
    <div v-if="current_user_role == 'BC Super Admin'">
      <SuperAdminDashboard :users="props.users"> </SuperAdminDashboard>
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

//## variable section
let props = defineProps(["current_user_role",'user','users']);
</script>
