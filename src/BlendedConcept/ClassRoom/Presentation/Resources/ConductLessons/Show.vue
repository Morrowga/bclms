<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

import ChooseStorybook from "./components/ChooseStorybook.vue";
import SelectStudent from "./components/SelectStudent.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex mb-4">
                <h1 class="mb-4 font-weight-bold text-h5">
                    A Walk On The Tundra
                </h1>
                <v-spacer></v-spacer>
            </div>
            <div class="book-panels">
                <div class="mt-10">
                    <iframe
                    src="http://bc-lms.test/admin/h5p/h5p/19/edit"
                    frameborder="0"
                    scrolling="auto"
                    class="h5p-width"
                    ></iframe>
                </div>
                <br />
                <div class="d-flex">
                    <v-btn class="mr-2 text-white" color="#EF5350"
                        >Class Mode</v-btn
                    >
                    <v-btn color="#42A5F5" class="text-white"
                        >Interactive Mode</v-btn
                    >
                </div>
            </div>
            <br />
            <v-btn variant="flat" color="#FC0" rounded>Back</v-btn>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.v-label.v-field-label {
    color: unset !important;
    font-size: unset !important;
    font-style: unset !important;
    font-weight: unset !important;
    text-transform: unset !important;
}

.h5p-width{
    width: 100%;
    height: 1500px;
}
</style>
