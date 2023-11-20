<script setup>
import { ref, defineProps } from "vue";
import ImportUserTypeData from "./ImportUserTypeData.vue";

const isDialogVisible = ref(false);
const isImportDialogVisible = ref(false);

const props = defineProps(["organisations"]);

// organisation name change data format to arrary data types
const items = [...props.organisations];

const selectedOrganisation = ref(null);
const showSecondSelect = ref(false);
const secondSelectItems = ref([
    { display: "2 Teachers", value: "teacher" },
    { display: "2 Students", value: "student" },
]);
const selectedValueForSecondSelect = ref(null);

const selectedType = ref(null);
const organisation_name = ref("");

const openImports = () => {
    isImportDialogVisible.value = true;
};
const downloadFile = (file) => {
    // const downloadUrl = `/public/imports/${file}`;
    // const link = document.createElement("a");
    // link.href = downloadUrl;
    // link.download = file;
    // link.style.display = "none";
    // document.body.appendChild(link);
    // link.click();
    // document.body.removeChild(link);
};
watch(selectedOrganisation, (newValue) => {
    if (newValue) {
        showSecondSelect.value = true;
        let mutateSecondItem = items.map((organisation) => {
            if (organisation.id == newValue) {
                organisation_name.value = organisation.name;
                secondSelectItems.value = [
                    {
                        display: `Teachers`,
                        value: "teacher",
                    },
                    {
                        display: `Students`,
                        value: "student",
                    },
                ];
            } else {
                return [];
            }
        });
    } else {
        showSecondSelect.value = false;
        selectedValueForSecondSelect.value = null;
    }
});

watch(selectedValueForSecondSelect, () => {
    if (selectedValueForSecondSelect.value) {
        showSecondSelect.value = false;
        // console.log(selectedValueForSecondSelect.value.value); // This should now display the selected value
        selectedType.value = selectedValueForSecondSelect.value.value;
    }
});
const clearForm = () => {
    selectedOrganisation.value = "";
    isDialogVisible.value = false;
};
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" height="40" density="compact">
                <span class="text-uppercase text-white"> Import </span>
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
                    >Organisation</VLabel
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
                    class="mt-3"
                    density="compact"
                    :items="items"
                    v-if="!showSecondSelect"
                    v-model="selectedOrganisation"
                    item-title="name"
                    item-value="id"
                    placeholder="Select organisation to import users for"
                />
                <VSelect
                    class="mt-3 second-select-box"
                    density="compact"
                    v-if="showSecondSelect"
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
                    @click="clearForm()"
                    height="51px"
                >
                    <span class="text-light">Cancel</span>
                </VBtn>
                <ImportUserTypeData
                    :type="selectedType"
                    :organisation_id="selectedOrganisation"
                    @closeDialog="clearForm()"
                />
            </VCardActions>
        </VCard>
    </VDialog>
</template>
