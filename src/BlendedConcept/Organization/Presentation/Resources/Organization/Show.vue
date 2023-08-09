<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <VRow justify="center">
                <VCol cols="6" align="center">
                    <VRow no-gutters>
                        <VCol cols="12">
                            <span class="tiggie-title">Organization Particulars</span>
                        </VCol>
                        <VCol cols="12" class="padding-right-30">
                            <span class="tiggie-label pb-5 pl-4">Organization Name</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">Blended Concepted</p>
                        </VCol>
                        <VCol cols="12" class="padding-right-30">
                            <span class="tiggie-label pb-5">Contact Name</span>
                            <p class="tiggie-p padding-left-10 padding-top-8px">Jordan Steveson</p>
                        </VCol>
                        <VCol cols="12" class="padding-right-30">
                            <span class="tiggie-label pb-5">Contact Email</span>
                            <p class="tiggie-p padding-left-36 padding-top-8px">susanna.lind57@gmail.com</p>
                        </VCol>
                        <VCol cols="12" class="padding-right-30">
                            <span class="tiggie-label pb-5">Contact Number</span>
                            <p class="tiggie-p  padding-top-8px">95159746</p>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6" align="start" justify="start">
                    <VRow>
                        <VCol cols="12">
                            <span class="tiggie-title">Logo</span>
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
                <VCol cols="6" align="center">
                    <VRow no-gutters>
                        <VCol cols="12">
                            <span class="tiggie-title">Organization Admin</span>
                        </VCol>
                        <VCol cols="12" class="">
                            <span class="tiggie-label pr-16">Organization Admin Name</span>
                            <p class="tiggie-p  pr-15  padding-top-8px">Jordan Stevenson</p>
                        </VCol>
                        <VCol cols="12" class="">
                            <span class="tiggie-label pl-3 pb-5">Organisation Admin Contact Number</span>
                            <p class="tiggie-p padding-right-20 padding-top-8px">98561483</p>
                        </VCol>
                        <VCol cols="12" class="padding-right-20">
                            <span class="tiggie-label pb-5">Login Email</span>
                            <p class="tiggie-p padding-left-36 padding-top-8px">estelle.Bailey10@gmail.com</p>
                        </VCol>
                        <VCol cols="12" class="padding-right-16">
                            <span class="tiggie-label pb-5">Login Password</span>
                            <p class="tiggie-p  padding-top-8px">*********</p>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6" align="start" justify="start">
                    <VRow>
                        <VCol cols="12">
                            <span class="tiggie-title">Organization Plan</span>
                        </VCol>
                        <VCol cols="6">
                            <div class="tiggie-label pb-1">No of Teachers</div>
                            <span><span class="text-warning">8</span> /10</span>
                        </VCol>
                        <VCol cols="6">
                            <div class="tiggie-label pb-1">Storage Size</div>
                            <span><span class="text-success">325.5 MB </span> /1 GB</span>
                        </VCol>
                        <VCol cols="6">
                            <div class="tiggie-label pb-5">No of Teachers</div>
                            <span><span class="text-warning">8</span> /10</span>
                        </VCol>
                        <VCol cols="6">
                            <div class="tiggie-label pb-1">Prices</div>
                            <span>$100</span>
                        </VCol>

                        <VBtn class="tiggie-btn-text " variant="flat" color="secondary">
                            Import Users
                        </VBtn>
                        <VCol cols="12"></VCol>
                    </VRow>
                </VCol>
            </VRow>

            <VRow justify="center">
                <VCol cols="4" class="text-center">
                        <Link :href="route('organizations.index')" class="text-dark">
                    <VBtn color="secondary" variant="tonal" class="pl-16 pr-16">
                        Cancel
                    </VBtn>
                        </Link>
                </VCol>
                <VCol cols="4" class="text-center">
                    <VBtn color="error" class="pl-16 pr-16">Delete</VBtn>
                </VCol>
                <VCol cols="4" class="text-center">
                    <VBtn class="back-btn pl-16 pr-16">
                        <Link :href="route('organizations.edit',1)" class="text-dark">
                        Edit
                        </Link>
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
