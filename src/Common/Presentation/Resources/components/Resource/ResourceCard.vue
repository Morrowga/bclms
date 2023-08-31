<script setup>
import { router } from "@inertiajs/core";
import CardAction from "@mainRoot/components/Resource/CardAction.vue";
import { defineProps } from "vue";
const props = defineProps({
    isEditMode: {
        type: Boolean,
        default: false,
    },
});
</script>
<template>
    <VCard>
        <CardAction :hidden="isEditMode" />
        <VCheckbox class="checkboxcard" v-if="isEditMode"></VCheckbox>
        <v-img src="images/chair.jpeg" cover></v-img>
        <div class="resource-label">
            <VRow>
                <VCol cols="8" class="text-left">
                    <span class="ruddy-bold"> "The Monkey Sad" </span>
                </VCol>
                <VCol cols="4" class="text-right">
                    <div class="resource-chip">
                        <v-btn class="me-chip">Me</v-btn>
                    </div>
                </VCol>
            </VRow>
            <VRow>
                <VCol cols="3">
                    <div class="d-flex justify-center">
                        <div>
                            <img
                                src="/images/media.png"
                                width="15"
                                height="15"
                                class="mt-1"
                                alt=""
                            />
                        </div>
                        <div>
                            <span class="media-text ml-1">JPG</span>
                        </div>
                    </div>
                </VCol>
                <VCol cols="4">
                    <span class="media-text">191.03 KB</span>
                </VCol>
                <VCol cols="4">
                    <span class="media-text">1920x1080</span>
                </VCol>
                <VCol cols="1">
                    <span class="media-text">1920x1080</span>
                </VCol>
            </VRow>
        </div>
    </VCard>
</template>
<style scoped>
.resourcemenu {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute;
    z-index: 1;
    cursor: pointer;
    color: #000 !important;
    right: 6%;
}
.checkboxcard {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute;
    z-index: 1;
    cursor: pointer;
    color: #000 !important;
    left: 6%;
}
.media-text {
    font-size: 13px !important;
}
.rolling-card {
    border: 3px solid #000;
    background: var(--seaform, #d7f2f0);
}

.me-chip {
    background: #fc0 !important;
    z-index: 1;
    height: 30px !important;
}
.resource-label {
    height: 13vh;
    position: absolute;
    z-index: 1;
    bottom: 0;
    font-size: 24px;
    width: 100%;
    color: white;
    background-color: #32383b;
    padding: 8px;
    border-radius: 4px;
}
</style>
