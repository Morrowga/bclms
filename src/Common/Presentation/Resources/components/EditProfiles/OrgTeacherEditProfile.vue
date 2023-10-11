<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage, useForm, Link } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

let props = defineProps(["auth", "flash", 'user_info']);
const profileImage = ref(props.auth.data.image ?? null);

const profileForm = useForm({
    image: null,
    first_name: props.user_info.user_detail.first_name,
    last_name: props.user_info.user_detail.last_name,
    email: props.user_info.user_detail.email,
    contact_number: props.user_info.user_detail.contact_number,
});


const handleUpdateProfile = (data) => {
    profileForm.post(route("update-profiles.org-teacher"), {
        onSuccess: (data) => {
            SuccessDialog({
                title: props.flash?.successMessage,
            });
        },
        onError: (error) => {
        }
    });
};

const uploadImage = () => {
    const fileInput = document.getElementById('profile-upload-input');
    fileInput.click();
}


const handleProfileFileChange = (event) => {
  const file = event.target.files[0];
  profileImage.value = URL.createObjectURL(file);
  profileForm.image = file
};

</script>
<template>
    <AdminLayout>
        <VForm @submit.prevent="handleUpdateProfile">
            <VContainer>
                <VRow justify="center">
                    <VCol cols="6">
                        <VImg class="profileAvatar" @click="uploadImage" size="130" :src="profileImage == null || profileImage == '' ? '/images/teacherimg.png' : profileImage" />
                        <input
                            id="profile-upload-input"
                            type="file"
                            style="display: none"
                            @change="handleProfileFileChange"
                            :error-messages="profileForm?.errors?.image"
                        />
                    </VCol>
                    <VCol cols="6">
                        <VText class="teacherprofile-title">Profile</VText>
                        <div class="d-flex justify-space-between mt-10 pb-10">
                            <h1 class="tiggie-label fs-20">Personal Details</h1>
                        </div>
                        <VRow>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    First Name
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="profileForm.first_name"
                                />
                            </VCol>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Last Name
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="profileForm.last_name"
                                />
                            </VCol>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Work Email
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="profileForm.email"
                                />
                            </VCol>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Contact Number
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="profileForm.contact_number"
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="2">
                        <Link
                            :href="route('profiles.org-teacher')"
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
                            type="submit"
                            color="primary"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-white">Save</span>
                        </VBtn>
                    </VCol>
                </VRow>
            </VContainer>
        </VForm>
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

:deep(.profileAvatar .v-img__img--contain) {
    object-fit: cover !important;
}

</style>
