<script setup>
const props = defineProps(["studentInfo"]);
</script>
<template>
    <div class="d-flex flex-column justify-center align-center">
        <!-- :href="route('teacher_students.show')" -->
        <Link
        :href="route('teacher_students.show', props.studentInfo.id)"
        >
            <VImg
                :src="props.studentInfo.img"
                class="tggie-student-img"
            />
        </Link>
        <h4 class="tiggie-subtitle">{{  props.studentInfo.name }}</h4>
        <p class="text-candy-red">
            <VIcon icon="mdi-phone" color="candy-red"></VIcon>&nbsp; {{  props.studentInfo.contact_number }}
        </p>
    </div>
</template>
