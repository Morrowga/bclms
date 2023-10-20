<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm, usePage } from "@inertiajs/vue3";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import LargeDropFile from "@mainRoot/components/LargeDropFile/LargeDropFile.vue";

const teacherForm = useForm({
    first_name: "",
    last_name: "",
    email: "",
    contact_number: "",
    image: "",
});
let flash = computed(() => usePage().props.flash);

const createTeacher = () => {
    // teacherForm.image = profileFile.value;
    teacherForm.post(route("organisations-teacher.store"), {
        onSuccess: () => {
            if (flash.value.errorMessage) {
                SuccessDialog({
                    title: flash.value.errorMessage,
                    mainTitle: "Error!",
                    color: "#ff6262",
                    icon: "error",
                });
            } else {
                SuccessDialog({
                    title: flash.value.successMessage,
                    color: "#17CAB6",
                });
            }
        },
        onError: (error) => {},
    });
    // SuccessDialog({
    //     title: "You have successfully create a teacher!",
    //     color: "#17CAB6",
    // });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm @submit.prevent="createTeacher">
                <VRow justify="center">
                    <VCol cols="6">
                        <LargeDropFile v-model="teacherForm.image" />
                    </VCol>
                    <VCol cols="6">
                        <VText class="teacherprofile-title">Profile</VText>
                        <div class="d-flex justify-space-between mt-10 pb-10">
                            <h1 class="tiggie-label fs-20">Personal Details</h1>
                        </div>
                        <VRow>
                            <VCol cols="6" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    First Name
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="teacherForm.first_name"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        teacherForm.errors?.first_name
                                    "
                                />
                            </VCol>
                            <VCol cols="6" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Last Name
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="teacherForm.last_name"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        teacherForm.errors?.last_name
                                    "
                                />
                            </VCol>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Work Email
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    placeholder=""
                                    v-model="teacherForm.email"
                                    :rules="[requiredValidator]"
                                    :error-messages="teacherForm.errors?.email"
                                />
                            </VCol>
                            <VCol cols="12" class="py-2">
                                <VLabel class="tiggie-small-label">
                                    Contact Number
                                    <span class="text-candy-red">*</span>
                                </VLabel>
                                <VTextField
                                    type="number"
                                    placeholder=""
                                    v-model="teacherForm.contact_number"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        teacherForm.errors?.contact_number
                                    "
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
                <VRow justify="center mt-15">
                    <VCol cols="2">
                        <Link
                            :href="route('organisations-teacher.index')"
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
            </VForm>
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

.blur-p {
    color: var(--Secondary2, rgba(86, 86, 96, 0.4));
    text-align: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px; /* 157.143% */
    text-transform: capitalize;
}

.profile-drag {
    align-items: center;
    text-align: center;
    width: 100%;
    background: #f7f7f7;
    height: 440px;
    border: 1px solid rgb(182, 182, 186, 0.6);
    border-radius: 10px;
    overflow: hidden;
}
.profileimg {
    object-fit: cover !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
    margin-bottom: 0;
}
</style>
