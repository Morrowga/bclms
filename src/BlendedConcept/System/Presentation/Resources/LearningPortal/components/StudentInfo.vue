<script setup>
const props = defineProps(["studentInfo"]);
</script>
<template>
    <div class="d-flex flex-column justify-center align-center">
        <!-- :href="route('teacher_students.show')" -->
        <Link
        :href="
            route(
                'teacher_students.kidmode',
                props.studentInfo.user_id
            )
        "
        >
            <VImg
                :src="props.studentInfo.img"
                class="tggie-student-img"
            />
        </Link>
        <h4 class="tiggie-subtitle">{{  props.studentInfo.name }}</h4>
    </div>
</template>
