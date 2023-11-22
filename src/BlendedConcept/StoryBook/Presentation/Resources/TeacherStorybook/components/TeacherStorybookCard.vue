<script setup>
import { ref, defineProps } from "vue";
import HoverCard from "./HoverCard.vue";
let is_chip = ref(false);
import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import { router } from "@inertiajs/core";
const props = defineProps({
    isDisabled: {
        type: Boolean,
        default: false,
    },
    item: {
        type: Object,
        default: {},
    },
});

const getImage = (item) => {
    return item.thumbnail_img == "" || !item.thumbnail_img
        ? "/images/image8.png"
        : item.thumbnail_img;
};
</script>
<template>
    <div class="h-100">
        <v-hover
            class="h-100"
            v-slot="{ isHovering, props }"
            open-delay="200"
            :disabled="props.isDisabled"
        >
            <div class="main-card-book h-100">
                <v-card
                    class="h-100"
                    @click="
                        router.get(route('teacher_storybook.show', item.id))
                    "
                    v-bind="props"
                >
                    <v-card-title class="ps-relative">
                        <v-img
                            :src="getImage(item)"
                            aspect-ratio="16/9"
                            height="150"
                            cover
                        />
                        <div class="chip-page" v-if="is_chip">
                            <div class="chip-content">14 pages</div>
                        </div>
                    </v-card-title>
                    <v-card-text>
                        <h1 class="font-weight-bold text-h6 text-center pb-4">
                            {{ item?.name }}
                        </h1>
                        <div class="chip-group">
                            <GreenChip
                                v-for="element in item.devices"
                                :title="element.name"
                                :key="element.id"
                            />
                        </div>
                    </v-card-text>
                </v-card>
                <v-scale-transition>
                    <HoverCard
                        v-if="isHovering"
                        class="card-hover"
                        :dataItem="item"
                        v-bind="props"
                    />
                </v-scale-transition>
            </div>
        </v-hover>
    </div>
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
.main-card-book {
    position: relative;
    height: 100%;
}
.card-hover {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    padding-bottom: 100px;

    height: 150%;
    z-index: 10;
}

.checkbox-position {
    position: absolute;
    top: 4px;
    right: 10px;
    padding: initial;
    color: #282828;
}
.chip {
    background-color: #ffffff !important;
}
</style>
