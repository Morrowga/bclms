<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <div class="d-flex justify-center mb-6">
            <div class="tiggie-title text-center">Organization Particulars</div>
            <div class="tiggie-title"> Sticker </div>
        </div>

    </AdminLayout>
</template>
<style scoped></style>
