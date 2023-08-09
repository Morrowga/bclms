<script setup>
import { avatarText, kFormatter } from "@core/utils/formatters";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { computed } from "vue";
import { usePage, useForm, Link } from "@inertiajs/vue3";
import { toastAlert,successAlert } from "@Composables/useToastAlert";
import ChangePasswordDialog from "./Profiles/ChangePasswordDialog.vue";
import ProfileEditDialog from "./Profiles/ProfileEditDialog.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

const page = usePage();
const user = computed(() => page.props.user_info);

const flash = "Password Updated Successfully";

const isUserPasswordChange = ref(false);
const isUserProfileEdit = ref(false);
let form = useForm({
    currentpassword: "",
    updatedpassword: "",
});

let profileEdit = useForm({
    name: "superadmin",
    email: "superadmin@mail.com",
    contact_number: "+959951613400"
});


const hanleSubmit = (data) => {
    isUserPasswordChange.value = false;
    isUserProfileEdit.value = false;
     successAlert({
                title: flash,
            });
    // form.currentpassword = data.currentpassword;
    // form.updatedpassword = data.updatedpassword;

    // form.post(route("changepassword"), {
    //     onSuccess: (data) => {
    //         toastAlert({
    //             title: flash,
    //         });
    //         isUserPasswordChange.value = false;
    //         console.log(flash.value);
    //     },
    //     onError: (error) => {
    //         isUserPasswordChange.value = true;
    //     },
    // });
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
            <VRow justify="center">
                <VCol cols="6" class="">
                    <span class="tiggie-label">Name</span>
                    <p class="tiggie-p">Super Admin</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Role</span>
                    <p class="tiggie-p">Super Admin</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Email</span>
                    <p class="tiggie-p">superadmin@mail.com</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label ">Login Email</span>
                    <p class="tiggie-p">superadmin@mail.com</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">User Contact Number</span>
                    <p class="tiggie-p">95159746</p>
                </VCol>
                <VCol cols="6">
                    <span class="tiggie-label">Login Password</span>
                    <p class="tiggie-p">*********</p>
                </VCol>
            </VRow>
            <VRow no-gutters>
                <VCol cols="4" class="text-center">
                    <VBtn color="secondary" text-color="white" variant="tonal" class="pl-16 pr-16"
                        @click="isUserProfileEdit = true">
                        Edit Profile
                    </VBtn>
                </VCol>
                <VCol cols="4">
                    <VBtn color="secondary" variant="tonal" class="pl-16 pr-16 text-dark"
                        @click="isUserPasswordChange = true">
                        Change Password
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>

    <!-- 👉 Edit user info dialog -->
    <ChangePasswordDialog v-model:isDialogVisible="isUserPasswordChange" :user-data="user" :form="form"
        @submit="hanleSubmit" />

    <ProfileEditDialog v-model:isDialogVisible="isUserProfileEdit" :user-data="user" :form="profileEdit"
        @submit="hanleSubmit" />
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

.m-padding{
    padding: 0 60px;
}
</style>
