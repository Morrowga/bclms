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
        <VCard class="update-subscription pa-7">
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />

            <VCardTitle class="tiggie-title">Update Subscription</VCardTitle>

            <VCardText>
                <VRow justify="center" align="center" class="subscription">
                    <VCol cols="6" class="date-time">
                        <VLabel class="tiggie-label">Start Date</VLabel>
                        <AppDateTimePicker
                            v-model="date"
                            class="subplan-icon blue-outline-field"
                            append-inner-icon="fa:fa-regular fa-calendar"
                            variant="plain"
                        >
                        </AppDateTimePicker>
                    </VCol>
                    <VCol cols="6" class="date-time">
                        <VLabel class="tiggie-label">End Date</VLabel>
                        <AppDateTimePicker
                            v-model="date"
                            class="subplan-icon blue-outline-field"
                            append-inner-icon="fa:fa-regular fa-calendar"
                            variant="plain"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VLabel class="tiggie-label">Plan</VLabel>
                        <div class="subplan">
                            <v-radio-group inline>
                                <v-radio label="Free" value="1">
                                    <template #label="{ label }">
                                        <VLabel class="tiggie-label">
                                            {{ label }}</VLabel
                                        >
                                    </template>
                                </v-radio>
                                <v-radio label="Base" value="2">
                                    <template #label="{ label }">
                                        <VLabel class="tiggie-label">
                                            {{ label }}</VLabel
                                        >
                                    </template>
                                </v-radio>
                                <v-radio label="Pro" value="3">
                                    <template #label="{ label }">
                                        <VLabel class="tiggie-label">
                                            {{ label }}</VLabel
                                        >
                                    </template>
                                </v-radio>
                                <v-radio label="Premium" value="4">
                                    <template #label="{ label }">
                                        <VLabel class="tiggie-label">
                                            {{ label }}</VLabel
                                        >
                                    </template>
                                </v-radio>
                            </v-radio-group>
                        </div>
                    </VCol>
                    <VCol cols="10">
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
.update-subscription .subplan-icon .v-field__append-inner i {
    font-size: 25px !important;
}
.update-subscription .blue-outline-field {
    border: 1px solid var(--Primary, #001a8f);
    border-radius: 5px;
    background: var(--White, #fff);
    padding: 4px 16px;
}
body
    > div.v-overlay-container
    > div.v-overlay.v-overlay--active.v-theme--light.v-locale--is-ltr.v-dialog.v-overlay--scroll-blocked
    > div.v-overlay__content
    > div
    > div.v-card-text
    > div.subscription
    > div
    > div
    > div
    > div
    > div.v-field__append-inner {
    padding-top: 6px !important;
}
</style>
