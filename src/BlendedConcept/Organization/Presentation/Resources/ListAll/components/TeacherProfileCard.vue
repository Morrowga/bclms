<script setup>
import { Link } from "@inertiajs/vue3";
const studentInfo = defineProps(["studentInfo"]);
</script>
<template>
    <div class="d-flex flex-column justify-center align-center">
        <Link :href="route('org_view_teacher_student.teacher.show')">
            <VImg src="/images/teacher.png" class="tggie-student-img" />
            <h4 class="tiggie-subtitle">Wren Clark</h4>
            <p class="text-candy-red mb-1">
                <VIcon icon="mdi-phone" color="candy-red"></VIcon>&nbsp; 9123
                4567
            </p>
            <span>135.8MB / 200 MB</span>
        </Link>
    </div>
</template>
