<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "count", "label"]);
const isDialogVisible = ref(true)
</script>
<template #activator="{ props }">
    <VDialog
        v-model="isDialogVisible"
        width="500"
    >
        <!-- Activator -->
        <!-- Dialog Content -->
        <VCard class="version-card">
        <VCardText>
            <span class="ruddy-bold versiontext">Choose a version for Toy Story 2</span>
        </VCardText>
        <div class="px-7 my-6">
            <VRow>
                <VCol cols="4">
                    <VCard class="version-mini-card">
                        <div class="text-center">
                            <span class="ruddy-bold versiontext">Original</span>
                        </div>
                        <v-img src="/images/image1.png" class="mx-2" cover></v-img>
                        <div class="text-center">
                            <span class="original">The Original Copy</span>
                        </div>
                    </VCard>
                </VCol>
                <VCol cols="4">
                    <VCard class="version-mini-card">
                        <div class="text-center">
                            <span class="ruddy-bold versiontext">V3</span>
                        </div>
                        <v-img src="/images/image1.png" class="mx-2" cover></v-img>
                        <div class="text-left">
                            <p class="original ml-2 mt-2">Version 3 ww interactive elements</p>
                        </div>

                        <div class="ml-2 mt-9">
                            <v-avatar size="25">
                                <img src="/images/classroom5.jpeg" alt="">
                            </v-avatar>
                            <span class="version-profile-text ml-2">Example</span>
                        </div>
                    </VCard>
                </VCol>
                <VCol cols="4">
                    <VCard class="version-mini-card">
                        <div class="text-center">
                            <span class="ruddy-bold versiontext">V4</span>
                        </div>
                        <v-img src="/images/image1.png" class="mx-2" cover></v-img>
                        <div class="text-left">
                            <p class="original ml-2 mt-2">Version 4 ww interactive elements</p>
                        </div>

                        <div class="ml-2 mt-9">
                            <v-avatar size="25">
                                <img src="/images/classroom5.jpeg" alt="">
                            </v-avatar>
                            <span class="version-profile-text ml-2">Example</span>
                        </div>
                    </VCard>
                </VCol>
            </VRow>
        </div>
        <!-- <VCardActions>
            <VSpacer />
            <VBtn @click="isDialogVisible = false">
            I accept
            </VBtn>
        </VCardActions> -->
        </VCard>
    </VDialog>
</template>

<style scoped>
.version-profile-text{
    font-size: 10px !important;
    font-weight: bold !important;
    color: #000 !important;
}
.original{
    font-weight: bold !important;
    line-height: 1.5 !important;
    color: #000 !important;
    font-size: 10px !important;
}
.versiontext{
    color: #000 !important;
}
.version-card{
    border: 3px solid #000;
    background: #FFF2CE;
}

.version-mini-card{
    border: 3px solid #000;
    background: #fff;
    height:  210px;
}


</style>
