<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
const deletePlaylist = () => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            SuccessDialog({
                title: "You have successfully deleted playlist!",
                color: "#17CAB6",
            });
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <h1 class="tiggie-teacher-title">Playlist</h1>
                <VRow justify="end">
                    <VCol cols="2">
                        <VTextField
                            placeholder="Search ..."
                            density="compact"
                            rounded
                        >
                            <template #append-inner>
                                <VIcon
                                    v-bind="props"
                                    icon="mdi-magnify"
                                    size="30"
                                />
                            </template>
                        </VTextField>
                    </VCol>
                    <VCol cols="2">
                        <SelectBox
                            placeholder="Sort By"
                            density="compact"
                            rounded
                        />
                    </VCol>
                </VRow>
            </VRow>
            <VRow>
                <VCol cols="3">
                    <div>
                        <VImg src="/teacherdashboard/teacherimage.png" />
                        <div class="img-text-info mb-16">
                            <h4 class="text-white pl-8">Bravery</h4>
                            <p class="text-white pl-8">
                                Assigned To:<span>Ethan Jonathan</span>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-center mt-3">
                        <Link :href="route('editplaylists')">
                            <VBtn
                                color="teal"
                                class="text-white"
                                variant="flat"
                                rounded
                            >
                                <VIcon icon="mdi-pencil" class="mr-2" />
                                <span>Edit</span>
                            </VBtn>
                        </Link>

                        <VBtn
                            color="error"
                            class="text-white ml-2"
                            variant="flat"
                            rounded
                            @click="deletePlaylist()"
                        >
                            <VIcon icon="mdi-trash-can-outline" class="mr-2" />
                            <span>Delete</span>
                        </VBtn>
                    </div>
                </VCol>
                <VCol cols="9">
                    <VRow>
                        <VCol cols="4" v-for="item in 12" :key="item">
                            <VCard>
                                <div class="playmenu"></div>
                                <v-checkbox
                                    label=""
                                    class="checkmenu ml-2"
                                ></v-checkbox>
                                <VImg
                                    src="/teacherdashboard/student1.png"
                                    height="282px"
                                    cover
                                />

                                <VCardItem>
                                    <VCardTitle
                                        class="text-center tiggie-teacher-p influcencing"
                                        >Influencing The Influencer
                                    </VCardTitle>
                                </VCardItem>
                                <VCardActions>
                                    <div class="d-flex justify-start">
                                        <VChip
                                            color="teal"
                                            class="mx-1 playlistchip"
                                            variant="outlined"
                                        >
                                            Switch
                                        </VChip>
                                        <VChip
                                            color="teal"
                                            class="mx-1 playlistchip"
                                            variant="outlined"
                                        >
                                            Eye-Gaze
                                        </VChip>
                                        <VChip
                                            color="teal"
                                            class="mx-1 playlistchip"
                                            variant="outlined"
                                        >
                                            Touch
                                        </VChip>
                                    </div>
                                </VCardActions>
                            </VCard>
                        </VCol>
                    </VRow>
                    <VRow justify="center">
                        <VCol cols="4">
                            <VBtn
                                color="pale-blue"
                                class="text-tiggie-blue"
                                variant="flat"
                                rounded
                            >
                                Load More
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.playlistchip {
    font-size: 12px !important;
}

.checkmenu {
    position: absolute !important;
    right: 0%;
    /* top: 1%; */
    z-index: 1;
    color: #e5e5e5 !important;
}

.playmenu {
    position: absolute !important;
    width: 20px;
    border-radius: 4px !important;
    padding: 10px;
    height: 20px;
    background: #e5e5e5 !important;
    z-index: 1 !important;
    color: #e5e5e5 !important;
    right: 3%;
    top: 2%;
}
.img-text-info {
    position: relative;
    bottom: 10px;
    border-radius: 0px 0px 16px 16px;
    background: rgba(22, 22, 22, 0.8);
    /* Shadown 2 */
    backdrop-filter: blur(10px);
}
.influcencing {
    color: #282828 !important;
    font-weight: 700 !important;
}
</style>
