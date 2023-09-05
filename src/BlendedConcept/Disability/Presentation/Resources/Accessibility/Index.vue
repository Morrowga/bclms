<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
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
        label: "Description",
        field: "description",
        sortable: false,
    },
    {
        label: "Disability",
        field: "disability",
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
        name: "Eye-Gaze",
        disability: "Dyslexia",
        description:
            "Specific learning disabilities  that affect reading and language-based skills",
        status: true,
    },
    {
        name: "Eye-Gaze",
        disability: "Attention Deficit/Hyperactivity Disorder",
        description:
            "Trouble paying attention, controlling impulsive behaviors and overly-active",
        status: true,
    },
    {
        name: "Eye-Gaze",
        disability: "Dyscalculia",
        description: "Affects the ability to understand and learn math facts",
        status: false,
    },
    {
        name: "Eye-Gaze",
        disability: "Dyspraxia",
        description: "Problem with movement, coordination, language and speech",
        status: true,
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

const goRoute = (route) => {
    router.get(route);
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <h1 class="tiggie-title mb-4">Accessibility Devices</h1>
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <section>
                        <VCard>
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->

                                <VSpacer />
                                <VSpacer />
                                <VSpacer />
                                <VTextField
                                    placeholder="Search Users"
                                    density="compact"
                                    style="width: 200px"
                                />

                                <div class="d-flex">
                                    <div
                                        class="app-user-search-filter d-flex align-center justify-end gap-3"
                                    >
                                        <selectBox
                                            :datas="[]"
                                            placeholder="Sort By"
                                            density="compact"
                                            variant="solo"
                                        />
                                        <!-- 👉 Add button -->
                                        <DefaultBtn
                                            title="Add Device"
                                            @click="
                                                goRoute(
                                                    route(
                                                        'accessibility_device.create'
                                                    )
                                                )
                                            "
                                        />
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
                                        v-if="
                                            dataProps.column.field == 'status'
                                        "
                                        class="flex flex-wrap"
                                    >
                                        <VChip color="success"> Active </VChip>

                                        <VChip
                                            color="warning"
                                            v-if="true == false"
                                        >
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
                                                        () =>
                                                            router.get(
                                                                route(
                                                                    'accessibility_device.edit'
                                                                )
                                                            )
                                                    "
                                                >
                                                    <VListItemTitle
                                                        >Edit</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem @click="() => {}">
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
