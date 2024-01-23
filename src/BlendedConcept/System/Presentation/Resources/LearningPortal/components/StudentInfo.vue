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
            <img
                :src="props.studentInfo.img"
                class="learning-student-img"
            />
        </Link>
    </div>
</template>
