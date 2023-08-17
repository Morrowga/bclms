<script setup>

 const studentInfo = defineProps(['studentInfo']);
</script>
<template>
    <div class="d-flex flex-column justify-center align-center">
        <VImg src="/images/students/studentone.svg" class="tggie-student-img" />
        <h4 class="tiggie-subtitle">Wren Clark</h4>
        <p class="text-candy-red">
            <VIcon icon="mdi-phone" color="candy-red"></VIcon>&nbsp; 9123 4567
        </p>
    </div>
</template>
