<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

const items = ref(["icon1", "icon2", "icon3", "icon4"]);

const selectedItem = ref("");
let description = ref("");

let onFormSubmit = () => {
    SuccessDialog({ title: "You've successfully posted announcement" });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm class="mt-6" @submit.prevent="onFormSubmit">
                <!-- <VRow>
                    <VCol cols="8">
                        <span class="tiggie-title margin-buttom-18"
                            >Add Announcement</span
                        >
                    </VCol>
                </VRow> -->
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="8">
                        <VRow justify="start">
                            <VCol cols="12">
                                <span class="tiggie-title margin-buttom-18"
                                    >Add Announcement</span
                                >
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="8">
                        <VRow justify="start">
                            <VCol cols="6">
                                <VLabel class="tiggie-label required"
                                    >Title</VLabel
                                >
                                <VTextField
                                    :focused="true"
                                    placeholder="Type here..."
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="2">
                                <VLabel class="tiggie-label"></VLabel>
                                <VCombobox
                                    :focused="true"
                                    v-model="selectedItem"
                                    :items="items"
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="12">
                                <VLabel class="tiggie-label required"
                                    >Message</VLabel
                                >

                                <VTextarea
                                    :focused="true"
                                    placeholder="Type here ...."
                                    v-model="description"
                                    auto-grow
                                    rows="5"
                                />
                            </VCol>
                            <VCol cols="5">
                                <VLabel class="tiggie-label required"
                                    >Announcement by</VLabel
                                >
                                <VTextField
                                    :focused="true"
                                    placeholder="Type here ...."
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="5">
                                <VLabel class="tiggie-label required"
                                    >Announcement to</VLabel
                                >
                                <VSelect
                                    :focused="true"
                                    :items="items"
                                    density="compact"
                                    placeholder="Select a group"
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol
                        cols="12"
                        class="d-flex flex-wrap justify-center gap-10 mt-10"
                    >
                        <Link
                            :href="route('announcements.index')"
                            class="text-black"
                        >
                            <VBtn color="gray" height="50" class="" width="250">
                                Cancel
                            </VBtn>
                        </Link>
                        <VBtn type="submit" class="" height="50" width="250">
                            Post
                        </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
