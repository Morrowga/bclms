<script setup>
import PhysicalResourcesCard from "./PhysicalResourcesCard.vue";
import { ref } from "vue";
let model = ref(false);
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Physical Resources </span>
        </div>
        <div class="body-sec">
            <v-slide-group v-model="model" center-active show-arrows mandatory>
                <v-slide-group-item v-for="item in 10" :key="item">
                    <PhysicalResourcesCard />
                </v-slide-group-item>
            </v-slide-group>
        </div>
    </div>
</template>
<style scoped>
.header-sec {
    width: 100%;
    gap: 20px;
}
.header-sec span {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.body-sec {
    padding-top: 40px;
}
</style>
