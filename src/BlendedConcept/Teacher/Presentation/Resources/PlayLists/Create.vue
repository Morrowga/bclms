<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import PlayListSelectBox from "./components/PlayListSelectBox.vue"
</script>

<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around">
                <VCol cols="12">
                    <h4 class="tiggie-teacher-title">Create Playlist</h4>
                </VCol>
                <VCol cols="6" class="pr-10">
                    <VImg src="/images/defaults/uploadimage.png" width="100%" style="border:3px solid #565660" />
                </VCol>

                <VCol cols="6">
                    <h1 class="tiggie-teacher-subtitle mb-5">Playlist Details</h1>

                    <VLabel class="tiggie-teacher-label mb-2 required">Name</VLabel>

                    <VTextField placeholder="e.g. Bravery" color="line" />
                </VCol>
                <VCol cols="12">
                    <!-- 👉 Collapsible Section -->
                    <PlayListSelectBox />
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4">
                   <div class="d-flex gap-3">
                    <VBtn class="text-tiggie-blue px-16" color="pale-blue" variant="flat" rounded>
                      Cancel
                    </VBtn>
                    <VBtn class="text-white px-16" color="primary" variant="flat" rounded>
                      Create
                    </VBtn>
                   </div>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
