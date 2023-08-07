<script setup>
import { ref } from "vue"
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

const items = ref([
    'icon1',
    'icon2',
    'icon3',
    'icon4',
]);

const selectedItem = ref("");
let description = ref("")

</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around" :gutter="10">
                <VCol cols="8">
                    <span class="tiggie-title margin-buttom-18">Add Announcement</span>
                </VCol>

                <VCol cols="8">
                    <VRow justify="space-around">
                        <VCol cols="6">
                            <VLabel class="tiggie-label">Title</VLabel>
                            <VTextField placeholder="Type here..." />
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label"></VLabel>
                            <VCombobox v-model="selectedItem" :items="items" />
                        </VCol>
                        <VCol cols="10">
                            <VTextarea placeholder="Type here ...." v-model="description" auto-grow rows="5" />
                        </VCol>
                        <VCol cols="4">
                            <VLabel class="tiggie-label">Announcement by</VLabel>
                            <VSelect :items="items" />
                        </VCol>
                        <VCol cols="4">
                            <VLabel class="tiggie-label">Announcement to</VLabel>
                            <VSelect :items="items" />
                        </VCol>
                    </VRow>

                </VCol>
                <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                    <VBtn color="gray" text-color="white" height="50" class="pl-16 pr-16">
                        <Link :href="route('plans.index')" class="cancel-btn text-center">
                        Cancel
                        </Link>
                    </VBtn>
                    <VBtn type="submit" class="finish-btn pl-5 pr-5" height="50"> Post </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
