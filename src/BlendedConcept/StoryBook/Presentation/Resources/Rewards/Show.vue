<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="6" align="center">
                    <VRow>
                        <VCol cols="8" class="text-center">
                            <span class="tiggie-title">Reward Particulars</span>
                        </VCol>
                        <VCol cols="8">
                            <span class="tiggie-label"> Name</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">Tiggy OMG</p>
                        </VCol>
                        <VCol cols="8">
                            <span class="tiggie-label"> Stars Required</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">10</p>
                        </VCol>
                        <VCol cols="8">
                            <span class="tiggie-label"> Rarity</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">Super Rare</p>
                        </VCol>
                        <VCol cols="8">
                            <span class="tiggie-label"> Rewards issued</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">82 / 100</p>
                        </VCol>
                        <VCol cols="8">
                            <span class="tiggie-label"> Current Status</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px text-green">ACTIVE</p>
                        </VCol>

                    </VRow>
                </VCol>
                <VCol cols="6" align="start" justify="start">
                    <VRow>
                        <VCol cols="12">
                            <span class="tiggie-title"> Sticker </span>
                        </VCol>
                        <VCol cols="12"></VCol>
                        <VCol cols="12"></VCol>
                        <VCol cols="12">
                            <img src="/images/defaults/organization_logo.png" />
                        </VCol>
                        <VCol cols="12"></VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="3" class="text-center">
                    <Link :href="route('organizations.index')" class="text-dark">
                    <VBtn color="secondary" variant="tonal" class="pl-16 pr-16">
                        Cancel
                    </VBtn>
                    </Link>
                </VCol>
                <VCol cols="3" class="text-center">
                    <VBtn color="primary" class="pl-16 pr-16">Update Details</VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
