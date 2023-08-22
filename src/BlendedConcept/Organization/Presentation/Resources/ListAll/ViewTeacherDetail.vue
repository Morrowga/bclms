<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="6">
                    <VImg src="/images/teacherimg.png" />
                </VCol>
                <VCol cols="6">
                    <VText class="teacherprofile-title">Profile</VText>
                    <div class="d-flex justify-space-between mt-10">
                        <h1
                            class="tiggie-label"
                            style="font-size: 20px !important"
                        >
                            Personal Details
                        </h1>
                        <div class="d-flex align-center" style="gap: 10px">
                            <VBtn variant="flat" rounded color="teal">
                                <Link
                                    :href="
                                        route(
                                            'org_view_teacher_student.teacher.edit'
                                        )
                                    "
                                >
                                    <VIcon
                                        icon="mdi-pencil-outline"
                                        class="text-white mr-2"
                                    ></VIcon>
                                    <span class="text-white">Edit</span>
                                </Link>
                            </VBtn>
                            <VBtn variant="flat" rounded color="error">
                                <VIcon
                                    icon="mdi-trash-outline"
                                    class="text-white mr-2"
                                ></VIcon>
                                <span class="text-white">Delete</span>
                            </VBtn>
                        </div>
                    </div>
                    <VRow>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">FullName</h6>
                            <p class="tiggie-p">Tyler Covington</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Work Email</h6>
                            <p class="tiggie-p">tyler.covington@work.sg</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Contact Number</h6>
                            <p class="tiggie-p">9123 4567</p>
                        </VCol>
                    </VRow>
                    <!-- contact user plan -->
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="2">
                    <Link :href="route('org_view_teacher_student.index')">
                        <VBtn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-primary">Back</span>
                        </VBtn>
                    </Link>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.teacherprofile-title {
    color: var(--text, #161616);
    /* H3 Ruddy */
    font-family: Ruddy;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    text-transform: capitalize !important;
}
</style>
