<script setup>
import { ref } from "vue"
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

import AddBook from "./components/AddBook.vue"



function showBook() {
    isShowBook.value = !isShowBook.value
}
</script>
<template>
    <AdminLayout>

        <VContainer>
            <VRow>
                <VCol cols="6">
                    <h1 class="tiggie-title">Add Pathway</h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <VBtn color="secondary" text-color="white" density="compact" variant="tonal" class="pl-16 pr-16"
                        @click="isUserProfileEdit = true" height="30">
                        <span class="text-dark">Back</span>
                    </VBtn>
                    <VBtn height="30" class="ml-4">
                        Add Pathway
                    </VBtn>

                </VCol>
            </VRow>
            <VRow>
                <VCol cols="4">
                    <VRow>
                        <VCol cols="12">
                            <VLabel class="tiggie-label">Path Name</VLabel>
                            <VTextField placeholder="Type here ..." density="compact" />
                        </VCol>
                        <VCol cols="12">
                            <VLabel class="tiggie-label">Description</VLabel>
                            <VTextField placeholder="Type here ..." density="compact" />
                        </VCol>
                        <VCol cols="12" class="py-0">

                            <VLabel class="tiggie-label">Current Flow</VLabel>
                            <div class="coming-soon">
                                <p>Drop And Drop</p>
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
