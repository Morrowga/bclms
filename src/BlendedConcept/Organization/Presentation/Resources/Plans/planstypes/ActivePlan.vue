<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { ref, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import {SuccessDialog} from '@actions/useSuccess';

// import avatar4 from "@images/avatars/avatar-4.png";

let props = defineProps();

const actions = ref([
    {
        title: 'Edit',
        value: 'edit',
    },
    {
        title: 'Delete',
        value: 'delete',
    }
]);
let searchItem = ref("")
let columns = [
    {
        label: "",
        field: "id",
        sortable: false,
    },
    {
        label: "Plan Name",
        field: "plan_name",
        sortable: false,
    },
    {
        label: "Description",
        field: "description",
        sortable: false,
    },
    {
        label: "Price",
        field: "price",
        sortable: false,
    },
    {
        label: "No. of Students",
        field: "no_students",
        sortable: false,
    },
    {
        label: "Storage Space",
        field: "storage_space",
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
        plan_name: "Basic Plan",
        description: "Allow access to basic features",
        price: "$4.99",
        no_students: 1,
        storage_space: "1GB"
    },
    {
        id: 2,
        plan_name: "Medium Plan",
        description: "Allow access to more features",
        price: "$8.99",
        no_students: 2,
        storage_space: "5GB"
    },
    {
        id: 3,
        plan_name: "Premium Pro Plan",
        description: "Allow access to all features",
        price: "$10.99",
        no_students: 5,
        storage_space: "20GB"
    }
];


const items = [
    'Foo',
    'Bar',
]



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

const deletePlan = () => {
SuccessDialog({title:"Subscription plan deleted"})

}

const setInactive = () => {
SuccessDialog({title:"Subscription plan has been set inactivated"})

}
</script>
<template>
    <section>
        <VCard>
            <VCardText class="d-flex flex-wrap gap-4">
                <!-- 👉 Export button -->
                    <VTextField
                    v-model="searchItem"
                     density="compact"
                     placeholder="Search Subscription Plans" />
                <VSpacer />

                <div class="app-user-search-filter d-flex justify-end align-center gap-6">
                    <VBtn class="tiggie-btn" height="40">
                        <Link :href="route('plans.create')" class="text-white"> Add Subscription Plan </Link>
                    </VBtn>
                </div>
            </VCardText>

            <VDivider />

            <vue-good-table class="role-data-table" styleClass="vgt-table" v-on:selected-rows-change="selectionChanged"
                :columns="columns" :rows="rows" :select-options="{
                    enabled: true,
                }" :pagination-options="{
    enabled: true,
}">
                <template #table-row="dataProps">
                    <div v-if="dataProps.column.field === 'user'">
                        <div class="d-flex flex-row gap-2 ">
                            <img src="/images/defaults/avator.png" class="user-profile-image" />
                            <span>Jordan Stevenson</span>
                        </div>
                    </div>
                    <div v-if="dataProps.column.field == 'action'">
                        <VMenu location="end">
                            <template #activator="{ props }">
                                <VIcon v-bind="props" size="24" icon="mdi-dots-horizontal" color="black" class="mt-n4" />
                            </template>
                            <VList>
                                 <VListItem @click="() => router.get(route('plans.show'))">
                                     <VListItemTitle>View</VListItemTitle>
                                </VListItem>
                                <VListItem @click="() => router.get(route('plans.edit'))">
                                     <VListItemTitle>Edit</VListItemTitle>
                                </VListItem>
                                <VListItem @click="setInactive">
                                     <VListItemTitle>Set Inactive</VListItemTitle>
                                </VListItem>
                                <VListItem @click="deletePlan">
                                     <VListItemTitle>Delete</VListItemTitle>
                                </VListItem>
                            </VList>
                        </VMenu>
                    </div>
                </template>
            </vue-good-table>

            <VDivider />
        </VCard>
    </section>
</template>

<style lang="scss" >
.vgt-table th {
    font-size: 10pt !important;
}

.vgt-table th.vgt-checkbox-col {
    background: rgb(var(--v-theme-surface)) !important;
    padding: 15px;
    border-right: none;
    border-bottom: 1px solid #dcdfe6;
}

// .v-input__control {
//     height: 50px !important;
//     top: 10px !important;
// }

// .v-input__control .v-label.v-field-label {
//     top: 10px !important;
// }
</style>
    height: 50px !important;
