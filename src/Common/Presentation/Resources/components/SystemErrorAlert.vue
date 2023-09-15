<script setup>
import { defineProps, ref } from "vue";

let props = defineProps(["sytemErrorMessage"]);
</script>

<template>
    <VAlert
        variant="tonal"
        density="compact"
        type="error"
        closable
        class="mt-4 mb-4 alert-padding"
        close-label="Close Alert"
    >
        <template #text>
            <span class="fs-24"> System Error </span>
            <br />
            <span>
                {{ props.sytemErrorMessage }}
            </span>
        </template>
    </VAlert>
</template>

<style scoped>
.bg-success {
    background-color: #72e128 !important;
    color: #72e128 !important;
}

.bg-font {
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 21px;
    letter-spacing: 0.15px;
}
.alert-padding {
    padding: 6px 16px;
}
</style>
