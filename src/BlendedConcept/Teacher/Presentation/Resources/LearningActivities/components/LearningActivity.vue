<script setup>
import { computed, defineProps } from "vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";

let props = defineProps(["users"]);
//## start datatable section
let columns = [
    {
        label: "",
        field: "image",
        sortable: false,
    },
    {
        label: "Type",
        field: "type",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
        sortable: false,
    },
    {
        label: "Timestamp",
        field: "timestamp",
        sortable: false,
    },
    {
        label: "Completed",
        field: "completed",
        sortable: false,
    },
    {
        label: "% Correct",
        field: "correct",
        sortable: false,
    },
    {
        label: "Created By",
        field: "created_by",
        sortable: false,
    },
];

let rows = [
    {
        image: "/images/art.png",
        type: {
            title: "Flashcards",
            subtitle: "Questions about The Airport Scene",
        },
        description:
            "Understand the theme of friendship and sacrifice depicted in the movie",
        timestamp: "2.30",
        completed: "Yes",
        correct: "-",
        created_by: "Bc Staff",
    },
    {
        image: "/images/art2.png",
        type: {
            title: "Guess the Answer",
            subtitle: "Guess the Scene",
        },
        description: "To remember and recognize key moments from the movie",
        timestamp: "1.42",
        completed: "Yes",
        correct: "100%",
        created_by: "Me",
    },
    {
        image: "/images/art3.png",
        type: {
            title: "Guess the Answer",
            subtitle: "Guess the Scene",
        },
        description: "To remember and recognize key moments from the movie",
        timestamp: "1.42",
        completed: "Yes",
        correct: "100%",
        created_by: "Me",
    },
];

//## truncatedText
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 30) {
            return text;
        } else {
            return text?.substring(0, 30) + "...";
        }
    }
};

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex flex-wrap gap-4">
                <v-text-field
                    density="compact"
                    variant="solo"
                    label="Search templates"
                    append-inner-icon="mdi-magnify"
                    single-line
                    hide-details
                ></v-text-field>
            </VCardText>

            <VDivider />

            <vue-good-table
                class="role-data-table"
                styleClass="vgt-table"
                v-on:selected-rows-change="selectionChanged"
                :columns="columns"
                :rows="rows"
                :select-options="{
                    enabled: true,
                }"
                :pagination-options="{
                    enabled: true,
                }"
            >
                <template #table-row="dataProps">
                    <div
                        v-if="dataProps.column.field == 'image'"
                        class="flex flex-nowrap"
                    >
                        <v-img
                            :src="dataProps.row.image"
                            width="70"
                            height="70"
                        />
                    </div>
                    <div v-if="dataProps.column.field == 'type'">
                        <p class="font-weight-black mb-0">
                            {{ dataProps.row.type.title }}
                        </p>
                        <p>
                            {{ dataProps.row.type.subtitle }}
                        </p>
                    </div>
                </template>
            </vue-good-table>

            <VDivider />

            <v-card-actions class="d-flex justify-center">
                <Pagination />
            </v-card-actions>
        </VCard>
    </section>
</template>

<style lang="scss">
.vgt-table th {
    font-size: 10pt !important;
}
.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}
.vgt-wrap__footer {
    background: rgb(var(--v-theme-surface)) !important;
    border: none;
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
