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
    width: {
        type: String,
        default: "200",
    },
    route: {
        type: String,
        default: "#",
    },
    isLink: {
        type: Boolean,
        default: true,
    },
});
let emit = defineEmits(["click:runFunction"]);
let clicked = () => {
    emit("click:runFunction");
};
</script>

<template>
    <div>
        <Link v-if="isLink" :href="route">
            <v-btn variant="flat" rounded color="primary" :width="width">{{
                title
            }}</v-btn>
        </Link>
        <v-btn
            v-else
            variant="flat"
            rounded
            color="primary"
            :width="width"
            @click="clicked"
            >{{ title }}</v-btn
        >
    </div>
</template>
