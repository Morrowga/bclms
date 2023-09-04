<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStoryBookSlider.vue";
import AddBook from "./components/AddBook.vue";
import { SuccessDialog } from "@actions/useSuccess";

const isShowBook = ref(false);

function showBook() {
    isShowBook.value = !isShowBook.value;
}
const savePathway = () => {
    SuccessDialog({ title: "You have successfully saved Pathway" });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <div class="d-flex justify-space-between align-center">
                        <div>
                            <h1 class="tiggie-title">
                                Inclusive Learning Stars
                            </h1>
                            <p class="tiggie-p">
                                Fostering inclusive education and personalized
                                support
                            </p>
                        </div>
                        <div class="d-flex align-center gap-4">
                            <Link :href="route('pathways.index')">
                                <VBtn color="gray" width="150">Back</VBtn>
                            </Link>
                            <VBtn
                                @click="savePathway"
                                color="success"
                                width="150"
                                >Save</VBtn
                            >
                        </div>
                    </div>

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
