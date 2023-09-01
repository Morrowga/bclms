<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue"

import AddBook from "./components/AddBook.vue";

function showBook() {
    isShowBook.value = !isShowBook.value;
}
let switchBtn = ref("");
const selectedImage = ref(null);

const handleDrop = (event) => {
  event.preventDefault();
  const selectedFile = event.dataTransfer.files[0];
  if (selectedFile) {
    selectedImage.value = URL.createObjectURL(selectedFile);
  }
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="6">
                    <h1 class="tiggie-title">Add Pathway</h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <Link :href="route('pathways.index')">
                        <VBtn
                            color="secondary"
                            text-color="white"
                            density="compact"
                            variant="tonal"
                            class="pl-16 pr-16"
                            height="30"
                        >
                            <span class="text-dark">Back</span>
                        </VBtn>
                    </Link>
                    <VBtn height="30" class="ml-4"> Add Pathway </VBtn>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12">
                    <VRow>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Path Name</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Description</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4"> </VCol>

                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Number Of Gold Coins for Completion</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>

                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Number Of Silver Coins for Replay</VLabel
                            >
                            <VTextField
                                placeholder="Type here ..."
                                density="compact"
                            />
                        </VCol>
                        <VCol cols="12" sm="6" md="4">
                            <VLabel class="tiggie-label required"
                                >Must Complete Books In Order</VLabel
                            >
                            <VSwitch v-model="switchBtn"> </VSwitch>
                        </VCol>
                        <VCol cols="12" sm="6" md="6" class="py-4">
                            <h1 class="tiggie-title required">Current Flow</h1>
                            <ImageUpload data_type="pathway"/>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" class="pt-0">
                    <AddBook />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.custom-progress {
    width: 70%;
}

.import-card-text {
display: flex !important;
width: 469px !important;
height: 299px !important;
padding: 56px 79px !important;
flex-direction: column !important;
justify-content: center !important;
align-items: center !important;
gap: 17px !important;
flex-shrink: 0 !important;
}
</style>
