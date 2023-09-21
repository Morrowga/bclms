<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { router } from "@inertiajs/core";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import {
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";
const items = ["Name", "Age", "Name", "Name"];
let props = defineProps([
    'playlists'
]);
const currentPage = ref(1);

const deletePlaylist = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete('/playlists/' + id, {
                onSuccess: () => {
                    SuccessDialog({
                        title: "You have successfully deleted playlist!",
                        color: "#17CAB6",
                    });
                },
            });
        },
    });
};
console.log(props.playlists);
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
                        <Link :href="route('playlists.create')">
                            <VIcon icon="mdi-plus" class="text-white"></VIcon>
                            <span class="text-white">Add</span>
                        </Link>
                    </VBtn>
                </VCol>
                <VCol cols="12">
                    <VTextField
                        placeholder="Search ..."
                        append-inner-icon=""
                        density="compact"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                        rounded
                    >
                        <template #append-inner>
                            <VIcon icon="mdi-magnify" size="30" />
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
                            <VLabel class="tiggie-label pr-3"
                                >Assinged To</VLabel
                            >
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="3">
                            <VLabel class="tiggie-label pr-3">Actions</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow
                        class="bg-line mx-1 rounded pa-1 my-2"
                        align="center"
                        v-for="item in props.playlists.data"
                        :key="item"
                    >
                        <VCol
                            cols="3"
                            class="ml-4"
                            @click="router.get(route('playlists.show', item.id))"
                        >
                            <div
                                class="d-flex flex-row align-center justify-center gap-3"
                            >
                                <div clas="music-component">
                                    <VImg
                                        :src="item.playlist_photo"
                                        width="73px"
                                        height="56px"
                                    />
                                    <div
                                        class="music-icon bg-dark d-flex justify-center align-center gap-1 rounded"
                                    >
                                        <VIcon
                                            icon="mdi-playlist-music-outline"
                                        />
                                        <span>{{ item.storybooks.length }}</span>
                                    </div>
                                </div>
                                <span class="tiggie-p">{{ item.name  }}</span>
                            </div>
                        </VCol>
                        <VCol cols="3">
                            <p class="tiggie-p">{{ item.student.user.full_name  }}</p>
                        </VCol>

                        <VCol cols="3">
                            <div class="d-flex flex-row">
                                <VBtn
                                    color="teal"
                                    class="text-white"
                                    variant="flat"
                                    rounded
                                    @click="router.get(route('playlists.edit', item.id))"
                                >
                                    <VIcon icon="mdi-pencil" class="mr-2" />
                                    <span>Edit</span>
                                </VBtn>

                                <VBtn
                                    color="error"
                                    class="text-white ml-2"
                                    variant="flat"
                                    rounded
                                    @click="deletePlaylist(item.id)"
                                >
                                    <VIcon
                                        icon="mdi-trash-can-outline"
                                        class="mr-2"
                                    />
                                    <span>Delete</span>
                                </VBtn>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination
                            v-model="props.playlists.meta.current_page"
                            variant="outlined"
                            :length="props.playlists.meta.last_page"
                        />
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
