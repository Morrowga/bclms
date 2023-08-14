<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStorybookSlider.vue";

let form = useForm({
    isCustomization: false,
    isPresentation: false,
    isFullAccess: false,
    isConcurrentAccess: false,
    isWeeklyLearningReport: false,
    isDedicatedStudentReport: false,
});

let onFormSubmit = () => {
    SuccessDialog({ title: "Successfully Device updated" });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="12" class="accessibility">
                        <span class="tiggie-title margin-buttom-18">
                            Edit Accessibility Device</span
                        >
                    </VCol>
                    <VCol cols="6">
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">Name</VLabel>
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Text here"
                            />
                        </VCol>
                    </VCol>
                    <VCol cols="6" class="pb-0">
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label"
                                >Disability Type</VLabel
                            >
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Select disability the device is used for"
                            />
                        </VCol>
                    </VCol>
                    <VCol cols="12" class="pt-0">
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">Description</VLabel>
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Type Here"
                            />
                        </VCol>
                    </VCol>
                    <VCol cols="12" class="pt-0">
                        <SampleStorybookSlider
                            title="Select Sample Storybook"
                        />
                    </VCol>
                    <VCol cols="12" class="pt-0">
                        <div class="d-flex justify-center aligns-center w-100">
                            <div>
                                <Link
                                    :href="route('accessibility_device.index')"
                                    class="text-black"
                                >
                                    <VBtn
                                        color="gray"
                                        height="50"
                                        class=""
                                        width="200"
                                    >
                                        Cancel
                                    </VBtn>
                                </Link>
                                <VBtn
                                    type="submit"
                                    class="ml-10"
                                    height="50"
                                    width="200"
                                >
                                    Update
                                </VBtn>
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style>
.accessibility .tiggie-title {
    padding-left: 10px !important;
}
</style>
