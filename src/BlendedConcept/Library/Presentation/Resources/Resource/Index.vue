<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import deleteItem from "@Composables/useDeleteItem.js";
import ResourceCard from "@mainRoot/components/Resource/ResourceCard.vue";
import CreateModal from "@mainRoot/components/Resource/CreateModal.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import { isConfirmedDialog } from "@actions/useConfirm";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

let props = defineProps([
    "classrooms",
    "students",
    "teachers",
    "flash",
    "auth",
]);
let onFormSubmit = () => {
    isConfirmedDialog({ title: "Are you sure want to delete it." });
};
</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
              <div class="d-flex justify-space-between">
                <div>
                    <span class="ruddy-bold resource">Resources</span>
                    <div class="mt-5">
                        <v-chip class="menuchip">All</v-chip>
                        <v-chip class="ml-2">Organization</v-chip>
                        <v-chip class="ml-2">Me</v-chip>
                    </div>
               </div>
               <div>
                <div class="mt-5">
                    <v-btn varient="flat" class="mr-2 text-white" color="#FF8015" rounded>Requested Upload</v-btn>
                    <CreateModal />
                    <v-btn prepend-icon="mdi-trash-can-outline" @click="onFormSubmit" color="#ff6262" varient="flat" class="ml-2 resourcebtn" rounded="">Delete</v-btn>
                </div>
               </div>
              </div>
              <div class="d-flex justify-space-between mt-5">
                  <VRow>
                    <VCol cols="6"></VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="6">
                                <VTextField
                                        rounded
                                        placeholder="Search User ..."
                                        density="compact"
                                    />
                            </VCol>
                            <VCol cols="6">
                                <SelectBox label="Sort By" density="compact" />
                            </VCol>
                        </VRow>
                    </VCol>
                  </VRow>
              </div>
              <div class="d-flex justify-space-between mt-5">
                  <VRow>
                    <VCol cols="6"></VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="6"></VCol>
                            <VCol cols="6">
                                <div>
                                    <span>55.4 MB of 80MB used </span>
                                        <VProgressLinear
                                            color="yellow-darken-2"
                                            model-value="80"
                                            :height="8"
                                        ></VProgressLinear>
                                </div>
                            </VCol>
                        </VRow>
                    </VCol>
                  </VRow>
              </div>
              <div class="mt-10">
                <VRow>
                    <VCol cols="12"  v-for="item in 16"
                    sm="6"
                    md="4"
                    lg="3"
                        :key="item">
                        <ResourceCard :key="item" />
                    </VCol>
                </VRow>
              </div>
              <div class="d-flex justify-center mt-10">
                <Pagination />
              </div>
            </VContainer>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.resourcebtn{
    color: #fff;
}

.menuchip{
    background: #4066E4 !important;
    color: #fff;
}

.resource{
    color: #000 !important;
    font-size: 30px !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
