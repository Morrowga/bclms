<script setup>
const isDialogVisible = ref(false);
</script>

<template>
    <VDialog v-model="isDialogVisible" width="600">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" color="gray" class="text-dark" rounded>
                Edit
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard>
            <VRow justify="space-between" class="pa-2">
                <VCol cols="4" class="teacher-profile">
                    <img
                        src="/images/teacherimg.png"
                        class="tggie-student-img"
                    />
                </VCol>
                <VCol cols="8" class="allocated-storage">
                    <div class="d-flex align-center justify-center">
                        <p class="tiggie-teacher-label fs-24">
                            Allocated Storage
                        </p>
                        <VTextField
                            placeholder="200"
                            height="38px"
                            width="58px"
                        />
                        <VLabel class="tiggie-teacher-label">MB</VLabel>
                    </div>
                    <div class="d-flex">
                        <v-sheet
                            width="100%"
                            height="42px"
                            color="#BFC0C1"
                            class="d-flex my-4 rounded overflow-hidden"
                        >
                            <v-sheet
                                class="pt-3 pl-3"
                                color="primary"
                                height="100%"
                                :width="`${(50 / 100) * 100}%`"
                            >
                                125.3MB
                            </v-sheet>
                        </v-sheet>
                    </div>
                    <div class="d-flex gap-3 align-center">
                        <div>
                            <VIcon
                                icon="mdi-circle"
                                color="teal"
                                class="mr-3"
                            />
                            <span>Used</span>
                        </div>
                        <div>
                            <VIcon icon="mdi-circle" class="mr-3" />
                            <span>Available</span>
                        </div>
                    </div>
                </VCol>
                <VCol cols="6">
                    <p class="tiggie-subtitle">Tyler Covington</p>
                </VCol>
                <VCol cols="6" class="text-end pr-3">
                    <VBtn color="gray" class="text-dark" rounded> Save </VBtn>
                </VCol>
            </VRow>
        </VCard>
    </VDialog>
</template>
