<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import ClassroomCard from "@mainRoot/components/ClassroomCard/ClassroomCard.vue";
</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
                <VRow>
                    <VCol size="6">
                        <span class="span-text ruddy-bold">Classrooms</span>
                    </VCol>
                </VRow>
                <VRow>
                    <VCol
                        v-for="item in 12"
                        :key="item"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="3"
                    >
                        <ClassroomCard
                            :route="route('org-teacher-classroom.show')"
                            count="5 / 5"
                            :label="`${item} A`"
                        />
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

.span-text {
    color: var(--text, #161616) !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.class-count {
    position: absolute;
    z-index: 1;
    right: 0;
    color: #000;
    margin: 1vh;
    background-color: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(2px);
}

.class-label {
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
