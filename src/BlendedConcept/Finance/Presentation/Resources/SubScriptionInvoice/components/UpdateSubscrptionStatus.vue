<script setup>
const isDialogVisible = ref(false);
const date = ref("");
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VListItemTitle v-bind="props">Update</VListItemTitle>
        </template>

        <!-- Dialog Content -->
        <VCard class="pa-7">
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />

            <VCardTitle class="tiggie-title">Update Subscription</VCardTitle>

            <VCardText>
                <VRow justify="center" align="center">
                    <VCol cols="6">
                        <VLabel class="tiggie-label">Start Date</VLabel>
                        <AppDateTimePicker
                            v-model="date"
                            class="subplan-icon"
                            append-inner-icon="fa:fa-regular fa-calendar"
                        >
                        </AppDateTimePicker>
                    </VCol>
                    <VCol cols="6">
                        <VLabel class="tiggie-label">End Date</VLabel>
                        <AppDateTimePicker
                            v-model="date"
                            class="subplan-icon"
                            append-inner-icon="fa:fa-regular fa-calendar"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VLabel>Plan</VLabel>
                        <div class="subplan">
                            <v-radio-group inline>
                                <v-radio label="Free" value="1"></v-radio>
                                <v-radio label="Base" value="2"></v-radio>
                                <v-radio label="Pro" value="3"></v-radio>
                                <v-radio label="Premium" value="4"></v-radio>
                            </v-radio-group>
                        </div>
                    </VCol>
                    <VCol cols="6">
                        <VRow justify="space-between">
                            <VCol cols="4">
                                <div class="d-flex flex-column">
                                    <VLabel class="tiggie-label">
                                        Active
                                    </VLabel>
                                    <VSwitch inset color="primary" />
                                </div>
                            </VCol>
                            <VCol cols="4">
                                <div class="d-flex flex-column">
                                    <VLabel class="tiggie-label"> Paid </VLabel>
                                    <VSwitch inset color="primary" />
                                </div>
                            </VCol>
                            <VCol cols="4">
                                <div class="d-flex flex-column">
                                    <VLabel class="tiggie-label">
                                        Auto-renew
                                    </VLabel>
                                    <VSwitch inset color="primary" />
                                </div>
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
            </VCardText>

            <VCardActions class="d-flex justify-space-around gap-5 ml-5 mt-5">
                <VBtn
                    color="gray"
                    variant="flat"
                    width="164px"
                    height="50"
                    @click="isDialogVisible = false"
                >
                    <span class="text-white">Cancel</span>
                </VBtn>
                <VBtn color="primary" variant="flat" width="164px" height="50">
                    <span class="text-white">Save</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>
<style>
/* .subplan .v-selection-control-group--inline {
    justify-content: center;
} */
.subplan-icon .v-field__append-inner i {
    font-size: 25px !important;
}
</style>
