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
import { SuccessDialog } from "@actions/useSuccess";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { useForm } from "@inertiajs/vue3";

let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let props = defineProps([
    "resources",
    "requestPublishData",
    "auth"
]);

const isRequestUploadData = ref(false);
const checkedItems = ref([]);
let isDeleteMode = ref(false);
let isEditMode = ref(false);

let deleteMode = () => {
    isEditMode.value = true;
    isDeleteMode.value = true;
};

const activeEditMode = () => {
    isRequestUploadData.value = true;
    isEditMode.value = true;
};
const approve = () => {
    const actionForm = useForm({
        type: 'approve',
        ids: JSON.stringify(checkedItems.value)
    });
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,Approve it!",
        icon: "success",
        onConfirm: () => {
            actionForm.post(route("resource.approve"), {
                onSuccess: () => {
                    SuccessDialog({
                        title: "You have successfully approved resource to org!",
                        color: "#17CAB6",
                    });
                    reload("resource.index");
                    isEditMode.value = false;
                },
            });
        },
    });
};

const reject = () => {
    const actionForm = useForm({
        type: 'decline',
        ids: JSON.stringify(checkedItems.value)
    });
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,Decline it!",
        icon: "success",
        onConfirm: () => {
            actionForm.post(route("resource.decline"), {
                onSuccess: () => {
                    SuccessDialog({
                        title: "You have successfully declined resource to org!",
                        color: "#17CAB6",
                    });
                    reload("resource.index");

                    isEditMode.value = false;
                },
            });
        },
    });
};

const multiDelete = () => {
    const actionForm = useForm({
        type: 'delete',
        ids: JSON.stringify(checkedItems.value)
    });
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,Delete it!",
        icon: "success",
        onConfirm: () => {
            actionForm.post(route("resource.multipledelete"), {
                onSuccess: () => {
                    SuccessDialog({
                        title: "You have successfully deleted resource!",
                        color: "#17CAB6",
                    });
                    reload("resource.index");

                    isEditMode.value = false;
                },
            });
        },
    });
};

const reload = (routeName, param) => {
    if (param != null) {
        return new Promise((resolve) => {
            router.get(route(routeName, param), {
                onSuccess: () => {
                    resolve();
                },
            });
        });
    } else {
        return new Promise((resolve) => {
            router.get(route(routeName), {
                onSuccess: () => {
                    resolve();
                },
            });
        });
    }
};

const backToPage = () => {
    isEditMode.value = false;
    isDeleteMode.value = false;
    isRequestUploadData.value = false;
}

const checkIsOrg = () => {
    return user_role.value == "Organisation Admin" ? true : false;
};

const handleCheckboxChange = (data) => {
    if (data.checked) {
        console.log('true');
    // Checkbox is checked, add data to the array
        checkedItems.value.push(data.id);
    } else {
        console.log('false');
        // Checkbox is unchecked, remove data from the array
        const index = checkedItems.value.indexOf(data.id);
        if (index !== -1) {
            checkedItems.value.splice(index, 1);
        }
    }
}
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
                            <v-chip class="ml-2">Organisation</v-chip>
                            <v-chip class="ml-2">Me</v-chip>
                        </div>
                    </div>
                    <div>
                        <div class="mt-5">
                            <div v-if="isEditMode">
                                <div v-if="isDeleteMode">
                                    <v-btn
                                        prepend-icon="mdi-trash-can-outline"
                                        @click="multiDelete()"
                                        color="#ff6262"
                                        varient="flat"
                                        class="ml-2 resourcebtn"
                                        rounded=""
                                        >Delete</v-btn
                                    >
                                    <v-btn
                                        @click="backToPage()"
                                        color="secondary"
                                        varient="flat"
                                        class="ml-2 resourcebtn"
                                        rounded=""
                                        >Cancel</v-btn
                                    >
                                </div>
                                <div v-else>
                                    <v-btn
                                        @click="approve()"
                                        color="primary"
                                        varient="flat"
                                        class="ml-2 resourcebtn"
                                        rounded=""
                                        >Approve</v-btn
                                    >
                                    <v-btn
                                        prepend-icon="mdi-trash-can-outline"
                                        @click="reject()"
                                        color="#ff6262"
                                        varient="flat"
                                        class="ml-2 resourcebtn"
                                        rounded=""
                                        >Reject</v-btn
                                    >
                                    <v-btn
                                        @click="backToPage()"
                                        color="secondary"
                                        varient="flat"
                                        class="ml-2 resourcebtn"
                                        rounded=""
                                        >Cancel</v-btn
                                    >
                                </div>
                            </div>
                            <div v-else class="d-flex justify-end">
                                <v-btn
                                    v-if="checkIsOrg()"
                                    varient="flat"
                                    class="mr-2 text-white"
                                    color="#FF8015"
                                    rounded
                                    @click="activeEditMode()"
                                    >Requested Upload</v-btn
                                >
                                <CreateModal />
                                <v-btn
                                    prepend-icon="mdi-trash-can-outline"
                                    @click="deleteMode()"
                                    color="#ff6262"
                                    varient="flat"
                                    class="ml-2 resourcebtn"
                                    rounded=""
                                    >Delete</v-btn
                                >
                            </div>
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
                                    <SelectBox
                                        label="Sort By"
                                        density="compact"
                                    />
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
                <div class="mt-10" v-if="!isRequestUploadData">
                    <VRow>
                        <VCol
                            cols="12"
                            v-for="item in props.resources"
                            sm="6"
                            md="4"
                            lg="3"
                            :key="item"
                        >
                            <ResourceCard
                                :data="item"
                                @checkboxChange="handleCheckboxChange"
                                :key="item"
                                type="orgData"
                                :currentUser="props.auth"
                                :isEditMode="isEditMode"
                            />
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-10" v-if="isRequestUploadData">
                    <VRow>
                        <VCol
                            cols="12"
                            v-for="item in props.requestPublishData"
                            sm="6"
                            md="4"
                            lg="3"
                            :key="item"
                        >
                            <ResourceCard
                                @checkboxChange="handleCheckboxChange"
                                :data="item"
                                type="requestUploads"
                                :key="item"
                                :currentUser="props.auth"
                                :isEditMode="isEditMode"
                            />
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

.resourcebtn {
    color: #fff;
}

.menuchip {
    background: #4066e4 !important;
    color: #fff;
}

.resource {
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
