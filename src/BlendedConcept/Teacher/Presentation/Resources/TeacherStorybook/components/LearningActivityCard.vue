<script setup>
import { router } from "@inertiajs/core";
</script>
<template>
    <v-card @click="router.get(route('add_customisation.create'))">
        <v-card-title>
            <div class="d-flex align-center" style="gap: 10px">
                <img src="/images/h5p.png" class="h5p-logo" />
                <span>Guess The Answer</span>
            </div>
        </v-card-title>
        <v-card-subtitle>
            <v-img src="/images/learning.png" />
        </v-card-subtitle>
        <v-card-text class="text-center">
            <div class="d-flex align-center" style="gap: 10px">
                <v-btn size="small">Base</v-btn>
                <v-btn size="small" color="#17CAB6" class="text-white"
                    >01:02</v-btn
                >
            </div>
            <br />
            <div class="text-center">
                <span
                    class="text-subtitle-2 font-weight-bold"
                    style="color: #000"
                >
                    Guess The Scene
                </span>
                <br />
                <span class="text-subtitle-1 font-weight-bold"
                    >To remember and recognize key moments from the movie</span
                >
            </div>
        </v-card-text>
    </v-card>
</template>
<style scoped>
.header-sec {
    width: 100%;
    gap: 10px;
}
.h5p-logo {
    width: 50px;
    height: auto;
}
</style>
