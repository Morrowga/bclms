<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

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
                        <VCol cols="12" sm="6" md="4" class="py-4">
                            <h1 class="tiggie-title required">Current Flow</h1>
                            <div class="coming-soon" @dragover.prevent @drop="handleDrop">
                                <v-img v-if="selectedImage" :src="selectedImage" cover></v-img>
                                <p v-else>Drop And Drop</p>
                            </div>
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

.coming-soon {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
    height: 200px;
    border: 1px dashed black;
    border-radius: 10px;
}
.coming-soon p {
    margin-bottom: 0;
}
</style>
