<script setup>
import { Link } from "@inertiajs/vue3";

const studentInfo = defineProps(["studentInfo"]);
</script>
<template>
    <div>
        <Link
            :href="route('org_view_teacher_student.student.show')"
            class="d-flex flex-column justify-center align-center"
        >
            <VImg
                src="/images/students/studentone.svg"
                class="tggie-student-img"
            />
            <h4 class="tiggie-subtitle">Wren Clark</h4>
            <p class="text-candy-red">
                <VIcon icon="mdi-phone" color="candy-red"></VIcon>&nbsp; 9123
                4567
            </p>
            <span>135.8MB / 200 MB</span>
        </Link>
    </div>
</template>
