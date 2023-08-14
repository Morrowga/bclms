<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StickerLibrary from "./components/StickerLibrary.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

let form = useForm({
    isCustomization: false,
});

let onFormSubmit = () => {
    SuccessDialog({ title: "Successfully rewards assigned" });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
                <VRow
                    justify="space-around"
                    :gutter="10"
                    class="fix-with-sticker"
                >
                    <VCol cols="12" class="accessibility">
                        <div class="d-flex justify-between aligns-center">
                            <span class="tiggie-title margin-buttom-18">
                                Edit Rewards For: Toy Story 2</span
                            >
                            <div class="d-flex justify-end aligns-center w-100">
                                <div>
                                    <Link
                                        :href="route('assign_rewards.index')"
                                        class="text-black"
                                    >
                                        <VBtn
                                            color="gray"
                                            height="50"
                                            class=""
                                            width="200"
                                            size="small"
                                        >
                                            Cancel
                                        </VBtn>
                                    </Link>
                                    <VBtn
                                        type="submit"
                                        class="ml-10 text-white"
                                        height="50"
                                        width="200"
                                        color="var(--sucess, #48BC65)"
                                        size="small"
                                    >
                                        Update
                                    </VBtn>
                                </div>
                            </div>
                        </div>
                    </VCol>

                    <VCol cols="12" md="12">
                        <VCol cols="12" md="6">
                            <VLabel class="tiggie-label">Reward Name</VLabel>
                            <VTextField
                                type="text"
                                class="tiggie-resize-input-text"
                                placeholder="Text here"
                            />
                        </VCol>
                    </VCol>

                    <VCol cols="12" md="12">
                        <VCol cols="12" md="6">
                            <VLabel class="tiggie-label">Issued On</VLabel>
                            <SelectBox
                                class="tiggie-resize-input-text"
                                :datas="[]"
                            />
                        </VCol>
                    </VCol>
                </VRow>
                <br />
                <StickerLibrary />
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.accessibility .tiggie-title {
    padding-left: 10px !important;
}
.fix-with-sticker {
    padding-left: 55px;
}
</style>
