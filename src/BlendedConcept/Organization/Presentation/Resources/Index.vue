<template>
<!-- for superadmin dashboard check -->
<AdminLayout v-if="auth.data.roles[0].name == 'superadmin'"></AdminLayout>

<!-- for teacher and parent roles check -->
<TeacherOrParent v-if="auth.data.roles[0].name == 'teacher/parent'">

</TeacherOrParent>
</template>

<script setup>
import { computed } from 'vue'
import {usePage } from "@inertiajs/vue3";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue"
import TeacherOrParent from "@Layouts/Dashboard/TeacherOrParent.vue"

let auth = computed(() => usePage().props.auth);

</script>
