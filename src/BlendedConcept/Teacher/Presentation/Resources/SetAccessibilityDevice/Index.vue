<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Touch from "./components/Touch.vue";
import { ref } from "vue";
let selectedValue = ref("");
</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <v-row>
                <v-col cols="12">
                    <h1
                        class="text-h3 font-weight-bold mb-4"
                        style="color: #000"
                    >
                        Set Accessibility Device
                    </h1>
                </v-col>
                <v-col cols="12" md="4">
                    <v-label class="font-weight-bold" style="color: #000"
                        >Select Accessibility Device</v-label
                    >
                    <v-select
                        placeholder="Select"
                        v-model="selectedValue"
                        :items="[
                            'Touch',
                            'Switch-Single',
                            'Switch-Double',
                            'Eye-Gaze',
                            'Mouse/Keyboard',
                        ]"
                        variant="solo"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <div v-if="selectedValue == 'Touch'">
                        <Touch />
                    </div>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style></style>
