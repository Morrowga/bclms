<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { router } from "@inertiajs/core";
let flash = computed(() => usePage().props.flash);
const props = defineProps({
    organization: {
        type: Object,
        required: true,
    },
});
const deleteOrganization = () => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(
                route("organizations.destroy", props.organization.id),
                {
                    onSuccess: () => {
                        SuccessDialog({ title: flash?.successMessage });
                    },
                }
            );
        },
    });
};
const setImage = (organization) => {
    return (
        organization?.image?.[0]?.original_url ??
        "/images/defaults/organization_logo.png"
    );
};

const fullName = (organization) => {
    return (
        (organization.org_admin?.first_name ?? "") +
        " " +
        (organization.org_admin?.last_name ?? "")
    );
};
const maxTeacher = (organization) => {
    return (
        organization?.subscription?.b2b_subscription?.num_teacher_license ?? 0
    );
};
const maxStudent = (organization) => {
    return (
        organization?.subscription?.b2b_subscription?.num_student_license ?? 0
    );
};
const maxStorage = (organization) => {
    return (
        organization?.subscription?.b2b_subscription?.storage_limit * 1000 ?? 0
    );
};
const getPrice = (organization) => {
    return organization?.subscription?.stripe_price * 1000 ?? 0;
};
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
                                {{ props.organization.name }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Name</h4>
                            <p class="tiggie-p">
                                {{ props.organization.contact_name }}
                            </p></VCol
                        >

                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Email</h4>
                            <p class="tiggie-p">
                                {{ props.organization.contact_email }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Contact Number</h4>
                            <p class="tiggie-p">
                                {{ props.organization.contact_number }}
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
                                :src="setImage(props.organization)"
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
                                props.Organization Admin Name
                            </h4>
                            <p class="tiggie-p">
                                {{ fullName(props.organization) }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">
                                Organisation Admin Contact Number
                            </h4>
                            <p class="tiggie-p">
                                {{
                                    props.organization?.org_admin
                                        ?.contact_number
                                }}
                            </p>
                        </VCol>
                        <VCol cols="10">
                            <h4 class="tiggie-label pb-3">Login Email</h4>
                            <p class="tiggie-p">
                                {{ props.organization?.org_admin?.email }}
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
                                                props.organization
                                                    ?.teachers_count
                                            }}
                                        </span>
                                        <span
                                            >/
                                            {{
                                                maxTeacher(props.organization)
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
                                            321 MB
                                        </span>
                                        <span
                                            >/
                                            {{
                                                maxStorage($props.organization)
                                            }}
                                            GB</span
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
                                                props.organization
                                                    ?.students_count
                                            }}
                                        </span>
                                        <span
                                            >/{{
                                                maxStudent(props.organization)
                                            }}</span
                                        >
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <h1 class="tiggie-label pb-3">Price</h1>
                                    <p class="ml-2">
                                        <span>{{
                                            getPrice(props.organization)
                                        }}</span>
                                    </p>
                                </VCol>
                                <VCol cols="6">
                                    <VBtn class="text-white" color="#565660">
                                        Import Users
                                    </VBtn>
                                </VCol>
                            </VRow>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4">
                    <Link
                        :href="route('organizations.index')"
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
                        @click="deleteOrganization"
                        class="text-white pl-16 pr-16"
                        color="candy-red"
                        width="250"
                        >Delete</VBtn
                    >
                </VCol>
                <VCol cols="4">
                    <Link
                        :href="route('organizations.edit', 1)"
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
