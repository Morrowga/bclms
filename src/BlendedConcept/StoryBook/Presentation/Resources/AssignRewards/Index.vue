<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
// import Show from "./Show.vue";
// import Create from "./Create.vue";
import DefaultBtn from "@mainRoot/components/Buttons/DefaultBtn.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { router } from "@inertiajs/core";

import { toastAlert } from "@Composables/useToastAlert";

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
        label: "Issued On",
        field: "issued_on",
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
        sticker: "/images/sticker1.png",
        name: "Top Price",
        date_created: "17/11/23",
        issued_on: "Perfect Score",
    },
    {
        sticker: "/images/sticker2.png",
        name: "Basic",
        date_created: "02/07/23",
        issued_on: "Completion",
    },
];

const alertNow = () => {
    alert("hello world");
};
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
    <AdminLayout>
        <v-container>
            <div class="head-section">
                <div class="title-section">
                    <p class="heading">Toy Story 2 Rewards</p>
                </div>
            </div>
            <br />
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
                                    class="w-200"
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
                                                        'assign_rewards.create'
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
                                            dataProps.column.field == 'sticker'
                                        "
                                    >
                                        <v-img
                                            :src="dataProps.row.sticker"
                                            max-height="125"
                                        />
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
                                                                    'assign_rewards.edit'
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
        </v-container>
    </AdminLayout>
</template>
<style scoped>
.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
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
.w-200 {
    width: 200px !important;
}
</style>
