<script setup>
const isDialogVisible = ref(false)
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VListItemTitle v-bind="props">Update</VListItemTitle>
        </template>

        <!-- Dialog Content -->
        <VCard>
            <DialogCloseBtn variant="text" size="small" @click="isDialogVisible = false" />

            <VCardTitle class="tiggie-title">Update Subscription</VCardTitle>

            <VCardText>
                <VRow justify="center" align="center">
                    <VCol cols="6">
                        <VLabel class="tiggie-label">Teachers</VLabel>
                        <VTextField placeholder="10"></VTextField>
                    </VCol>
                    <VCol cols="6">
                        <VLabel class="tiggie-label">Start Date</VLabel>
                        <AppDateTimePicker v-model="date" label="Default" />
                    </VCol>
                    <VCol cols="6">
                        <VLabel class="tiggie-label">Teachers</VLabel>
                        <VTextField placeholder="100"></VTextField>
                    </VCol>
                    <VCol cols="6">
                        <VLabel class="tiggie-label">End Date</VLabel>
                        <AppDateTimePicker v-model="date" label="Default" />
                    </VCol>
                    <VCol cols="6">
                        <VLabel class="tiggie-label">Storage</VLabel>
                        <VTextField placeholder="1GB"></VTextField>
                    </VCol>
                    <VCol cols="6">
                        <VRow justify="space-between">
                            <VCol cols="6">
                                <div class="d-flex flex-column">
                                    <VLabel class="tiggie-label">
                                        Active
                                    </VLabel>
                                    <VSwitch inset color="primary" />
                                </div>
                            </VCol>
                            <VCol cols="6">
                                <div class="d-flex flex-column">
                                    <VLabel class="tiggie-label">
                                        Paid
                                    </VLabel>
                                    <VSwitch inset color="primary" />
                                </div>
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
            </VCardText>

            <VCardActions class="d-flex justify-space-between gap-5 ml-5 mt-16">
                <VBtn color="gray" variant="flat" width="164px" height="50" @click="isDialogVisible = false">
                    <span class="text-white">Cancel</span>
                </VBtn>
                <VBtn color="primary" variant="flat" width="164px" height="50">
                    <span class="text-white">Save</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>
