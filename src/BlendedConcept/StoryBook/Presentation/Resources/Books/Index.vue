<script setup>
import { defineProps, ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Show from "./Show.vue";
import { useForm } from "@inertiajs/vue3";
import Filter from "./components/Filter.vue";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
import { checkPermission } from "@actions/useCheckPermission";
let props = defineProps([
    "storybooks",
    "learningneeds",
    "themes",
    "disability_types",
    "devices",
]);
const searchItem = ref({
    book_name: "",
});
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <v-row justify="space-between">
                <v-col md="6" sm="4">
                    <div class="title-section">
                        <p class="heading">Manage Books</p>
                        <span class="subheading"
                            >Showing {{ storybooks.data.length }} books</span
                        >
                    </div>
                </v-col>
                <v-col md="6" sm="8">
                    <div class="d-flex gap-1">
                        <v-text-field
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                            density="compact"
                            max-height="20px"
                            max-width="100px"
                        />
                        <Filter
                            :learningneed="props.learningneeds"
                            :themes="props.themes"
                            :disability_types="props.disability_types"
                            :devices="props.devices"
                        />
                        <Link
                            :href="route('books.create')"
                            v-if="checkPermission('create_book')"
                        >
                            <VBtn>Add New Book</VBtn>
                        </Link>
                    </div>
                </v-col>
            </v-row>
            <VRow class="mt-5">
                <VCol
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="data in storybooks.data"
                    :key="data.image"
                >
                    <Show
                        :data="data"
                        :disability_types="props.disability_types"
                        :devices="props.devices"
                        :themes="props.themes"
                        :learningneeds="props.learningneeds"
                    />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    display: flex;
    /* align-self: flex-end; */
}
.fit-img {
    width: 100%;
    height: 100%;
    max-height: 217px;
}
.item-frame {
    position: relative;
}
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.v-card:not(.on-hover) {
    opacity: 1;
}
</style>
