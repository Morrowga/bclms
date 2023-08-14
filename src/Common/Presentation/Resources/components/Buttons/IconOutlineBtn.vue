<script setup>
import { defineProps, computed, defineEmits } from "vue";
import { elevated } from "../../UI/js/views/demos/components/chip/demoCodeChip";
let props = defineProps({
    type: {
        type: String,
        default: "",
    },
    title: {
        type: String,
        default: "",
    },
    color: {
        type: String,
        default: "primary",
    },
    icon: {
        type: String,
        default: "mdi-export-variant",
    },
});
let emit = defineEmits(["click:runFunction"]);
let clicked = () => {
    emit("click:runFunction");
};
</script>

<template>
    <v-btn variant="outlined" :color="color" @click="clicked">
        <VIcon :icon="icon" size="20" style="transform: rotate(270deg)"></VIcon>
        <span class="pl-4 text-primary">{{ title }}</span>
    </v-btn>
</template>
