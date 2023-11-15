<script setup>
import { computed } from "vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import {
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";

let props = defineProps(["users", "h5p_contents"]);
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

// let rows = [
//     {
//         image: "/images/art.png",
//         type: {
//             title: "Flashcards",
//             subtitle: "Questions about The Airport Scene",
//         },
//         description:
//             "Understand the theme of friendship and sacrifice depicted in the movie",
//         timestamp: "2.30",
//         completed: "Yes",
//         correct: "-",
//         created_by: "Bc Staff",
//     },
//     {
//         image: "/images/art2.png",
//         type: {
//             title: "Guess the Answer",
//             subtitle: "Guess the Scene",
//         },
//         description: "To remember and recognize key moments from the movie",
//         timestamp: "1.42",
//         completed: "Yes",
//         correct: "100%",
//         created_by: "Me",
//     },
//     {
//         image: "/images/art3.png",
//         type: {
//             title: "Guess the Answer",
//             subtitle: "Guess the Scene",
//         },
//         description: "To remember and recognize key moments from the movie",
//         timestamp: "1.42",
//         completed: "Yes",
//         correct: "100%",
//         created_by: "Me",
//     },
// ];

//make as previous
const rows = computed(() => {
    if (props.h5p_contents.data) {
        return props.h5p_contents.data.map((content) => ({
            image: content.image ?? "/images/art3.png",
            type: {
                title:
                    JSON.parse(content.parameters)?.interactiveVideo?.assets
                        ?.interactions[0]?.libraryTitle ?? "-",
                subtitle: "",
            },
            description:
                JSON.parse(content.parameters)?.interactiveVideo?.assets
                    ?.interactions[0]?.libraryTitle ?? "-",
            timestamp:
                JSON.parse(content.parameters).interactiveVideo?.assets
                    ?.endscreens[0]?.time ?? "-",
            completed: content.completed ? "Yes" : "No",
            correct: content.correct ? `${content.correct}%` : "-",
            created_by: content.eloquent_user?.full_name ?? "-",
        }));
    }
});

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
    // console.log(data.selectedRows);
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-start">
                <VCol cols="6">
                    <h1 class="tiggie-teacher-title">Learning Activities</h1>
                </VCol>
                <VCol cols="12">
                    <VTextField
                        placeholder="Search ..."
                        append-inner-icon=""
                        density="compact"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                        rounded
                    >
                        <template #append-inner>
                            <VIcon icon="mdi-magnify" size="30" />
                        </template>
                    </VTextField>
                </VCol>
                <VCol cols="12">
                    <VRow class="bg-line mx-1 rounded pa-1 mb-5" align="center">
                        <VCol cols="1" class="">
                            <VLabel class="tiggie-label pr-3"></VLabel>
                        </VCol>
                        <VCol cols="1" class="">
                            <VLabel class="tiggie-label pr-3">Type</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label pr-3"
                                >Description</VLabel
                            >
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label pr-3">Timestamp</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label pr-3">Completed</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label pr-3">% Correct</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label pr-3"
                                >Created By</VLabel
                            >
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow
                        class="bg-line mx-1 rounded pa-1 my-2"
                        align="center"
                        v-for="h5p_contents in rows"
                        :key="h5p_contents.id"
                    >
                        <VCol cols="1">
                            <VImg
                                :src="h5p_contents.image"
                                width="73px"
                                height="56px"
                            />
                        </VCol>
                        <VCol cols="1">
                            <p class="tiggie-p">
                                {{ h5p_contents.type.title }}
                            </p>
                        </VCol>
                        <VCol cols="2">
                            <p class="tiggie-p">
                                {{ h5p_contents.description }}
                            </p>
                        </VCol>

                        <VCol cols="2">
                            <p class="tiggie-p">
                                {{ h5p_contents.timestamp }}
                            </p>
                        </VCol>

                        <VCol cols="2">
                            <p class="tiggie-p">
                                {{ h5p_contents.completed }}
                            </p>
                        </VCol>

                        <VCol cols="2">
                            <p class="tiggie-p">
                                {{ h5p_contents.correct }}
                            </p>
                        </VCol>

                        <VCol cols="2">
                            <p class="tiggie-p">
                                {{ h5p_contents.created_by }}
                            </p>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination
                            v-model="props.h5p_contents.current_page"
                            variant="outlined"
                            :length="props.h5p_contents.last_page"
                        />
                    </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
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
