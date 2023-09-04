<script setup>
import { ref } from "vue";

import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import { router } from "@inertiajs/core";
</script>
<template>
    <v-card @click="router.get(route('teacher_storybook.show'))">
        <v-card-title style="position: relative">
            <v-img src="/images/image4.png" />
        </v-card-title>
        <v-card-text>
            <h1 class="font-weight-bold text-h6 text-center pb-4">
                Toy Story 1
            </h1>
            <p>
                When Woody is kidnapped by a greedy toy collector and is nowhere
                to be found, Buzz and his friends set out to rescue him.
            </p>
            <div class="chip-group">
                <GreenChip title="Switch" />
                <GreenChip title="Eye-Gaze" />
                <GreenChip title="Touch" />
            </div>
        </v-card-text>
    </v-card>
</template>
<style scoped>
.chip-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.green {
    color: #17cab6;
}

.chip-page {
    display: inline-flex;
    flex-direction: row;
    background-color: #282828;
    border: none;
    cursor: default;
    height: 30px;
    outline: none;
    padding: 0;
    color: #fff;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
    position: absolute;
    right: 27px;
    bottom: 17px;
}
.chip-content {
    cursor: inherit;
    display: flex;
    font-size: 12px !important;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
.chip
{
    background-color: #FfFfFf !important;
}
</style>
