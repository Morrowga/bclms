<script setup>
import { ref, defineProps } from "vue";
let model = ref(false);
import PlaylistCard from "./PlaylistCard.vue";
</script>
<template>
    <v-slide-group v-model="model" center-active show-arrows mandatory>
        <v-slide-group-item v-for="data in 8" :key="data">
            <div style="max-width: 275px" class="mx-4">
                <PlaylistCard />
            </div>
        </v-slide-group-item>
    </v-slide-group>
</template>

<style>
.control-position {
    position: relative;
}
.control-position .v-slide-group__next {
    cursor: pointer;
    position: absolute;
    top: 40px;
    right: -38px;
    height: 100%;
}
.control-position .v-slide-group__prev {
    cursor: pointer;
    position: absolute;
    top: 40px;
    left: -24px;
    height: 100%;
    z-index: 1;
}
.fit-img {
    object-fit: cover;
    width: 300px;
    height: auto;
    /* height: 100%; */
}

.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    align-self: flex-end;
}
</style>
