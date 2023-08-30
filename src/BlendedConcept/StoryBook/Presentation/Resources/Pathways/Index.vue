<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";

let props = defineProps();

//## start datatable section
let columns = [
    {
        label: "ID",
        field: "id",
        sortable: false,
    },
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
        sortable: false,
    },

    {
        label: "Storybooks",
        field: "storybooks",
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
        id: 1,
        name: "Tiggy OMG",
        description: "Fostering inclusive education and personalized support",
        storybooks: [
            {
                name: "Toy Story 2",
            },
            {
                name: "A Walk On Tundra",
            },
        ],
        rewards_issued: "",
    },
    {
        id: 2,
        name: "Toy Story Feedback Survey",
        description:
            "Empowering to build coping skills and thrive in their environment",
        storybooks: [
            {
                name: "Toy Story 2",
            },
            {
                name: "A Walk On Tundra",
            },
        ],
    },
    {
        id: 3,
        name: "Website Experience Survey",
        description: "improve social interactions and communication skills",
        storybooks: [
            {
                name: "Toy Story 2",
            },
            {
                name: "A Walk On Tundra",
            },
        ],
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
            <h1 class="tiggie-title mb-4">Pathways</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->
                                <VBtn
                                    prepend-icon="mdi-export"
                                    variant="outlined"
                                    color="secondary"
                                    >Export</VBtn
                                >
                                <VSpacer />
                                <div
                                    class="app-user-search-filter d-flex justify-end align-center"
                                >
                                    <div class="d-flex flex-row flex-end gap-2">
                                        <!-- 👉 Search  -->

                                        <!-- 👉 Add User button -->
                                        <VBtn class="tiggie-btn">
                                            <Link
                                                :href="route('pathways.create')"
                                                class="text-white"
                                            >
                                                Add New
                                            </Link>
                                        </VBtn>
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
                                        v-if="dataProps.column.field == 'name'"
                                    >
                                        <Link
                                            style="color: #000"
                                            :href="
                                                route('pathways.show', {
                                                    id: 1,
                                                })
                                            "
                                        >
                                            {{ dataProps.row.name }}
                                        </Link>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'storybooks'
                                        "
                                    >
                                        <v-chip
                                            v-for="storybook in dataProps.row
                                                .storybooks"
                                            :key="storybook.name"
                                            class="ma-2"
                                            color="primary"
                                            size="small"
                                            >{{ storybook.name }}
                                        </v-chip>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'rewards_issued'
                                        "
                                    >
                                        <VProgressLinear
                                            color="yellow-darken-2"
                                            class="custom-progress"
                                            model-value="80"
                                            :height="8"
                                        >
                                        </VProgressLinear>
                                        <span
                                            ><span class="text-warning">8 </span
                                            >/10</span
                                        >
                                        Users
                                    </div>

                                    <div
                                        v-if="
                                            dataProps.column.field == 'status'
                                        "
                                    >
                                        <VChip color="secondary">
                                            Active
                                        </VChip>
                                    </div>
                                    <div
                                        v-if="
                                            dataProps.column.field == 'action'
                                        "
                                    >
                                        <VMenu location="end">
                                            <template #activator="{ props }">
                                                <VIcon
                                                    v-bind="props"
                                                    size="24"
                                                    icon="mdi-dots-horizontal"
                                                    color="black"
                                                    class="mt-n4"
                                                />
                                            </template>
                                            <VList>
                                                <VListItem
                                                    @click="
                                                        isEditDiability = true
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Edit</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem
                                                    @click="
                                                        deleteOrganization(
                                                            props.row.id
                                                        )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Delete</VListItemTitle
                                                    >
                                                </VListItem>
                                            </VList>
                                        </VMenu>
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
