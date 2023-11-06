<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "count", "iframeSrc"]);
const isDialogVisible = ref(false);
</script>
<template #activator="{ props }">
    <div>
        <div class="d-flex justify-center">
            <iframe
                class="videoplayer"
                :src="iframeSrc"
                frameborder="0"
                allowfullscreen
            ></iframe>
            <!-- <img :src="image" class="videoplayer" @click="isDialogVisible = true" alt=""> -->
        </div>
        <VDialog v-model="isDialogVisible" width="700">
            <VCard class="gameover-card">
                <VCardText>
                    <div class="d-flex justify-center text-center">
                        <span class="ruddy-bold gameover-text ruddy-bold"
                            >congratulations,
                            <strong class="ruddy-bold">100 Stars</strong> has
                            been
                            <br />
                            added to your account!</span
                        >
                    </div>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
<style scoped>
.gameover-card {
    /* height: 400px; */
    background: url("/images/Game Pop Up.png") no-repeat;
    background-size: cover;
}

.videoplayer {
    width: 100%;
    height: 120vh;
}

.gameoverimg {
    object-fit: cover !important;
}

.gameover-text > strong {
    color: #ff6262 !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
}

.gameover-text {
    margin-top: 50% !important;
    color: var(--white, #fff);
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 40px !important;
    text-transform: capitalize;
}
</style>
