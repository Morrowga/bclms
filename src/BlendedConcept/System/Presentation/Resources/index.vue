<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import AnalyticsCongratulationsJohn from "@/views/dashboard/analytics/AnalyticsCongratulationsJohn.vue";
import EcommerceSalesOverview from "@/views/dashboard/ecommerce/EcommerceSalesOverview.vue";
import StaffDashboard from "./StaffDashBoard/index.vue";
import SuperAdminDashboard from "./SuperAdminDashBoard/index.vue";
import StudentDashboard from "./Student/Index.vue";
import TeacherOrParentDashboard from "./TeacherDashBoard/index.vue";
import OrganizatinDashBoard from "./OrganizationDashboard/Index.vue";
import B2BTeacherDashboard from "./B2BTeacher/Index.vue";

import { defineProps, onMounted, watch, computed } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import axios from "axios";
let props = defineProps([
    "current_user_role",
    "user",
    "orgainzations_users",
    "tenant",
    "students",
]);

const isAlertVisible = ref(true);
let form = useForm({});
let notifications = ref([]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let reactiveNoti = computed(() => page.props.notifications?.data);
let watchNoti = watch(reactiveNoti, (value) => {
    getNotifications();
});

const getNotifications = () => {
    axios
        .get(
            route("notifications", {
                page: 1,
            })
        )
        .then((resp) => {
            console.log(resp);
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
};
const checkUserRole = () => {
    return user_role.value == "BC Super Admin" || user_role.value == "BC Staff";
};
onMounted(() => {
    getNotifications();
});
</script>

<template>
    <AdminLayout
        v-if="current_user_role !== 'Student'"
        :user="user"
        :user_role="current_user_role"
        :tenant="tenant"
    >
        <!--
            VAlert is use for show annnounment pages
        -->
        <VContainer
            v-if="user_role != 'BC Subscriber'"
            :fluid="checkUserRole()"
        >
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
            >
                <template #text>
                    <span style="font-size:24px:">{{ item?.data?.type }}</span>
                    <br />
                    <span>{{ item.data.message }}</span>
                </template>
                <template #close>
                    <v-btn
                        icon="mdi-close"
                        @click="removeNotification(item.id)"
                    ></v-btn>
                </template>
            </VAlert>
        </VContainer>

        <!--
            Check current_user_role and redirect to that
            page according to that roles
    -->

        <div v-if="current_user_role == 'BC Super Admin'">
            <SuperAdminDashboard
                :orgainzations_users="props.orgainzations_users"
            >
            </SuperAdminDashboard>
        </div>
        <div v-else-if="current_user_role == 'BC Subscriber'">
            <TeacherOrParentDashboard :students="students">
            </TeacherOrParentDashboard>
        </div>
        <div v-else-if="current_user_role == 'Organization Admin'">
            <OrganizatinDashBoard></OrganizatinDashBoard>
        </div>
        <div v-else-if="current_user_role == 'Teacher'">
            <B2BTeacherDashboard></B2BTeacherDashboard>
        </div>
        <div v-else>
            <StaffDashboard
                :orgainzations_users="props.orgainzations_users"
            ></StaffDashboard>
        </div>
    </AdminLayout>
    <StudentLayout v-else>
        <!-- <VAlert
            v-for="item in notifications"
            :key="item.id"
            variant="tonal"
            density="compact"
            :type="item.data.type"
            v-model="isAlertVisible"
            closable
            class="mb-2"
            close-label="Close Alert"
        >
            <template #text>
                <span style="font-size:24px:">{{ item?.data?.type }}</span>
                <br />
                <span>{{ item.data.message }}</span>
            </template>
            <template #close>
                <v-btn
                    icon="mdi-close"
                    @click="removeNotification(item.id)"
                ></v-btn>
            </template>
        </VAlert> -->
        <StudentDashboard :orgainzations_users="props.orgainzations_users">
        </StudentDashboard>
    </StudentLayout>
</template>
