<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import axios from "axios";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
    datas,
    routeName,
} from "./useTeachersDatatable.js";
const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            description: "",
            image: "",
            students: [],
            teachers: [],
        },
    },
});
//## start datatable section
let columns = [
    {
        label: "Name",
        field: "name",
        sortable: false,
    },
    {
        label: "Email Level",
        field: "email",
        sortable: false,
    },
    {
        label: "Contact Number",
        field: "contact_number",
        sortable: false,
    },
];
let rows = ref([]);

serverPage.value = ref(datas.value?.current_page ?? 1);
serverPerPage.value = ref(10);
routeName.value = "classrooms.getTeachers";
watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

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
const userImage = (user) => user.image_url ?? "/images/profile/profilefive.png";
</script>
<template>
    <section>
        <VCard>
            <VDivider />

            <VCol cols="12">
                <VRow class="bg-line mx-1 rounded pa-1 mb-5" align="center">
                    <VCol cols="4" class="d-flex justify-center">
                        <VLabel class="tiggie-label"> Name </VLabel>
                        <VIcon icon="mdi-menu-down"></VIcon>
                    </VCol>
                    <VCol cols="4">
                        <VLabel class="tiggie-label"> Email </VLabel>
                    </VCol>
                    <VCol cols="4">
                        <VLabel class="tiggie-label"> Contact Number </VLabel>
                        <VIcon icon="mdi-menu-down"></VIcon>
                    </VCol>
                </VRow>
                <VRow
                    class="bg-line mx-1 rounded pa-1 my-2"
                    v-for="data in datas.data"
                    :key="data.id"
                    align="center"
                >
                    <VCol cols="4">
                        <div class="d-flex align-center">
                            <div class="d-flex align-center">
                                <v-checkbox
                                    v-model="props.form.teachers"
                                    :value="data.b2b_user?.teacher_id"
                                />
                                <v-img
                                    width="100"
                                    :aspect-ratio="16 / 9"
                                    :src="userImage(data)"
                                />
                            </div>
                            <span>
                                {{ data.full_name }}
                            </span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <p class="tiggie-p">{{ data.email }}</p>
                    </VCol>

                    <VCol cols="4">
                        <p color="tiggie-p">{{ data.contact_number }}</p>
                    </VCol>
                </VRow>
                <VRow justify="center" align="center">
                    <VPagination
                        v-model="serverPage"
                        size="small"
                        :total-visible="5"
                        :length="datas.last_page"
                        @next="onPageChange"
                        @prev="onPageChange"
                        @click="onPageChange"
                        variant="outlined"
                    />
                </VRow>
            </VCol>

            <VDivider />
        </VCard>
    </section>
</template>

<style scoped>
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
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
}

.chip-content {
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
.std-width-high {
    width: 60px !important;
    height: 60px !important;
}
</style>
