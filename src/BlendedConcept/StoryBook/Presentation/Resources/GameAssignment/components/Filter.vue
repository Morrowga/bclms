<script setup>
import { router } from "@inertiajs/core";

const isDialogVisible = ref(false);

const filterItems = ref({
    disability_types: [],
    devices: [],
});

const props = defineProps(["disabilityTypes", "devices"]);

const applyFilter = () => {
    let filterData = JSON.stringify(filterItems.value);
    router.get(
        route("games.index", {
            filterItems: filterData,
        })
    );
};
onMounted(() => {
    let currentParams = route().params;
    if (currentParams.filterItems) {
        let data = JSON.parse(currentParams.filterItems);
        filterItems.value = {
            disability_types: data.disability_types,
            devices: data.devices,
        };
    }
});
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <v-btn color="gray" class="text-white" v-bind="props">
                Filter
                <v-icon icon="mdi-filter-variant"></v-icon>
            </v-btn>
        </template>

        <!-- Dialog Content -->
        <VCard title="Filter Games Filter">
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />
            <v-card-text>
                <h2 class="text-h6 mb-2">Disability Types</h2>

                <v-chip-group
                    v-model="filterItems.disability_types"
                    column
                    multiple
                >
                    <v-chip
                        filter
                        variant="outlined"
                        v-for="disability_type in disabilityTypes"
                        :key="disability_type.id"
                        :value="disability_type.id"
                    >
                        {{ disability_type.name }}
                    </v-chip>
                </v-chip-group>
            </v-card-text>
            <v-card-text>
                <h2 class="text-h6 mb-2">Devices</h2>

                <v-chip-group v-model="filterItems.devices" column multiple>
                    <v-chip
                        filter
                        variant="outlined"
                        v-for="device in devices"
                        :key="device.id"
                        :value="device.id"
                    >
                        {{ device.name }}
                    </v-chip>
                </v-chip-group>
            </v-card-text>

            <div class="d-flex justify-center gap-10 pa-3">
                <VBtn
                    @click="isDialogVisible = false"
                    color="gray"
                    class="text-white"
                >
                    Cancel
                </VBtn>
                <VBtn @click="applyFilter()" color="primary">
                    Apply Filter
                </VBtn>
            </div>
        </VCard>
    </VDialog>
</template>
