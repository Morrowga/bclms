<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
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
        label: "Coins Required",
        field: "coin_required",
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
        coin_required: "100",
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
        coin_required: "100",
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
        coin_required: "100",
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
const showDetail = () => {
    router.get(route("rewards.show", { id: 1 }));
};
const editRewards = () => {
    router.get(route("rewards.edit", { id: 1 }));
};
const setInactive = () => {
    isConfirmedDialog({
        denyButtonText: "Set Inactive",
    });
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
                            <VCardText class="d-flex flex-wrap gap-4">
                                <!-- 👉 Export button -->
                                <!-- 👉 Search  -->
                                <VSpacer />

                                <div class="search-field">
                                    <VTextField
                                        @keyup.enter="searchItems"
                                        placeholder="Search Announcement"
                                        density="compact"
                                        class="pr-2"
                                        variant="solo"
                                    />
                                </div>
                                <div
                                    class="app-user-search-filter d-flex justify-end align-center"
                                >
                                    <SelectBox
                                        :datas="[
                                            'Name',
                                            'Date Sticker',
                                            'Rewards Issue',
                                            'Status',
                                        ]"
                                        placeholder="Sort By"
                                        density="compact"
                                        variant="solo"
                                    />
                                    <!-- 👉 Add Announcement button -->
                                    <VBtn class="tiggie-btn">
                                        <Link
                                            :href="route('rewards.create')"
                                            class="text-white"
                                        >
                                            Add Rewards
                                        </Link>
                                    </VBtn>
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
                                v-on:row-click="showDetail()"
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
                                            color="info"
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
                                        <VChip color="success" variant="flat">
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
                                                    @click="editRewards()"
                                                >
                                                    <VListItemTitle
                                                        >Update</VListItemTitle
                                                    >
                                                </VListItem>
                                                <VListItem
                                                    @click="setInactive()"
                                                >
                                                    <VListItemTitle
                                                        >Set
                                                        Inactive</VListItemTitle
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
:deep(.role-data-table .vgt-left-align) {
    vertical-align: middle !important;
    cursor: pointer;
}
</style>
