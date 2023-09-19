<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { computed } from "vue";
import { usePage, useForm, Link } from "@inertiajs/vue3";
import { toastAlert } from "@Composables/useToastAlert";
import { SuccessDialog } from "@actions/useSuccess";
import ChangePasswordDialog from "./components/ChangePasswordDialog.vue";
import ProfileEditDialog from "./components/ProfileEditDialog.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

//## start variable section
let props = defineProps(["auth", "flash", 'user_info']);
const page = usePage();

const flash = "Password Updated Successfully";

const isUserPasswordChange = ref(false);
const isUserProfileEdit = ref(false);
let passwordForm = useForm({
    currentpassword: "",
    updatedpassword: "",
    password_confirmation: "",
});

const profileForm = useForm({
    first_name: props.user_info.user_detail.first_name,
    last_name: props.user_info.user_detail.last_name,
    email: props.user_info.user_detail.email,
    contact_number: props.user_info.user_detail.contact_number,
});

const handleChangePassword = (data) => {
    passwordForm.post(route("userprofile.changepassword"), {
        onSuccess: (data) => {
            isUserPasswordChange.value = false;
            SuccessDialog({
                title: props.flash?.successMessage,
            });
            passwordForm.reset();
        },
        onError: (error) => {
            isUserPasswordChange.value = true;
        },
    });
};

const handleUpdateProfile = (data) => {
    profileForm.post(route("userprofile.update"), {
        onSuccess: (data) => {
            isUserProfileEdit.value = false;
            SuccessDialog({
                title: props.flash?.successMessage,
            });
        },
        onError: (error) => {
            isUserProfileEdit.value = true;
        }
    });
};
</script>

<template>
    <AdminLayout>
        <VContainer class="m-padding">
            <VRow>
                <VCol cols="6">
                    <span class="tiggie-title">Profile</span>
                </VCol>
                <VCol cols="6"></VCol>
                <VCol cols="6">
                    <img src="/images/defaults/avator.png" />
                </VCol>
            </VRow>
            <VRow justify="center" align-content="right">
                <VCol cols="6" class="">
                    <span class="tiggie-label">Name</span>
                    <p class="tiggie-p">{{ auth.data.name }}</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Role</span>
                    <p class="tiggie-p">{{ user_info.user_role.name }}</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Email</span>
                    <p class="tiggie-p">{{ auth.data.email }}</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">Login Email</span>
                    <p class="tiggie-p">{{ auth.data.email }}</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Contact Number</span>
                    <p class="tiggie-p">{{ user_info.user_detail.contact_number }}</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">Login Password</span>
                    <p class="tiggie-p">*********</p>
                </VCol>
            </VRow>
            <VRow no-gutters>
                <VCol cols="6" class="">
                    <VBtn
                        color="secondary"
                        text-color="white"
                        variant="tonal"
                        class="pl-16 pr-16"
                        @click="isUserProfileEdit = true"
                        height="50"
                    >
                        <span class="text-dark">Edit Profile</span>
                    </VBtn>
                </VCol>
                <VCol cols="6">
                    <VBtn
                        color="secondary"
                        variant="tonal"
                        height="50"
                        class="pl-16 pr-16"
                        @click="isUserPasswordChange = true"
                    >
                        <span class="text-dark">Change Password</span>
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>

    <!-- 👉 Edit user info dialog -->
    <ChangePasswordDialog
        v-model:isDialogVisible="isUserPasswordChange"
        :form="passwordForm"
        @submit="handleChangePassword"
    />

    <ProfileEditDialog
        v-model:isDialogVisible="isUserProfileEdit"
        :form="profileForm"
        @submit="handleUpdateProfile"
    />
</template>

<style scopted>
.card-list {
    --v-card-list-gap: 0.8rem;
}

.current-plan {
    border: 2px solid rgb(var(--v-theme-primary));
}

.text-capitalize {
    text-transform: capitalize !important;
}

.m-padding {
    padding: 0 60px;
}
</style>
