<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

// import Edit from "./Edit.vue";
let props = defineProps();

//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Response",
        field: "response",
        sortable: false,
    },
];

let rows = [
    {
        name: "Albert Leon",
        response: "Student",
    },
    {
        name: "Alic",
        response: "Student",
    },
    {
        name: "John",
        response: "Student",
    },
    {
        name: "Miran",
        response: "Student",
    },
    {
        name: "Ellar",
        response: "Student",
    },
    {
        name: "Manic",
        response: "Student",
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
    // console.log(data.selectedRows);
};

const goRoute = (route) => {
    router.get(route);
};
</script>
<template>
    <div class="mt-4">
        <VRow>
            <VCol cols="12" sm="12" lg="12">
                <section>
                    <VCard>
                        <v-card-title>
                            <h1 class="tiggie-title mb-4">
                                Suggestions To Makes School Better
                            </h1>
                        </v-card-title>
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
                                <div v-if="dataProps.column.field == 'name'">
                                    <div
                                        class="d-flex justify-start align-center"
                                    >
                                        <v-avatar>
                                            <v-img
                                                src="/images/profile/profilefive.png"
                                                alt=""
                                            />
                                        </v-avatar>
                                        <div class="ml-4">
                                            <span>{{
                                                dataProps.row.name
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </vue-good-table>

                        <VDivider />
                    </VCard>
                </section>
            </VCol>
        </VRow>
    </div>
</template>
