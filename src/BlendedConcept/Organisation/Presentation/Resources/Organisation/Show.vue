<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { router } from "@inertiajs/core";
import ImportUser from "./components/ImportUser.vue";
import { checkPermission } from "@actions/useCheckPermission";

let flash = computed(() => usePage().props.flash);
const props = defineProps({
    organisation: {
        type: Object,
        required: true,
    },
    used_storage: {
        default: 0,
    },
});
const deleteOrganisation = () => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(
                route("organisations.destroy", props.organisation.id),
                {
                    onSuccess: () => {
                        SuccessDialog({ title: flash?.successMessage });
                    },
                }
            );
        },
    });
};
const setImage = (organisation) => {
    return (
        organisation?.image?.[0]?.original_url ??
        "/images/defaults/organisation_logo.png"
    );
};

const fullName = (organisation) => {
    return (
        (organisation.org_admin?.first_name ?? "") +
        " " +
        (organisation.org_admin?.last_name ?? "")
    );
};
const maxTeacher = (organisation) => {
    return (
        organisation?.subscription?.b2b_subscription?.num_teacher_license ?? 0
    );
};
const maxStudent = (organisation) => {
    return (
        organisation?.subscription?.b2b_subscription?.num_student_license ?? 0
    );
};
const maxStorage = (organisation) => {
    return organisation?.subscription?.b2b_subscription?.storage_limit ?? 0;
};
const getPrice = (organisation) => {
    return organisation?.subscription
        ? organisation?.subscription?.stripe_price
        : 0;
};

onMounted(() => {
    // console.log(props.organisation);
});
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around" :gutter="5">
                <VCol cols="6">
                    <VRow justify="center" noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">
                                Organisation Particulars
                            </h1>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Organisation Name</h4>
                            <p class="tiggie-p">
                                {{ props.organisation.name }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Name</h4>
                            <p class="tiggie-p">
                                {{ props.organisation.contact_name }}
                            </p></VCol
                        >

                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Email</h4>
                            <p class="tiggie-p">
                                {{ props.organisation.contact_email }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Number</h4>
                            <p class="tiggie-p">
                                {{ props.organisation.contact_number }}
                            </p>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6">
                    <VRow>
                        <VCol cols="10">
                            <h1 class="tiggie-title">Logo</h1>
                        </VCol>
                        <VCol cols="10">
                            <VImg
                                :src="setImage(props.organisation)"
                                width="234px"
                                height="256px"
                            />
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="space-around" :gutter="5">
                <VCol cols="6">
                    <VRow justify="center" noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">
                                Organisation Admin
                            </h1>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">
                                Organisation Admin Name
                            </h4>
                            <p class="tiggie-p">
                                {{
                                    props.organisation.org_admin.user?.full_name
                                }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">
                                Organisation Admin Contact Number
                            </h4>
                            <p class="tiggie-p">
                                {{
                                    props.organisation?.org_admin?.user
                                        ?.contact_number
                                }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Login Email</h4>
                            <p class="tiggie-p">
                                {{ props.organisation?.org_admin?.user?.email }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Password</h4>
                            <p class="tiggie-p">*********</p>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="6">
                    <VRow noGutters>
                        <VCol cols="10">
                            <h1 class="tiggie-title pb-3">Organisation Plan</h1>
                        </VCol>
                        <VCol cols="10">
                            <VRow>
                                <VCol cols="6">
                                    <h1 class="tiggie-label pb-3">
                                        No of Teachers
                                    </h1>
                                    <p class="ml-2">
                                        <span class="text-warning">
                                            {{
                                                props.organisation
                                                    ?.teachers_count
                                            }}
                                        </span>
                                        <span
                                            >/
                                            {{
                                                maxTeacher(props.organisation)
                                            }}</span
                                        >
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <h1 class="tiggie-label pb-3">
                                        Storage Size
                                    </h1>
                                    <p class="ml-2">
                                        <span class="text-success">
                                            {{ props.used_storage }} MB
                                        </span>
                                        <span
                                            >/
                                            {{
                                                maxStorage($props.organisation)
                                            }}
                                            MB</span
                                        >
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <h1 class="tiggie-label pb-3">
                                        No of Students
                                    </h1>
                                    <p class="ml-2">
                                        <span class="text-warning">
                                            {{
                                                props.organisation
                                                    ?.students_count
                                            }}
                                        </span>
                                        <span
                                            >/{{
                                                maxStudent(props.organisation)
                                            }}</span
                                        >
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <h1 class="tiggie-label pb-3">Price</h1>
                                    <p class="ml-2">
                                        <span>{{
                                            getPrice(props.organisation)
                                        }}</span>
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <ImportUser
                                        :organisation="props.organisation"
                                    />
                                </VCol>
                            </VRow>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4">
                    <Link
                        :href="route('organisations.index')"
                        class="text-dark"
                    >
                        <VBtn
                            class="text-dark pl-16 pr-16"
                            color="gray"
                            width="250"
                        >
                            Back
                        </VBtn>
                    </Link>
                </VCol>
                <VCol cols="4">
                    <VBtn
                        v-if="checkPermission('edit_organisation')"
                        @click="deleteOrganisation"
                        class="text-white pl-16 pr-16"
                        color="candy-red"
                        width="250"
                        >Delete</VBtn
                    >
                </VCol>
                <VCol cols="4">
                    <Link
                        v-if="checkPermission('edit_organisation')"
                        :href="route('organisations.edit', 1)"
                        class="text-white"
                    >
                        <VBtn
                            class="text-white pl-16 pr-16"
                            color="primary"
                            width="250"
                        >
                            Edit
                        </VBtn>
                    </Link>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
