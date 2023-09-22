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
});
let emit = defineEmits(["click:runFunction"]);
let clicked = () => {
    emit("click:runFunction");
};
</script>

<template>
    <div>
        <div v-if="props.type">
            <v-btn
                variant="flat"
                :type="props.type"
                rounded
                color="rgba(55, 73, 233, 0.10)"
                class="text-primary"
                :width="width"
                >{{ title }}</v-btn
            >
        </div>
        <div v-else>
            <Link :href="route">
                <v-btn
                    variant="flat"
                    rounded
                    color="rgba(55, 73, 233, 0.10)"
                    class="text-primary"
                    :width="width"
                    @click="clicked"
                    >{{ title }}</v-btn
                >
            </Link>
        </div>
    </div>
</template>
