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

const selectedOrganization = ref(null);
const showSecondSelect = ref(false);
const secondSelectItems = [
    { display: '2 Teachers', value: 'Teachers' },
  { display: '2 Students', value: 'Students' },
];
const selectedValueForSecondSelect = ref(null);

const selectedType = ref(null);

watch(selectedOrganization, (newValue) => {
  if (newValue) {
    showSecondSelect.value = true;
  } else {
    showSecondSelect.value = false;
    selectedValueForSecondSelect.value = null;
  }
});

watch(selectedValueForSecondSelect, () => {
  if (selectedValueForSecondSelect.value) {
    showSecondSelect.value = false;
    console.log(selectedValueForSecondSelect.value.value); // This should now display the selected value
    selectedType.value = selectedValueForSecondSelect.value.value
  }
});
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
            <VCardTitle class="d-flex justify-space-between align-center  gap-16">
                <h4 class="tiggie-title">
                    Batch Import Users
                </h4>
                <VIcon icon="mdi-file-download" color="tiggie-blue" size="30px" />
            </VCardTitle>
            <VCardText>
                <VLabel class="tiggie-label required" v-if="!showSecondSelect">Organization</VLabel>
                <div v-else>
                    <VLabel class="tiggie-label"><strong style="color: #4066e4;" class="mr-2">Originization:</strong> {{ selectedOrganization  }}</VLabel>
                    <div class="mt-2">
                        <VLabel class="tiggie-label required">User Type</VLabel>
                    </div>
                </div>
                <VSelect class="mt-3" density="compact" :items="items"
                    v-if="!showSecondSelect"
                    v-model="selectedOrganization"
                    placeholder="Select organization to import users for" />
                <VSelect class="mt-3 second-select-box" density="compact"
                    v-if="showSecondSelect"
                    :items="secondSelectItems"
                    item-title="display"
                    item-value="value"
                    v-model="selectedValueForSecondSelect"
                    return-object
                    single-line
                    placeholder="Select type of user to import" />
            </VCardText>

            <VCardActions class="d-flex justify-space-between gap-5 ml-3 mr-3 mt-5">
                <VBtn color="gray" variant="flat" width="164px" @click="isDialogVisible = false" height="51px">
                    <span class="text-light">Cancel</span>
                </VBtn>
                <ImportUserTypeData :type="selectedType"/>
            </VCardActions>
        </VCard>
    </VDialog>
</template>
