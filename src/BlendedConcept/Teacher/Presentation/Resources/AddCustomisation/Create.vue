<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { router } from "@inertiajs/core";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

import SelectStudents from "./components/SelectStudents.vue";
import SetContent from "./components/SetContent.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex mb-4">
                <h1 class="customisation mb-4">
                    Add Personalisation/ Customisation
                </h1>
            </div>
            <div class="book-panels">
                <v-expansion-panels>
                    <SetContent />
                </v-expansion-panels>
                <br />
                <br />
                <v-expansion-panels>
                    <SelectStudents />
                </v-expansion-panels>
            </div>
            <div class="d-flex justify-center aligns-center w-100 pt-4">
                    <SecondaryBtn
                    title="Cancel"
                    class="mr-4"/>
                    <PrimaryBtn title="Create" />
            </div>
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
.customisation {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
</style>
