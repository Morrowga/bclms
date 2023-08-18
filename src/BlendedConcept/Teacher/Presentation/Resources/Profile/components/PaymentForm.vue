<script setup>
const isDialogVisible = ref(false)
</script>

<template>
    <VDialog v-model="isDialogVisible" width="50%">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" color="orange" variant="flat" rounded>
                <span class="text-white">Make Payment</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex m-10 pa-16">
            <DialogCloseBtn variant="text" size="small" @click="isDialogVisible = false" />

            <VCardTitle class="tiggie-label"> Do you have a student code?</VCardTitle>
            <VCardText class="d-flex flex-column justify-center">
                <VTextField density="density" rounded placeholder="Student / Promotion Code (optional)" />

                <VRow justify="center" class="mt-10">
                    <VCol cols="8" class="">
                        <VBtn color="dark" class="pl-16 pr-16" width="300">
                            <VIcon icon="mdi-apple"></VIcon>
                            <span class="text-white">Pay</span>
                        </VBtn>
                    </VCol>
                </VRow>

            </VCardText>
            <VCardActions>

            </VCardActions>
        </VCard>
    </VDialog>
</template>
