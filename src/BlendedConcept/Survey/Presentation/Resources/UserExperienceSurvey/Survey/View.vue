<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import BarChart from "./components/BarChart.vue";
import CircleChart from "./components/CircleChart.vue";
import Suggestion from "./components/Suggestion.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex">
                <h1 class="tiggie-title mb-4">Happiness Survey</h1>
                <v-spacer></v-spacer>
                <div>
                    <Link :href="route('userexperiencesurvey.index')">
                        <VBtn color="gray" height="50" class="" width="200">
                            Back
                        </VBtn>
                    </Link>

                    <VBtn type="submit" class="ml-10" height="50" width="200">
                        Responses
                    </VBtn>
                </div>
            </div>

            <CircleChart />

            <BarChart />

            <Suggestion />
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.survey_name {
    font-size: 26px !important;
}
</style>
