<template>
  <!-- for superadmin dashboard check -->
  <AdminLayout :user="user" :user_role="current_user_role">
    <div v-if="current_user_role == 'BC Super Admin'">
      <!-- alert announment box -->

      <VAlert
        v-for="item in notifications"
        :key="item.id"
        variant="tonal"
        density="compact"
        :type="item.data.type"
        v-model="isAlertVisible"
        closable
        class="mb-2"
        close-label="Close Alert"
        style="padding: 6px 16px"
      >
        <template #text>
          <span style="font-size:24px:">Success</span>
          <br />
          <span>{{ item.data.message }}</span>
        </template>
        <template #close>
          <v-btn icon="mdi-close" @click="removeNotification(item.id)"></v-btn>
        </template>
      </VAlert>
      <!-- end announment  box-->
      <SuperAdminDashboard :orgainzations_users="props.orgainzations_users">
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
import { defineProps, onMounted, watch, computed } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import axios from "axios";
//## variable section
let props = defineProps(["current_user_role", "user", "orgainzations_users"]);
const isAlertVisible = ref(true);
let form = useForm({});
let notifications = ref([]);
let reactiveNoti = computed(() => usePage().props.notifications?.data);
let watchNoti = watch(reactiveNoti, (value) => {
  getNotifications();
});
// let unread_notifications_count = computed(
//   () => usePage().props.unreadNotificationsCount
// );
const getNotifications = () => {
  axios
    .get(
      route("notifications", {
        page: 1,
      })
    )
    .then((resp) => {
      notifications.value = resp.data.notifications.data;
    });
};
const removeNotification = (notificationId) => {
  form.post(route("markAsRead", { id: notificationId }), {
    onSuccess: () => {
      notifications.value = notifications.value.filter(
        (noti) => noti.id != notificationId
      );
    },
  });
  //   isAlertVisible.value = false
};
onMounted(() => {
  getNotifications();
});
</script>
