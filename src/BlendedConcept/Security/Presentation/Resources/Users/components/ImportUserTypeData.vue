<script setup>
import { ref } from "vue"
const isDialogVisible = ref(false)
import FileUpload from 'primevue/fileupload';
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
            <VBtn v-bind="props" color="primary" variant="flat" width="164px">
                <span class="text-white">Next</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex justify-center">
            <VCardTitle class="d-flex justify-content-center align-center  gap-16">
                <h4 class="tiggie-title">
                    Upload Teachers
                </h4>
                <VIcon icon="mdi-file-download" color="primary" size="30px" />
            </VCardTitle>
            <VCardText>
                <p class="tiggie-p"> <span class="text-primary pr-2">2</span>teachers remaining</p>
            </VCardText>
            <VCardText>
                <FileUpload name="demo[]" url="./upload.php" @upload="onAdvancedUpload($event)" :multiple="true"
                    accept="image/*" :maxFileSize="1000000">
                    <template #empty>
                        <p>Drag and drop files to here to upload.</p>
                    </template>
                </FileUpload>

            </VCardText>

            <VCardActions class="d-flex justify-center gap-5 ml-5 mt-16">
                <VBtn color="gray" variant="flat" width="164px" @click="isDialogVisible = false">
                    <span class="text-white">Cancel</span>
                </VBtn>
                <VBtn color="primary" variant="flat" width="164px">
                    <span class="text-white">Next</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<style scoped>
@import"primevue/resources/themes/lara-light-indigo/theme.css";
</style>
