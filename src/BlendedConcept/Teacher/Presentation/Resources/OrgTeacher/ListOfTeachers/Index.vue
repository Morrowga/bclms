<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";


</script>

<template>

<AdminLayout>

 <VContainer>
    <div class="d-flex justify-space-between align-center">
        <h1 class="tiggie-teacher-title">Allocate Teacher’s Storage</h1>
        <VBtn class="text-primary" color="#e8e9ed" width="200px" variant="flat" rounded>
            Back
        </VBtn>
    </div>
    <div class="d-flex justify-space-between align-center mt-10 pt-10">
        <h1 class="tiggie-teacher-subtitle" style="font-size:30px !important">Total Storage Usage</h1>
       <div class="tiggie-subtitle">
        1.23GB of 2GB allocated to teachers,130MB available
       </div>
    </div>
 </VContainer>
</AdminLayout>
</template>
