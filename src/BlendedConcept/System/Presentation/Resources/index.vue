<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import AnalyticsCongratulationsJohn from "@/views/dashboard/analytics/AnalyticsCongratulationsJohn.vue";
import EcommerceSalesOverview from "@/views/dashboard/ecommerce/EcommerceSalesOverview.vue";
import StaffDashboard from "./StaffDashBoard/index.vue";
import SuperAdminDashboard from "./SuperAdminDashBoard/index.vue";
import StudentDashboard from "./Student/Index.vue";
import TeacherOrParentDashboard from "./TeacherDashBoard/index.vue";
import OrganizatinDashBoard from "./OrganisationDashboard/Index.vue";
import B2BTeacherDashboard from "./B2BTeacher/Index.vue";
import SystemAlert from "@mainRoot/components/SystemAlert/SystemAlert.vue";

import { defineProps, onMounted, watch, computed } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import axios from "axios";
let props = defineProps([
    "current_user_role",
    "user",
    "orgainzations_users",
    "tenant",
    "students",
    "UserCount",
    "classrooms",
    "org_teacher_students",
    "user_survey",
    "org_teacher_classrooms",
    "recent_games",
    "recent_books",
]);

const isAlertVisible = ref(true);
let form = useForm({});
let notifications = ref([]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let user_detail = computed(() => page.props.user_info.user_detail.full_name);
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
            console.log(notifications.value);
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
const forbiddenRole = () => {
    return user_role.value != "BC Subscriber" || user_role.value != "Teacher";
};
let isOpenMenu = ref(true);
let toggleMenu = () => {
    isOpenMenu.value = !isOpenMenu.value;
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
        @openMenu="toggleMenu()"
    >
        <!--
            VAlert is use for show annnounment pages
        -->
        <VContainer v-if="!checkUserRole()" :fluid="checkUserRole()">
            <span class="welcome-text ruddy-bold"
                >Welcome, {{ user_detail }}</span
            >
            <br /><br />
            <SystemAlert
                class="pb-4"
                icon="fa:fa-light fa-user"
                text="New student “Mary Tan” joined Class 1A"
            />
            <SystemAlert
                class="pb-4"
                icon="fa:fa-solid fa-book"
                text="New storybook “Toy Story” has been added"
            />
        </VContainer>

        <!--
            Check current_user_role and redirect to that
            page according to that roles
    -->

        <div v-if="current_user_role == 'BC Super Admin'">
            <SuperAdminDashboard :usercount="props.UserCount">
            </SuperAdminDashboard>
        </div>
        <div v-else-if="current_user_role == 'BC Subscriber'">
            <TeacherOrParentDashboard :students="students">
            </TeacherOrParentDashboard>
        </div>
        <div v-else-if="current_user_role == 'Organisation Admin'">
            <OrganizatinDashBoard
                :classrooms="props.classrooms"
            ></OrganizatinDashBoard>
        </div>
        <div v-else-if="current_user_role == 'Teacher'">
            <B2BTeacherDashboard
                :org_teacher_students="props.org_teacher_students"
                :org_teacher_classrooms="props.org_teacher_classrooms"
                :user_survey="props.user_survey"
            ></B2BTeacherDashboard>
        </div>
        <div v-else>
            <StaffDashboard
                :recent_books="props.recent_books"
                :recent_games="props.recent_games"
                :usercount="props.UserCount"
            ></StaffDashboard>
        </div>
    </AdminLayout>
    <StudentLayout v-else @openMenu="toggleMenu()">
        <StudentDashboard
            :orgainzations_users="props.orgainzations_users"
            :isOpenMenu="isOpenMenu"
        >
        </StudentDashboard>
    </StudentLayout>
</template>
<style scoped>
.welcome-text {
    color: #000;
    /* H2 */
    font-size: 60px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize !important;
}
</style>
