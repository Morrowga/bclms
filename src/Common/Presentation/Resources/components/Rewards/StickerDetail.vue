<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "title", "image"]);
const isDialogVisible = ref(false)
</script>
<template #activator="{ props }">
     <VCard class="stickercard text-center" @click="isDialogVisible = true">
        <v-img :src="image" class="stickimg-reward" cover></v-img>
        <div>
            <span class="stickertext ruddy-bold">{{title}}</span>
        </div>
        <div>
            <v-chip class="sticker-chip text-left">
                <img src="/images/chipcoin.png" class="">
                <span class="sticker-chip-text ruddy-bold"> 10</span>
                <span class="sticker-chip-or-text mx-2 ruddy-bold">OR</span>
                <img src="/images/chipcoin2.png">
                <span class="sticker-chip-text ruddy-bold">1</span>
            </v-chip>
        </div>
    </VCard>
    <VDialog
        v-model="isDialogVisible"
        width="800"
    >
        <!-- Activator -->
        <!-- Dialog Content -->
        <VCard class="detail-card">
        <VCardText>
            <VRow>
                <VCol cols="6">
                    <div class="d-flex justify-center">
                        <img :src="image" class="detailimg" alt="">
                    </div>
                </VCol>
                <VCol cols="6">
                    <div class="text-center">
                        <span class="head-detail ruddy-bold">{{ title }}</span>
                    </div>
                    <div class="text-center">
                        <span class="small-detail ruddy-bold">Ultra Rare</span>
                    </div>
                    <div class="text-center mt-3">
                        <span class="description-detail ruddy-bold">
                            "Tiggie is here to fight against <br>
                            The Darkness And Save <br>
                            Humanity"
                        </span>
                    </div>
                    <div class="mt-5 d-flex justify-center">
                        <v-btn class="detail-btn" variant="flat" color="#FF6262">Own This Sticker Now!</v-btn>
                    </div>
                </VCol>
            </VRow>
        </VCardText>
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
.detail-card{
    border: 3px solid #000;
    padding: 20px;
    background: var(--seaform, #D7F2F0);
}

.stickimg-reward{
    height: 180px !important;
    object-fit: cover !important;
}

.detail-btn{
    display: inline-flex;
    color: #fff;
    height: 80px;
    padding: 34px 18px 33px 31px;
    justify-content: flex-end;
    align-items: center;
    flex-shrink: 0;
}

.small-detail{
    color: #DAA262 !important;
    font-size: 10px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize;
}

.head-detail{
    color: #000 !important;
    font-size: 15px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 173.333% */
    text-transform: capitalize;
}

.description-detail{
    color: #000 !important;
    font-style: italic !important;
    font-weight: 400 !important;
}

.detailimg{
    width: 300px;
    height: 300px;
    object-fit: cover;
}

.rolling-text{
    bottom: 4%;
    color: var(--teal, #17CAB6) !important;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 104% */
    text-transform: capitalize;
    position: absolute !important;
}
</style>
