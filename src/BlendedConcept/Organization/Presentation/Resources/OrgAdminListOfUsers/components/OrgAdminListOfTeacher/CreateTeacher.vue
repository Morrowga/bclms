<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

const studentEditInfo = ref({
    name: "",
    email: "",
    contact_number: "",
});
const createTeacher = () => {
    SuccessDialog({
        title: "You have successfully create a teacher!",
        color: "#17CAB6",
    });
};
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
                    <div class="d-flex justify-space-between mt-10 pb-10">
                        <h1
                            class="tiggie-label"
                            style="font-size: 20px !important"
                        >
                            Personal Details
                        </h1>
                    </div>
                    <VRow>
                        <VCol cols="12" class="py-2">
                            <VLabel class="tiggie-small-label">
                                FullName
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="studentEditInfo.name"
                            />
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <VLabel class="tiggie-small-label">
                                Work Email
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="studentEditInfo.email"
                            />
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <VLabel class="tiggie-small-label">
                                Contact Number
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="studentEditInfo.contact_number"
                            />
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="2">
                    <Link
                        :href="route('org_view_teacher_student.index')"
                        class="text-black"
                    >
                        <VBtn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-primary">Cancel</span>
                        </VBtn>
                    </Link>
                </VCol>
                <VCol cols="2">
                    <VBtn
                        color="primary"
                        variant="flat"
                        rounded
                        height="50"
                        class="pl-16 pr-16"
                        @click="createTeacher()"
                    >
                        <span class="text-white">Save</span>
                    </VBtn>
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
