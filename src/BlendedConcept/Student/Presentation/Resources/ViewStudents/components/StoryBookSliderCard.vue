<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/core";
let is_description = ref(false);
let is_chip = ref(true);
const props = defineProps(["data", "student_id"]);
const setImage = () => {
    return props.data.thumbnail_img == "" || !props.data.thumbnail_img
        ? "/images/defaults/organisation_logo.png"
        : props.data.thumbnail_img;
};
</script>
<template>
    <v-card
        min-width="275"
        class="grab-pointer"
        @click="
            router.get(
                route('learning_activities.index', {
                    storybook: data.id,
                    student: student_id,
                })
            )
        "
    >
        <v-card-title class="ps-relative">
            <v-img :src="setImage()" />
            <div class="chip-page" v-if="is_chip">
                <div class="chip-content">70%</div>
            </div>
        </v-card-title>
        <v-card-text>
            <h1 class="font-weight-bold text-h6 text-center pb-4">
                {{ data.name }}
            </h1>
            <p v-if="is_description">
                {{ data.description }}
            </p>
            <div class="chip-group">
                <div
                    class="chip green"
                    v-for="device in data.devices"
                    :key="device.id"
                >
                    <div class="chip-content">{{ device.name }}</div>
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>
<style scoped>
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 30px;
    outline: none;
    padding: 0;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
    border: 1px solid #17cab6;
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
</style>
