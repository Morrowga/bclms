<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around" :gutter="5">
                <VCol cols="6">
                    <VRow justify="center" noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">Organisation Particulars</h1>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Organisation Name</h4>
                            <p class="tiggie-p">Blended Concept</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Name</h4>
                            <p class="tiggie-p">Jordan Steveson</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Email</h4>
                            <p class="tiggie-p">susanna.lind57@gmail.com</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Number</h4>
                            <p class="tiggie-p">95159746</p>
                        </VCol>
                    </VRow>

                </VCol>
                <VCol cols="6">
                    <VRow>
                        <VCol cols="10">
                            <h1 class="tiggie-title">Logo</h1>
                        </VCol>
                        <VCol cols="10">
                            <VImg src="/images/defaults/organization_logo.png" width="234px" height="256px" />
                        </VCol>

                    </VRow>

                </VCol>
            </VRow>
            <VRow justify="space-around" :gutter="5">
                <VCol cols="6">
                    <VRow justify="center" noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">Organisation Admin</h1>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Organization Admin Name</h4>
                            <p class="tiggie-p">Jordan Stevenson</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Organisation Admin Contact Number</h4>
                            <p class="tiggie-p">98561483</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Login Email</h4>
                            <p class="tiggie-p">estelle.Bailey10@gmail.com</p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Password</h4>
                            <p class="tiggie-p">*********</p>
                        </VCol>

                    </VRow>
                </VCol>
                <VCol cols="6">
                    <VRow noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">Organisation Plan</h1>
                        </VCol>
                        <VCol cols="10">
                           <VRow>
                            <VCol cols="6">
                                <h1 class="tiggie-label pb-3">No of Teachers</h1>
                                <p>
                                    <span class="text-warning">
                                        8
                                    </span>
                                    <span>/10</span>
                                </p>
                            </VCol>
                            <VCol cols="6">
                                <h1 class="tiggie-label pb-3">No of Teachers</h1>
                                <p>
                                    <span class="text-success">
                                     324.3 MB
                                    </span>
                                    <span>/1GB</span>
                                </p>
                            </VCol>
                            <VCol cols="6">
                                <h1 class="tiggie-label pb-3">No of Teachers</h1>
                                <p>
                                    <span class="text-warning">
                                        82
                                    </span>
                                    <span>/100</span>
                                </p>
                            </VCol>
                            <VCol cols="6">
                                <h1 class="tiggie-label pb-3">No of Teachers</h1>
                                <p>
                                    <span>$100</span>
                                </p>
                            </VCol>
                            <VCol cols="6">
                                <VBtn class="text-white" color="secondary">
                                    Import Users
                                </VBtn>
                            </VCol>
                           </VRow>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
              <VCol cols="4">
                <VBtn class="text-dark pl-16 pr-16" color="gray">Back</VBtn>
              </VCol>
              <VCol cols="4">
                <VBtn class="text-white pl-16 pr-16" color="candy-red">Delete</VBtn>
              </VCol>
              <VCol cols="4">
                <VBtn class="text-dark pl-16 pr-16" color="primary">Edit</VBtn>
              </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
