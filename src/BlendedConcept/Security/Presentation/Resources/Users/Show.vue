<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
    isCustomization: false,
    isPresentation: false,
    isFullAccess: false,
    isConcurrentAccess: false,
    isWeeklyLearningReport: false,
    isDedicatedStudentReport: false,
});
const setInactive = () => {
    isConfirmedDialog({
        title: "Are you sure?",
        denyButtonText: "Set Inactive",
        onConfirm: () => {
            // alert("good to go");
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="12" md="4">
                    <VRow>
                        <VCol cols="12">
                            <h4
                                class="tiggie-show-title pr-10 margin-buttom-18"
                            >
                                User Particulars
                            </h4>
                        </VCol>
                        <VCol cols="12">
                            <img src="/images/defaults/avator.png" />
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label">Name</VLabel>
                            <p class="tiggie-p ml-4">Jordan Stevenson</p>
                        </VCol>
                        <VCol cols="12">
                            <VLabel class="tiggie-label">User Email</VLabel>
                            <p class="tiggie-p ml-4">
                                susanna.lind57@gmail.com
                            </p>
                        </VCol>
                        <VCol cols="12">
                            <VLabel class="tiggie-label"
                                >User Contact Number</VLabel
                            >
                            <p class="tiggie-p ml-4">95159746</p>
                        </VCol>
                        <VCol cols="12" style="visibility: hidden">
                            <Link
                                :href="route('organizations.show')"
                                style="cursor: pointer"
                            >
                                <VLabel class="tiggie-label"
                                    >Organisation Name</VLabel
                                >
                                <p class="tiggie-p ml-4 underline">
                                    Blended Concept
                                </p>
                            </Link>
                        </VCol>
                        <VCol cols="12">
                            <Link
                                :href="route('users.index')"
                                class="text-center"
                            >
                                <VBtn
                                    color="gray"
                                    text-color="white"
                                    height="50"
                                    class="finish-btn pl-5 pr-5"
                                >
                                    Back
                                </VBtn>
                            </Link>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="12" md="4">
                    <VRow>
                        <VCol cols="12">
                            <h4
                                class="tiggie-show-title pr-10 margin-buttom-18"
                                style="visibility: hidden"
                            >
                                User Particulars
                            </h4>
                        </VCol>
                        <VCol cols="12">
                            <img
                                src="/images/defaults/avator.png"
                                style="visibility: hidden"
                            />
                        </VCol>
                        <VCol cols="12">
                            <VLabel class="tiggie-label">User Role</VLabel>
                            <p class="tiggie-p ml-4">Organization Admin</p>
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label">Login Email</VLabel>
                            <p class="tiggie-p ml-4">
                                estelle.Bailey10@gmail.com
                            </p>
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label">Login Password</VLabel>
                            <p class="tiggie-p ml-4">*********</p>
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label"
                                >Current User Status</VLabel
                            >
                            <p class="tiggie-p text-teal ml-4">ACTIVE</p>
                        </VCol>
                        <VCol cols="12">
                            <VBtn
                                type="submit"
                                color="candy-red"
                                class="finish-btn pl-5 pr-5"
                                height="50"
                                @click="setInactive()"
                            >
                                Set Inactive
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol cols="12" md="4">
                    <VRow>
                        <VCol cols="12">
                            <h4
                                class="tiggie-show-title pr-10 margin-buttom-18"
                                style="visibility: hidden"
                            >
                                User Particulars
                            </h4>
                        </VCol>
                        <VCol cols="12">
                            <img
                                src="/images/defaults/avator.png"
                                style="visibility: hidden"
                            />
                        </VCol>
                        <VCol cols="12">
                            <VLabel class="tiggie-label"
                                >Current Subscription Plan</VLabel
                            >
                            <p class="tiggie-p ml-4">Basic Plan</p>
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label">Start Date</VLabel>
                            <p class="tiggie-p ml-4">01 August 2023</p>
                        </VCol>

                        <VCol cols="12">
                            <VLabel class="tiggie-label">End Date</VLabel>
                            <p class="tiggie-p ml-4">30 August 2023</p>
                        </VCol>
                    </VRow>
                </VCol>
                <!-- <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
                </VCol> -->
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.underline {
    text-decoration: underline;
}
</style>
