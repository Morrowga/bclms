<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStoryBookSlider.vue";
import AddBook from "./components/AddBook.vue";
const isShowBook = ref(false);

function showBook() {
    isShowBook.value = !isShowBook.value;
}
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="6">
                    <h1 class="tiggie-title">Inclusive Learning Stars</h1>
                    <p class="tiggie-p">
                        Fostering inclusive education and personalized support
                    </p>

                    <h3 class="tiggie-title">Current Flow</h3>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="12" class="pt-0">
                    <SampleStorybookSlider />
                </VCol>
                <VCol>
                    <VBtn color="primary" @click="showBook">Add Books</VBtn>
                </VCol>
                <VCol cols="12">
                    <AddBook v-if="isShowBook" />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.custom-progress {
    width: 70%;
}
</style>
