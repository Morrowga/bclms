<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import { toastAlert } from "@Composables/useToastAlert";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

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

const isDialogVisible = ref(false);
const isBordered = ref(null);

const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            image: "",
            student_id: "",
            storybooks: "",
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

const versions = ref(null);
const selectedStorybook = ref(null);

async function clickStoryBook(id) {
    const book_versions = datas.value[id].book_versions;
    selectedStorybook.value = datas.value[id];
    versions.value = book_versions;
    isDialogVisible.value = true;
}

const selectionChanged = (data) => {
    console.log(data.selectedRows);
};

const selectVersion = (id) => {
    isBordered.value = id;
    props.form.storybooks = id;
};
</script>
<template>
    <section>
        <VCard>
            <VDivider />
            <VCol cols="12">
                <VRow>
                    <VCol
                        cols="3"
                        v-for="(item, index) in datas"
                        :key="index"
                        class="pa-1"
                    >
                        <VCard @click="clickStoryBook(index)">
                            <VImg
                                :src="
                                    item.thumbnail_img == '' ||
                                    item.thumbnail_img == null
                                        ? '/images/2.jpg'
                                        : item.thumbnail_img
                                "
                                height="282px"
                                cover
                            />
                            <!-- <div class="select-box">
                                    <VRadio
                                        color="secondary"
                                        class="checkbox-position"
                                        v-model="props.form.storybooks"
                                        :value="item.id"
                                        @click="extractStorybookId(item.id)"
                                    />
                                </div> -->
                            <VCardItem>
                                <VCardTitle
                                    class="text-center tiggie-teacher-p tiggie-black-color fw-700"
                                >
                                    {{ item.name }}
                                </VCardTitle>
                                <ChipWithBlueDot
                                    v-for="item in item.disability_types"
                                    :key="item.id"
                                    :title="item.name"
                                />
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
        <VDialog v-model="isDialogVisible" width="100%">
            <VCard>
                <VCardText v-if="versions.length > 0">
                    <VRow>
                        <VCol
                            cols="3"
                            v-for="version in versions"
                            :key="version.id"
                        >
                            <VCard
                                :class="
                                    isBordered === version.id
                                        ? 'blue-border'
                                        : ''
                                "
                                @click="selectVersion(version.id)"
                            >
                                <VCardText>
                                    <VImg
                                        :src="
                                            selectedStorybook.thumbnail_img ==
                                                '' ||
                                            selectedStorybook.thumbnail_img ==
                                                null
                                                ? '/images/2.jpg'
                                                : selectedStorybook.thumbnail_img
                                        "
                                        height="282px"
                                        cover
                                    />
                                    <!-- <VImg
                                    :src="'/images/2.jpg'"
                                    height="282px"
                                    cover
                                /> -->
                                    <div class="text-center mt-4">
                                        <span class="pppangram-bold">{{
                                            version.name
                                        }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span>{{ version.description }}</span>
                                    </div>
                                </VCardText>
                            </VCard>
                        </VCol>
                    </VRow>
                </VCardText>
                <VCardText v-else>
                    <h1 class="text-center">No StoryBook Version</h1>
                </VCardText>

                <div>
                    <div class="d-flex justify-center mt-5 mb-5">
                        <PrimaryBtn
                            :block="true"
                            @click="isDialogVisible = false"
                            :isLink="false"
                            type="button"
                            title="Confirm"
                        />
                    </div>
                </div>
            </VCard>
        </VDialog>
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

.blue-border {
    border: 3px solid #4066e4;
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
