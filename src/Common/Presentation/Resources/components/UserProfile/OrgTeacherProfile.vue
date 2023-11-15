<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
let props = defineProps(["auth", "flash", "user_info"]);
const profileImage = ref(props.auth.data.image ?? null);
// console.log(props.auth.data);
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="6">
                    <VImg
                        :src="
                            profileImage == null || profileImage == ''
                                ? '/images/teacherimg.png'
                                : profileImage
                        "
                        class="profileAvatar"
                    />
                </VCol>
                <VCol cols="6">
                    <VText class="teacherprofile-title">Profile</VText>
                    <div class="d-flex justify-space-between mt-10">
                        <h1 class="tiggie-label fs-20">Personal Details</h1>
                        <VBtn variant="flat" rounded color="teal">
                            <Link
                                :href="route('edit-profiles.org-teacher')"
                                class="d-flex align-center"
                            >
                                <VIcon
                                    icon="mdi-pencil-outline"
                                    class="text-white mr-2"
                                ></VIcon>
                                <span class="text-white">Edit</span>
                            </Link>
                        </VBtn>
                    </div>
                    <VRow>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">FullName</h6>
                            <p class="tiggie-p">{{ props.auth.data.name }}</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Work Email</h6>
                            <p class="tiggie-p">{{ props.auth.data.email }}</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Contact Number</h6>
                            <p class="tiggie-p">
                                {{ props.auth.data.contact_number }}
                            </p>
                        </VCol>
                    </VRow>
                    <!-- contact user plan -->
                    <!-- <h1 class="teacherprofile-title">Subscription</h1>

                    <VRow>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Plan Name</h6>
                            <p class="tiggie-p">Base Plan</p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">
                                Subscription Period
                            </h6>
                            <p class="tiggie-p">
                                2 August 2023 - 2 September 2023
                            </p>
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Email Address</h6>
                            <p class="tiggie-p">francisco_maia@gmail.com</p>
                        </VCol>
                    </VRow> -->
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="2">
                    <Link href="/home" class="d-flex align-center">
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
