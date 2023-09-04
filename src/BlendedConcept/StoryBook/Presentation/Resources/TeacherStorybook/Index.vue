<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherStorybookCard from "./components/TeacherStorybookCard.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
const alertNow = () => {
    alert("hello world");
};
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
                    ></v-text-field>
                </div>

                <div class="sort-field">
                    <SelectBox
                        :datas="[
                            'A-Z',
                            'Z-A',
                            'Pages:Low to Height',
                            'Pages:High to Low',
                        ]"
                        placeholder="Sort By"
                        density="compact"
                        variant="solo"
                    />
                </div>
            </div>
            <v-row class="mt-5">
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="item in 24"
                    :key="item"
                >
                    <TeacherStorybookCard />
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
