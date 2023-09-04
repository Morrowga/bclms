<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import Create from "./LearningCreate.vue";
import Edit from "./LearningEdit.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";

let props = defineProps();

const form = useForm({});
let user = ref({});
//## start datatable section
let columns = [
    {
        label: "Learning Need Type",
        field: "learning_need",
        sortable: false,
    },
    {
        label: "Sub Learning Type",
        field: "sub_learning",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
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
        learning_need: "Social And Emotional Learning",
        sub_learning: ["Self Management", "Self Awareness", "Social Awareness"],
        description:
            "Specific learning disabilities  that affect reading and language-based skills",
    },
    {
        learning_need: "Daily Learning Skills",
        sub_learning: ["Self Care", "Mobility", "Community"],
        description:
            "Trouble paying attention, controlling impulsive behaviors and overly-active",
    },
    {
        learning_need: "Learning And Literacy",
        sub_learning: ["Sentence Structure", "Grammer", "Communication"],
        description: "Affects the ability to understand and learn math facts",
    },
    {
        learning_need: "Numeracy",
        sub_learning: ["Operation", "Problem Solving", "Data Analysis"],
        description: "Problem with movement, coordination, language and speech",
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

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
const deleteItem = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes, delete it!",
    });
};
const handleSubmit = ({ title }) => {
    SuccessDialog({ title: title });
};
</script>
<template>
    <VRow>
        <VCol cols="12" sm="12" lg="12">
            <section>
                <VCard>
                    <VCardText class="d-flex justify-between flex-wrap gap-4">
                        <!-- 👉 Export button -->
                        <div class="search-field">
                            <VTextField
                                label="Search Learning Need Type"
                                single-line
                                density="compact"
                                variant="solo"
                            />
                        </div>
                        <VSpacer />

                        <div
                            class="app-user-search-filter d-flex justify-end align-center gap-6"
                        >
                            <VRow align="center">
                                <VCol cols="6"></VCol>
                                <VCol cols="6" class="text-end">
                                    <VBtn @click="isDiability = true">
                                        <span
                                            class="text-uppercase text-white pl-4 pr-4"
                                        >
                                            Add
                                        </span>
                                    </VBtn>
                                </VCol>
                            </VRow>
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
                                v-if="dataProps.column.field == 'sub_learning'"
                                class="flex flex-wrap"
                                style="max-width: 600px"
                            >
                                <v-chip
                                    v-for="sublearn in dataProps.row
                                        .sub_learning"
                                    :key="sublearn"
                                    class="ma-2"
                                    color="primary"
                                    size="small"
                                    >{{ sublearn }}</v-chip
                                >
                            </div>
                            <div v-if="dataProps.column.field == 'action'">
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
                                            @click="isEditDiability = true"
                                        >
                                            <VListItemTitle
                                                >Edit</VListItemTitle
                                            >
                                        </VListItem>
                                        <VListItem @click="deleteItem()">
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

    <Create
        v-model:isDialogVisible="isDiability"
        :user-data="user"
        :form="form"
        @submit="handleSubmit"
    />

    <Edit
        v-model:isDialogVisible="isEditDiability"
        :user-data="user"
        :form="form"
        @submit="handleSubmit"
    />
</template>
