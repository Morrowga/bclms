<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
let props = defineProps([
    "classrooms",
    "students",
    "teachers",
    "flash",
    "auth",
]);
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
let flash = computed(() => usePage().props.flash);
serverPage.value = ref(props.classrooms.meta.current_page ?? 1);
serverPerPage.value = ref(10);
let permissions = computed(() => usePage().props.auth.data.permissions);
import Create from "./Create.vue";
import Edit from "./Edit.vue";

const deleteClassRoom = (id) => {
    deleteItem(id, "classrooms");
};

let columns = [
    {
        label: "NAME",
        field: "name",
        sortable: false,
    },
    {
        label: "TEACHER",
        field: "teacher",
        sortable: false,
    },
    {
        label: "Contact Number",
        field: "contact_number",
        sortable: false,
    },
    {
        label: "Number Of Student",
        field: "nofstudent",
        sortable: false,
    },

    {
        label: "ACTION",
        field: "action",
        sortable: false,
    },
];

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.classrooms?.meta?.per_page,
    setCurrentPage: props?.classrooms?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});
</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
                <VRow>
                    <VCol size="6">
                        <span class="span-text">Classrooms</span>
                    </VCol>
                    <VCol size="6" class="text-right">
                        <v-btn varient="flat" @click="() => router.get(route('classrooms.create'))"  rounded>
                            + Add
                        </v-btn>
                    </VCol>
                </VRow>
                <VRow>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard @click="() => router.get(route('showCopy'))">
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol size="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                </VRow>
                <VRow>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                </VRow>
                <VRow>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol size="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                    <VCol cols="12" sm="6" md="4" lg="3">
                        <VCard>
                            <v-chip class="class-count">
                                5  /  5
                            </v-chip>
                            <v-img
                                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                height="200px"
                                cover
                            ></v-img>
                            <div class="d-flex justify-center">
                                <span class="class-label">
                                    1A
                                </span>
                            </div>
                        </VCard>
                    </VCol>
                </VRow>
            </VContainer>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.span-text{
    color: var(--text, #161616) !important;
    /* H3 Ruddy */
    font-family: Ruddy !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.class-count{
    position: absolute;
    z-index: 1;
    right: 0;
    color: #000;
    margin: 1vh;
    background-color: rgba(255, 255, 255, 0.70);
    backdrop-filter: blur(2px);
}

.class-label{
    position: absolute;
    z-index: 1;
    bottom: 0;
    font-size: 24px;
    width: 100%;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 8px;
    border-radius: 4px;
    text-align: center;
}

.text-capitalize {
    text-transform: capitalize;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
