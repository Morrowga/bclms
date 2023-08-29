<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

import ChooseStorybook from "./components/ChooseStorybook.vue";
import SelectStudent from "./components/SelectStudent.vue";
import { router } from "@inertiajs/core";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <!-- <div class="d-flex mb-4">
                <h1 class="tiggie-title mb-4">Happiness Survey</h1>
                <v-spacer></v-spacer>
                <div>
                    <VBtn color="gray" height="50" class="" width="200">
                        Back
                    </VBtn>

                    <VBtn type="submit" class="ml-10" height="50" width="200">
                        Responses
                    </VBtn>
                </div>
            </div> -->
            <div class="book-panels">
                <v-expansion-panels>
                    <ChooseStorybook />
                </v-expansion-panels>
                <br />
                <br />
                <v-expansion-panels>
                    <SelectStudent />
                </v-expansion-panels>
            </div>
            <div class="d-flex justify-center aligns-center w-100 pt-4">
                <div>
                    <VBtn color="gray" height="50" class="" width="200">
                        Cancel
                    </VBtn>

                    <VBtn
                        type="submit"
                        class="ml-10"
                        height="50"
                        width="200"
                        @click="() => router.get(route('conduct_lessons.show'))"
                    >
                        Start Lesson
                    </VBtn>
                </div>
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
</style>
