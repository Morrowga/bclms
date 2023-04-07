<script setup>
import { ref } from "vue";
const isDialogVisible = ref(false);
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="900">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props"> Add Role </VBtn>
    </template>

    <!-- Dialog Content -->
    <VCard title="Add Role">
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="isDialogVisible = false"
      />

      <VCardText>
        <VRow>
          <VCol cols="12">
            <VTextField label="Role Name" />
          </VCol>
          <VCol cols="12"> </VCol>
        </VRow>
      </VCardText>

      <VCardActions>
        <VSpacer />
        <VBtn color="error" @click="isDialogVisible = false"> Close </VBtn>
        <VBtn color="success" @click="isDialogVisible = false"> Save </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>
