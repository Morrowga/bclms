<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { ref, defineProps } from "vue";
import AnswerSupport from "./components/Index.vue"
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";

let options = ref({
    enabled: true,
    mode: "pages",
    perPage: props.technicalSupportList?.meta?.per_page,
    setCurrentPage: props?.technicalSupportList?.meta?.current_page,
    perPageDropdown: [10, 20, 50, 100],
    dropdownAllowAll: false,
});

serverPage.value = ref(props.technicalSupportList.meta.current_page ?? 1);
serverPerPage.value = ref(10);


watch(serverPerPage, function (value) {
    onPerPageChange(value);
});

const props = defineProps(['technicalSupportList']);


</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <VRow justify="space-around">
                <VCol cols="6">
                    <h1 class="tiggie-teacher-title">Technical Support </h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <AnswerSupport />
                </VCol>
                <VCol cols="12">
                    <VTextField placeholder="Search ..." append-inner-icon="" density="compact" rounded
                        @keyup.enter="searchItems" v-model="serverParams.search">
                        <template #append-inner>
                            <VIcon icon="mdi-magnify" size="30" />
                        </template>
                    </VTextField>
                </VCol>
                <VCol cols="12">
                    <VRow class="bg-line mx-1 rounded pa-1 mb-5" align="center">
                        <VCol cols="3" class="">
                            <VLabel class="tiggie-label">
                                Request
                            </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Answer
                            </VLabel>
                        </VCol>
                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Date
                            </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Status
                            </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow class="bg-line mx-1 rounded pa-1 my-2"
                        v-for="(technicalSupportIndex, index) in props.technicalSupportList.data"
                        :key="technicalSupportIndex.id" align="center">

                        <VCol cols="3">
                            <span>
                                {{ technicalSupportIndex.question }}
                            </span>
                        </VCol>
                        <VCol cols="3">
                            <span>
                                {{
                                    technicalSupportIndex.response ?? "-"
                                }}
                            </span>

                        </VCol>
                        <VCol cols="3">
                            <p class="tiggie-p">
                                {{ technicalSupportIndex.date }}
                            </p>
                        </VCol>

                        <VCol cols="3">
                            <VChip color="success">Active</VChip>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination
                        v-model="serverPage"
                        size="small"
                        :total-visible="5"
                        :length="props.technicalSupportList.meta.last_page"
                        @next="onPageChange"
                        @prev="onPageChange"
                        @click="onPageChange" variant="outlined" />
                    </VRow>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style lang="scss" scoped>
:deep(.input-awine .v-text-field input) {
    border-radius: 100px !important;
    border: 1px solid #BFC0C1 !important;
    padding: 8px 16px 8px 20px !important;
    background: #F4F4F4 !important;
    border: 1px solid #E5E5E5 !important;
}

.table-header-tech-support {
    height: 46px !important;
    border-radius: 14px !important;
    border: 1px solid #E5E5E5 !important;
    background: #F6F6F6 !important;

}
</style>
