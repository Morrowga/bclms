<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

const items = [
    'Name',
    'Age',
    'Name',
    'Name',
]

const currentPage = ref(1);


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
                            <VIcon v-bind="props" icon="mdi-magnify" size="30" />
                        </template>
                    </VTextField>
                </VCol>
                <VCol cols="12">
                    <VRow class="bg-line mx-1 rounded pa-1 mb-5" align="center">
                        <VCol cols="3" class="ml-4">
                            <VLabel class="tiggie-label pr-3">Name</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="3">
                            <VLabel class="tiggie-label pr-3">Assinged To</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="3">
                            <VLabel class="tiggie-label pr-3">Actions</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow class="bg-line mx-1 rounded pa-1 my-2" align="center" v-for="item in 7" :key="item">
                        <VCol cols="3" class="ml-4">
                            <div class="d-flex flex-row align-center justify-center gap-3 ">
                                <div clas="music-component">
                                    <VImg src="/teacherdashboard/videoicon1.svg" width="73px" height="56px" />
                                    <div class="music-icon bg-dark d-flex justify-center align-center gap-1 rounded">
                                        <VIcon icon="mdi-playlist-music-outline" />
                                        <span>3</span>
                                    </div>
                                </div>
                                <span class="tiggie-p">Self-Love</span>
                            </div>
                        </VCol>
                        <VCol cols="3">
                            <p class="tiggie-p">William Tan</p>
                        </VCol>

                        <VCol cols="3">
                            <div class="d-flex flex-row">
                                <VBtn color="teal" class="text-white" variant="flat" rounded>
                                    <VIcon icon="mdi-pencil" class="mr-2" />
                                    <span>Edit</span>
                                </VBtn>

                                <VBtn color="error" class="text-white ml-2" variant="flat" rounded>
                                    <VIcon icon="mdi-trash-can-outline" class="mr-2" />
                                    <span>Edit</span>
                                </VBtn>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination v-model="currentPage" variant="outlined" :length="5" />
                    </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>


<style scoped>
.music-icon {
    width: 73px;
    height: 18px;
}
</style>
