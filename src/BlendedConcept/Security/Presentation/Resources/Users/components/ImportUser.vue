<script setup>
import { ref } from "vue"
import ImportUserTypeData from "./ImportUserTypeData.vue"

const isDialogVisible = ref(false)
const items = [
    'Blended Concepted',
    'Blended Center',
    'Bentlee School of Hope',
    'Korbbe Collibe Home',
];

</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" height="40" density="compact">
                <span class="text-uppercase text-white">
                    Import
                </span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex justify-center">
            <VCardTitle class="d-flex justify-content-center align-center  gap-16">
                <h4 class="tiggie-title">
                    Batch Import Users
                </h4>
                <VIcon icon="mdi-file-download" color="primary" size="30px" />
            </VCardTitle>
            <VCardText>
                <VLabel class="tiggie-label required">Organization</VLabel>
                <VSelect class="mt-3" density="compact" :items="items"
                    placeholder="Select organization to import users for" />
            </VCardText>

            <VCardActions class="d-flex justify-center gap-5 ml-5 mt-16">
                <VBtn color="gray" variant="flat" width="164px" @click="isDialogVisible = false">
                    <span class="text-white">Cancel</span>
                </VBtn>
                <ImportUserTypeData/>

            </VCardActions>
        </VCard>
    </VDialog>
</template>
