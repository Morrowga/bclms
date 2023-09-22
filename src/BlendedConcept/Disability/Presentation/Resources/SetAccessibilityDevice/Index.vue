<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import DeviceInfo from "./components/DeviceInfo.vue";
import { ref } from "vue";
let props = defineProps(['devices', 'id']);
const selectedValue = ref(null);
const showDeviceInfo = ref(false);
const selectedDevice = ref(null);


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
                        class="mt-4"
                        v-model="selectedValue"
                        item-value="id"
                        item-title="name"
                        :items="props.devices.data"
                        variant="solo"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <DeviceInfo v-if="selectedValue != null" :student_id="props.id" :selectedId="selectedValue" :devices="props.devices.data" />
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
