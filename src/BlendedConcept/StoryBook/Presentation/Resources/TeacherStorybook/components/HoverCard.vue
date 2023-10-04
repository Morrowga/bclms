<script setup>
import { ref } from "vue";

import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import { router } from "@inertiajs/core";

const props = defineProps(["dataItem"]);

const getImage = (item) => {
    return item.thumbnail_img == "" || !item.thumbnail_img
        ? "/images/image8.png"
        : item.thumbnail_img;
};
</script>
<template>
    <v-card @click="router.get(route('teacher_storybook.show', dataItem.id))">
        <v-card-title class="ps-relative">
            <v-img :src="getImage(dataItem)" />
        </v-card-title>
        <v-card-text>
            <h1 class="font-weight-bold text-h6 text-center pb-4">
                {{ dataItem.name }}
            </h1>
            <p>
                {{ dataItem.description }}
            </p>
            <div class="chip-group">
                <GreenChip
                    v-for="item in dataItem.devices"
                    :title="item.name"
                    :key="item.id"
                />
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
.chip {
    background-color: #ffffff !important;
}
</style>
