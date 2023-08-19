<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

const items = [
  'Name',
  'Age',
  'Name',
  'Name',
]


</script>


<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around">
                <VCol cols="6">
                    <h1 class="tiggie-teacher-title">Playlists</h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <VBtn color="primary" variant="flat" rounded>
                        <VIcon icon="mdi-plus"></VIcon>
                        <span class="text-white">Add</span>
                    </VBtn>
                </VCol>
                <VCol cols="12">
                    <VTextField placeholder="Search ..." append-inner-icon="" density="compact" rounded>
                        <template #append-inner>
                            <VIcon v-bind="props" icon="mdi-magnify" size="30"/>
                        </template>
                    </VTextField>
                </VCol>
                <VCol cols="12">
                  <VRow class="bg-line mx-1 rounded pa-1">
                    <VCol cols="3">
                       <VSelect
                       density="compact"
                       compact=""
                       :items="items"
                        placeholder="Name" size="10"/>
                    </VCol>
                    <VCol cols="3">

                    </VCol>
                    <VCol cols="3">

                    </VCol>
                  </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
