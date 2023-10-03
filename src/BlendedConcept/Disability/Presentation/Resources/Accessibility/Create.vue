<script setup>
import { ref, defineProps } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import { requiredValidator } from "@validators";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SampleStorybookSlider from "./components/SampleStorybookSlider.vue";

const props = defineProps(["device", "disability_types", "books"]);
const isFormValid = ref(false);
let refForm = ref();
let form = useForm({
    name: "",
    disability_types: [],
    description: "",
    status: "INACTIVE",
    storybook_id: "",
});

let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("accessibility_device.store"), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
                onError: (error) => {},
            });
        }
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm
                class="mt-6"
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="handleSubmit"
            >
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="12" class="accessibility">
                        <span class="tiggie-title margin-buttom-18">
                            Add Accessibility Device</span
                        >
                    </VCol>
                    <VCol cols="6">
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">Name</VLabel>
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Text here"
                                v-model="form.name"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.name"
                            />
                        </VCol>
                    </VCol>
                    <VCol cols="6" class="pb-0">
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label"
                                >Disability Type</VLabel
                            >
                            <VSelect
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Select disability the device is used for"
                                :items="props.disability_types"
                                item-value="id"
                                item-title="name"
                                v-model="form.disability_types"
                                multiple
                                chips
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
                                v-model="form.description"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.description"
                            />
                        </VCol>
                    </VCol>
                    <VCol cols="12" class="pt-0">
                        <SampleStorybookSlider
                            title="Select Sample Storybook"
                            :books="props.books"
                            :form="form"
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
                                    Add
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
