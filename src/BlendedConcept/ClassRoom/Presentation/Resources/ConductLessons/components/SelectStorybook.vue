<script setup>
import TotalStorybooks from "./TotalStorybooks.vue";
import {
    serverParams,
    searchItems,
    routeName,
} from "./useStorybooksDatatable.js";
import { defineProps } from "vue";
routeName.value = "playlists.getStorybooks";
const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            image: "",
            student_id: "",
            storybooks: "",
        },
    },
});
</script>
<template>
    <v-expansion-panel>
        <v-expansion-panel-title>
            <h2 class="font-weight-bold ruddy-bold fs-25">
                Step 1: Select Storybooks
                <!-- <v-chip class="chip-count">{{
                    props.form.storybooks.length
                }}</v-chip> -->
            </h2>
        </v-expansion-panel-title>
        <v-expansion-panel-text>
            <VRow justify="end">
                <VCol cols="2">
                    <VTextField
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                    >
                    </VTextField>
                </VCol>
                <VCol cols="2">
                    <SelectBox placeholder="Sort By" density="compact" rounded>
                    </SelectBox>
                </VCol>
            </VRow>
            <v-row>
                <v-col cols="12">
                    <TotalStorybooks :form="props.form" />
                </v-col>
            </v-row>
        </v-expansion-panel-text>
    </v-expansion-panel>
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

.chip-count {
    background: var(--seaform, #d7f2f0) !important;
    gap: 10px !important;
    border-radius: 50px !important;
    color: #17cab6 !important;
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
