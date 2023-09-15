<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Touch from "./components/Touch.vue";
import { ref } from "vue";
let selectedValue = ref("");
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row>
                <v-col cols="12">
                    <h1 class="text-h3 font-weight-bold mb-4 t-black">
                        Set Accessibility Device
                    </h1>
                </v-col>
                <v-col cols="12" md="4">
                    <v-label class="font-weight-bold t-black"
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
<style>
.t-black {
    color: #000 !important;
}
</style>
