<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherStorybookCard from "./components/TeacherStorybookCard.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import {
    onColumnFilter,
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";
const props = defineProps(["storyBooks"]);
let filters = ref(null);
let filterDatas = ref([
    { title: "A-Z", value: "asc" },
    { title: "Z-A", value: "desc" },
]);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
</script>
<template>
    <AdminLayout>
        <v-container>
            <div class="tbook-head-section">
                <div class="title-section">
                    <p class="tbook-heading">Storybooks</p>
                </div>
                <div class="tbook-head-button"></div>
            </div>
            <div class="d-flex justify-end align-center mb-4">
                <v-spacer></v-spacer>
                <div class="search-field">
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                        variant="solo"
                        @keyup.enter="searchItems"
                        v-model="serverParams.search"
                    ></v-text-field>
                </div>

                <div class="sort-field">
                    <selectBox
                        v-model="filters"
                        placeholder="Sort By"
                        :datas="filterDatas"
                        density="compact"
                        item_title="title"
                        item_value="value"
                    />
                </div>
            </div>
            <v-row class="mt-5">
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="item in storyBooks.data"
                    :key="item.id"
                >
                    <TeacherStorybookCard :item="item" />
                </v-col>
                <v-col cols="12" class="d-flex justify-center align-center">
                    <Pagination />
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<style scoped>
.tbook-head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tbook-heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: #000;
}

.tbook-head-button {
    align-self: flex-end;
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
