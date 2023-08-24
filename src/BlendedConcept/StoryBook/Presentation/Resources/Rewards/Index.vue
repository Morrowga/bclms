<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
// import Create from "./Create.vue";
// import Edit from "./Edit.vue";
let props = defineProps();

//## start datatable section
let columns = [
    {
        label: "Sticker",
        field: "sticker",
        sortable: false,
    },
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Date Created",
        field: "date_created",
        sortable: false,
    },
    {
        label: "Storybooks Assigned",
        field: "storybooks_assigned",
        sortable: false,
    },
    {
        label: "Rewards Issued",
        field: "rewards_issued",
        sortable: false,
    },
    {
        label: "Status",
        field: "status",
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
        name: "Tiggy OMG",
        date_created: "20/8/2023",
        storybooks_assigned: [
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
        name: "Toy Story Feedback Survey",
        date_created: "20/8/2023",
        storybooks_assigned: [
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
        name: "Website Experience Survey",
        date_created: "20/8/2023",
        storybooks_assigned: [
            {
                name: "Toy Story 2",
            },
            {
                name: "A Walk On Tundra",
            },
        ],
        rewards_issued: "",
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
            <h1 class="tiggie-title mb-4">Rewards</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VContainer class="">
                                <VRow justify="end" align="center">
                                    <VCol cols="4">
                                        <VTextField
                                            label="Search Rewards"
                                            density="compact"
                                            width="100"
                                        />
                                    </VCol>
                                    <Vcol cols="4">
                                        <VSelect
                                            :items="items"
                                            rounded="100%"
                                            density="compact"
                                        />
                                    </Vcol>
                                    <VCol cols="4" class="">
                                        <VBtn>
                                            <span class="text-white">
                                                Add Rewards
                                            </span>
                                        </VBtn>
                                    </VCol>
                                </VRow>
                            </VContainer>
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
                                        v-if="
                                            dataProps.column.field == 'sticker'
                                        "
                                    >
                                        <div class="d-flex flex-row gap-2">
                                            <img
                                                src="/images/defaults/reward2.png"
                                            />
                                        </div>
                                    </div>

                                    <div
                                        v-if="
                                            dataProps.column.field ==
                                            'storybooks_assigned'
                                        "
                                    >
                                        <v-chip
                                            v-for="storybook in dataProps.row
                                                .storybooks_assigned"
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
