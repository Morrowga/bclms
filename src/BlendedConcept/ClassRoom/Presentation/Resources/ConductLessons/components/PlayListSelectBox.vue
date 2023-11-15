<script setup>
import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

import axios from "axios";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    datas,
    routeName,
} from "./useStudentsDatatable.js";

const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            description: "",
            image: "",
            students: [],
            teachers: [],
        },
    },
});

const panel = ref(0);

const extractStudentId = (studentId) => {
    // console.log("Student ID:", studentId);
};

const selectedStorybooks = ref([]);

// Function to add or remove a storybook ID from the selectedStorybooks array
const toggleSelectedStorybook = (storybookId) => {
    const index = selectedStorybooks.value.indexOf(storybookId);
    if (index === -1) {
        selectedStorybooks.value.push(storybookId);
    } else {
        selectedStorybooks.value.splice(index, 1);
    }
    // console.log(selectedStorybooks.value);
};
</script>

<template>
    <VExpansionPanels v-model="panel">
        <v-expansion-panel>
            <v-expansion-panel-title>
                <h2 class="font-weight-bold ruddy-bold fs-25">
                    Step 2: Select Students
                    <v-chip class="chip-count">{{
                        props.form.students.length
                    }}</v-chip>
                </h2>
            </v-expansion-panel-title>
            <v-expansion-panel-text>
                <div class="d-flex justify-end align-center mb-4">
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                    ></v-text-field>
                </div>
                <v-row>
                    <v-col cols="12">
                        <TotalStudents :form="props.form" />
                    </v-col>
                </v-row>
            </v-expansion-panel-text>
        </v-expansion-panel>
        <VExpansionPanel>
            <VExpansionPanelTitle class="tiggie-teacher-title"
                >Step 2: Select Storybooks</VExpansionPanelTitle
            >
            <VExpansionPanelText>
                <VRow justify="end">
                    <VCol cols="2">
                        <VTextField
                            placeholder="Search ..."
                            density="compact"
                            rounded
                        >
                            <template #append-inner>
                                <VIcon
                                    v-bind="props"
                                    icon="mdi-magnify"
                                    size="30"
                                />
                            </template>
                        </VTextField>
                    </VCol>

                    <VCol cols="2">
                        <SelectBox
                            placeholder="Sort By"
                            density="compact"
                            rounded
                        >
                        </SelectBox>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol
                        cols="3"
                        v-for="item in datas"
                        :key="item"
                        class="pa-1"
                    >
                        <VCard>
                            <VImg
                                :src="
                                    item.thumbnail_img == '' ||
                                    item.thumbnail_img == null
                                        ? 'images/2.jpg'
                                        : item.thumbnail_img
                                "
                                height="282px"
                                cover
                            />
                            <div class="select-box">
                                <VCheckbox
                                    color="secondary"
                                    class="checkbox-position"
                                    :value="item.id"
                                    @change="toggleSelectedStorybook(item.id)"
                                />
                            </div>
                            <VCardItem>
                                <VCardTitle
                                    class="text-center tiggie-teacher-p tiggie-black-color fw-700"
                                >
                                    <!-- {{}} -->
                                </VCardTitle>
                            </VCardItem>
                            <VCardActions>
                                <div class="d-flex gap-1">
                                    <GreenChip title="Switch" />
                                    <GreenChip title="Eye-Gaze" />
                                    <GreenChip title="Touch" />
                                </div>
                            </VCardActions>
                        </VCard>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="2">
                        <VBtn
                            variant="flat"
                            color="pale-blue"
                            class="text-tiggie-blue"
                            rounded
                        >
                            Load more
                        </VBtn>
                    </VCol>
                </VRow>
            </VExpansionPanelText>
        </VExpansionPanel>
    </VExpansionPanels>
</template>

<style lang="scss">
.delivery-options {
    .v-selection-control-group {
        inline-size: 100%;
    }
}

.delivery-option {
    padding: 1rem;
    border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));

    &.active {
        border-color: rgb(var(--v-theme-primary));
    }
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

input[type="checkbox"] {
    accent-color: red !important;
}
</style>
