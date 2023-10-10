<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "count", "label"]);
const isDialogVisible = ref(false)
</script>
<template #activator="{ props }">
    <VRow class="mt-8">

            <VCol cols="6" class="text-center">
                <v-btn  @click="isDialogVisible = true" variant="flat" color="#282828" width="200" height="100"  class="rollbtn pppangram-bold">Roll Once</v-btn>
                <div class="text-center">
                    <span class="rolltext ruddy-bold">Spend <strong class="ruddy-bold">1 Gold Coin</strong></span>
                </div>
            </VCol>
            <VCol cols="6" class="text-center">
                <v-btn @click="isDialogVisible = true" variant="flat" color="#282828" width="200" height="100" class="rollbtn mx-3 pppangram-bold">Roll 10 Times</v-btn>
                <div class="text-center">
                    <span class="rolltext ruddy-bold">Spend <strong class="ruddy-bold">8 Gold Coin</strong></span>
                </div>
            </VCol>
        </VRow>
    <VDialog
        v-model="isDialogVisible"
        width="500"
    >
        <!-- Activator -->
        <!-- Dialog Content -->
        <VCard class="rolling-card">
        <VCardText>
                <v-img src="/images/rolling.gif" cover></v-img>
                <div class="d-flex justify-center">
                    <span class="ruddy-bold rolling-text">Rolling for sticker</span>
                </div>
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
.rolling-card{
    border: 3px solid #000;
    background: var(--seaform, #D7F2F0);
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
