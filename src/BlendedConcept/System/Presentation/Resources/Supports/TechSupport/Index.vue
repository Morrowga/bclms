<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import Swal from "sweetalert2";
import avatar4 from "@images/avatars/avatar-4.png";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { isConfirmedDialog } from "@actions/useConfirm";
import AnswerSupport from "./components/Index.vue"

</script>
<template>
    <AdminLayout>
        <VContainer style="width: 80%; margin: 0 auto">
            <VRow justify="space-around">
                <VCol cols="6">
                    <h1 class="tiggie-teacher-title">Technical Support  </h1>
                </VCol>
                <VCol cols="6" class="text-end">
                    <AnswerSupport/>
                </VCol>
                <VCol cols="12">
                    <VTextField
                        placeholder="Search ..."
                        append-inner-icon=""
                        density="compact"
                        rounded
                    >
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
                                </VLabel
                            >
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="3">
                            <VLabel class="tiggie-label">
                                Status
                            </VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow
                        class="bg-line mx-1 rounded pa-1 my-2"
                        align="center">

                        <VCol cols="3">
                            <span>
                                The computer is saying ‘press any key’ but i’m struggling to find it
                            </span>
                        </VCol>
                        <VCol cols="3">
                            <span class="">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna al
                            </span>
                        </VCol>
                        <VCol cols="3">
                            <p class="tiggie-p">10/1/2023</p>
                        </VCol>

                        <VCol cols="3">
                           <VChip color="success">Active</VChip>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination
                            v-model="currentPage"
                            variant="outlined"
                            :length="5"
                        />
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
border: 1px solid  #E5E5E5 !important;
background: #F6F6F6 !important;

}
</style>
