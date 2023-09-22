<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";

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
} from "./useStorybooksDatatable.js";

const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            image: "",
            student_id: "",
            storybooks: [],
        },
    },
});
routeName.value = "playlists.getStorybooks";
let storybooks = ref([]);
//## start datatable section
let rows = ref([]);

serverPage.value = ref(datas.value?.current_page ?? 1);
serverPerPage.value = ref(10);

watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};
</script>
<template>
    <section>
        <VCard>
            <VDivider />
            <VCol cols="12">
                <VRow>
                    <VCol cols="3" v-for="item in datas" :key="item" class="pa-1">
                            <VCard>
                                <VImg
                                    :src="item.thumbnail_img == '' || item.thumbnail_img == null  ? '/images/2.jpg' : item.thumbnail_img"
                                    height="282px"
                                    cover
                                />
                                <div class="select-box">
                                    <VCheckbox
                                        color="secondary"
                                        class="checkbox-position"
                                        v-model="props.form.storybooks"
                                        :value="item.id"
                                    />
                                </div>
                                <VCardItem>
                                    <VCardTitle
                                        class="text-center tiggie-teacher-p tiggie-black-color fw-700"
                                        >
                                        {{ item.name }}
                                    </VCardTitle>
                                    <ChipWithBlueDot v-for="item in item.disability_types" :key="item.id" :title="item.name" />
                                </VCardItem>
                                <VCardActions>
                                    <div class="d-flex gap-1">
                                        <GreenChip title="Switch" />
                                        <GreenChip title="Eye-Gaze" />
                                        <GreenChip title="Touch" />
                                    </div>
                                </VCardActions>
                            </VCard>
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
