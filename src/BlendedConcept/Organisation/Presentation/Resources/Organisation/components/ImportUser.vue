<script setup>
import { ref, defineProps } from "vue";
import ImportUserTypeData from "./ImportUserDialog.vue";

const isDialogVisible = ref(false);

const props = defineProps(["organisation"]);

// organisation name change data format to arrary data types

const showSecondSelect = ref(false);
const secondSelectItems = ref([
    {
        display: `Teachers`,
        value: "teacher",
    },
    {
        display: `Students`,
        value: "student",
    },
]);
const selectedValueForSecondSelect = ref(null);
const isImportDialogVisible = ref(false);

const selectedType = ref(null);
const organisation_name = ref(props.organisation.name);
const openImports = () => {
    isImportDialogVisible.value = true;
};
watch(selectedValueForSecondSelect, () => {
    if (selectedValueForSecondSelect.value) {
        showSecondSelect.value = false;

        selectedType.value = selectedValueForSecondSelect.value.value;
    }
});
const closeDialog = () => {
    isDialogVisible.value = false;
    selectedValueForSecondSelect.value = null;
    selectedType.value = null;
};
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" height="40" density="compact">
                <span class="text-uppercase text-white" color="#555555">
                    Import User
                </span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex justify-center">
            <VCardTitle
                class="d-flex justify-space-between align-center gap-16"
            >
                <h4 class="tiggie-title">Batch Import Users</h4>
                <VIcon
                    icon="mdi-file-download"
                    color="tiggie-blue"
                    size="30px"
                    @click="openImports()"
                />
                <VDialog v-model="isImportDialogVisible" max-width="400">
                    <VCard>
                        <VCardText>
                            <div
                                class="d-flex justify-center align-center gap-3"
                            >
                                <a
                                    href="/imports/bc_student_import.csv"
                                    download
                                >
                                    <VBtn>Students</VBtn>
                                </a>
                                <a
                                    href="/imports/bc_teacher_import.csv"
                                    download
                                >
                                    <VBtn>Teachers</VBtn>
                                </a>
                            </div>
                        </VCardText>
                    </VCard>
                </VDialog>
            </VCardTitle>
            <VCardText>
                <VLabel class="tiggie-label required" v-if="!showSecondSelect"
                    >User Type</VLabel
                >
                <div v-else>
                    <VLabel class="tiggie-label"
                        ><strong class="mr-2 l-blue">Originization:</strong>
                        {{ organisation_name }}</VLabel
                    >
                    <div class="mt-2">
                        <VLabel class="tiggie-label required">User Type</VLabel>
                    </div>
                </div>
                <VSelect
                    class="mt-3 second-select-box"
                    density="compact"
                    :items="secondSelectItems"
                    item-title="display"
                    item-value="value"
                    v-model="selectedValueForSecondSelect"
                    return-object
                    single-line
                    placeholder="Select type of user to import"
                />
            </VCardText>

            <VCardActions
                class="d-flex justify-space-between gap-5 ml-3 mr-3 mt-5"
            >
                <VBtn
                    color="gray"
                    variant="flat"
                    width="164px"
                    @click="closeDialog"
                    height="51px"
                >
                    <span class="text-light">Cancel</span>
                </VBtn>
                <ImportUserTypeData
                    :type="selectedType"
                    :organisation_id="props.organisation.id"
                    @closeDialog="closeDialog"
                />
            </VCardActions>
        </VCard>
    </VDialog>
</template>
