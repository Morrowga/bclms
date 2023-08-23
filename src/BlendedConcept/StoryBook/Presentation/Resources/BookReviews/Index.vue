<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import BookReviewDetails from "./components/BookReviewDetails.vue";

let props = defineProps();

let columns = [
    {
        label: "Reviewer",
        field: "reviewer",
        sortable: false,
    },
    {
        label: "Book",
        field: "book",
        sortable: false,
    },
    {
        label: "Stars",
        field: "stars",
        sortable: false,
    },
    {
        label: "Title",
        field: "title",
        sortable: false,
    },
    {
        label: "Date",
        field: "date",
        sortable: false,
    },
    {
        label: "",
        field: "action",
        sortable: false,
    },
];

let rows = [
    {
        reviewer: "Jordan Stevenson",
        book: "Toy Story 2",
        stars: 4,
        title: "Absolute Garbage Book! Refund!!!",
        date: "02/08/23",
    },
    {
        reviewer: "Jordan Stevenson",
        book: "Toy Story 2",
        stars: 1,
        title: "Absolute Garbage Book! Refund!!!",
        date: "02/08/23",
    },
    {
        reviewer: "Jordan Stevenson",
        book: "Toy Story 2",
        stars: 2,
        title: "Absolute Garbage Book! Refund!!!",
        date: "02/08/23",
    },
    {
        reviewer: "Jordan Stevenson",
        book: "Toy Story 2",
        stars: 3,
        title: "Absolute Garbage Book! Refund!!!",
        date: "02/08/23",
    },
];

const items = ref([
    {
        title: "Edit",
        value: "edit",
    },
    {
        title: "Delete",
        value: "delete",
    },
]);

const isDiability = ref(false);
const isEditDiability = ref(false);

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
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Book Reviews</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->
                                <VSpacer />
                                <div class="app-user-search-filter">
                                    <div class="d-flex flex-row flex-end gap-2">
                                        <!-- 👉 Search  -->

                                        <!-- 👉 Add User button -->
                                        <VBtn class="tiggie-btn">
                                            <Link
                                                :href="route('pathways.create')"
                                                class="text-white"
                                            >
                                                Delete
                                            </Link>
                                        </VBtn>
                                        <BookReviewDetails />
                                    </div>
                                </div>
                            </VCardText>
                            <VDivider />

                            <vue-good-table
                                class="role-data-table"
                                styleClass="vgt-table"
                                v-on:selected-rows-change="selectionChanged"
                                :columns="columns"
                                :rows="rows"
                                :select-options="{
                                    enabled: false,
                                }"
                                :pagination-options="{ enabled: true }"
                            >
                                <template #table-row="dataProps">
                                    <div
                                        v-if="dataProps.column.field == 'stars'"
                                    >
                                        <VRating
                                            :model-value="dataProps.row.stars"
                                            active-color="#4C4E64"
                                        />
                                    </div>

                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VIcon
                                            icon="mdi-trash-can-outline"
                                            size="21"
                                        />
                                    </div>
                                </template>
                            </vue-good-table>

                            <VDivider />
                        </VCard>
                    </section>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.custom-progress {
    width: 70%;
}
</style>
