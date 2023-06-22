<script setup>
import { defineProps } from "vue";
import {  Link } from "@inertiajs/vue3";
import avatar4 from "@images/avatars/avatar-4.png";


let props = defineProps(["students"]);
console.log(props.students,"hello")
//## start datatable section
let columns = [
    {
        label: "Student",
        field: "name",
        sortable: false,
    },
    {
        label: "PARENT EMAIL",
        field: "email",
        sortable: false,
    },
    {
        label: "PARTENT CONTACT",
        field: "phone",
        sortable: false,
    },
    // {
    //     label: "Parent Contact",
    //     field: "contact",
    //     sortable: false,
    // },
    {
        label: "ACTION",
        field: "action",
        sortable: false,
    },
];

let rows = props.users;

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
    <section>
        <VCard>
            <VCardText class="d-flex flex-wrap gap-4">
                <!-- 👉 Export button -->
                <div class="d-flex align-center">
                    <v-btn
                        prepend-icon="mdi-export"
                        variant="outlined"
                        color="secondary"
                        >Export</v-btn
                    >
                </div>

                <VSpacer />

                <div
                    class="app-user-search-filter d-flex justify-end align-center gap-6"
                >
                    <Link :href="route('students.index')">
                        <v-btn>View More</v-btn>
                    </Link>
                </div>
            </VCardText>

            <VDivider />

            <vue-good-table
                class="role-data-table"
                styleClass="vgt-table"
                v-on:selected-rows-change="selectionChanged"
                :columns="columns"
                :rows="props.students"
                :select-options="{
                    enabled: true,
                }"
                :pagination-options="{
                    enabled: true,
                }"
            >
                <template #table-row="dataProps">
                    <div
                        v-if="dataProps.column.field == 'user'"
                        class="flex flex-nowrap"
                    >
                        <VListItem class="pa-0">
                            <!-- 👉 Avatar  -->
                            <template #prepend>
                                <VAvatar
                                    rounded
                                    :size="38"
                                    class="me-3"
                                    :image="avatar4"
                                />
                            </template>

                            <!-- 👉 Title and Subtitle -->
                            <VListItemSubtitle
                                class="text-xs text-no-wrap d-flex align-center"
                            >
                                <span> {{ dataProps.row.email }}</span>
                            </VListItemSubtitle>
                        </VListItem>
                    </div>

                    <div
                        v-if="dataProps.column.field == 'email'"
                        class="flex flex-nowrap"
                    >
                    <span> test@email.com</span>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'phone'"
                        class="flex flex-nowrap"
                    >
                    <span> 0995123456</span>
                    </div>
                    <div
                        v-if="dataProps.column.field == 'action'"
                        class="flex flex-nowrap"
                    >
                        <div class="d-flex">
                            <VBtn
                                variant="text"
                                color="secondary"
                                density="compact"
                                icon="mdi-eye-outline"
                                class="ml-2"
                            >
                            </VBtn>
                        </div>
                    </div>
                </template>
            </vue-good-table>

            <VDivider />
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
