<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import {
    emailValidator,
    requiredValidator,
    contactNumberValidator,
} from "@validators";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

const isFormValid = ref(false);
let refForm = ref();
const isDialogVisible = ref(false);

let flash = computed(() => usePage().props.flash);
let isPasswordVisible = ref(false);
let form = useForm({
    name: "",
    contact_name: "",
    contact_email: "",
    contact_number: "",
    org_admin_name: "",
    org_admin_contact_number: "",
    login_email: "",
    login_password: "",
    start_date: "",
    end_date: "",
    payment_date: "",
    payment_status: "UNPAID",
    stripe_status: "",
    stripe_price: 0,
    image: "",
});

// submit create form
let handleSubmit = () => {
    // SuccessDialog({ title: "You've successfully created organisation" });

    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("organisations.store"), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
                onError: (error) => {},
            });
        }
    });
};

watch(form, () => {
    if (form.org_admin_contact_number.length > 8) {
        return false;
    }
});
</script>

<template>
    <AdminLayout>
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
        >
            <VContainer>
                <VRow justify="center">
                    <VCol cols="12" md="10" offset-md="1">
                        <VRow>
                            <VCol cols="12" md="6">
                                <span class="text-xl tiggie-title"
                                    >Organisation Details</span
                                >
                                <VRow class="pt-5">
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organisation Name</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="form.name"
                                            class="w-100"
                                            placeholder="Type here ..."
                                            :rules="[requiredValidator]"
                                            :error-messages="form?.errors?.name"
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Contact Person</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="form.contact_name"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.contact_name
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Contact Email</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="form.contact_email"
                                            class="w-100"
                                            :rules="[
                                                requiredValidator,
                                                emailValidator,
                                            ]"
                                            :error-messages="
                                                form?.errors?.contact_email
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Contact Number</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            type="number"
                                            v-model="form.contact_number"
                                            class="w-100"
                                            :rules="[
                                                requiredValidator,
                                                contactNumberValidator(
                                                    form.contact_number,
                                                    8
                                                ),
                                            ]"
                                            :error-messages="
                                                form?.errors?.contact_number
                                            "
                                        />
                                    </VCol>
                                </VRow>
                                <!--  -->
                                <!-- Organisation Plan -->
                                <VRow>
                                    <VCol cols="12">
                                        <span class="text-xl tiggie-title"
                                            >Organisation Admin</span
                                        >
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organisation Admin Name</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="form.org_admin_name"
                                            class="w-100"
                                            :error-messages="
                                                form?.errors?.org_admin_name
                                            "
                                            :rules="[requiredValidator]"
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organisation Admin Contact
                                            Number</VLabel
                                        >

                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="
                                                form.org_admin_contact_number
                                            "
                                            class="w-100"
                                            type="number"
                                            :rules="[
                                                requiredValidator,
                                                contactNumberValidator(
                                                    form.org_admin_contact_number,
                                                    8
                                                ),
                                            ]"
                                            :error-messages="
                                                form?.errors
                                                    ?.org_admin_contact_number
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Login Email</VLabel
                                        >

                                        <VTextField
                                            type="email"
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="form.login_email"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.login_email
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Login Password</VLabel
                                        >
                                        <VTextField
                                            v-model="form.login_password"
                                            :rules="[requiredValidator]"
                                            density="compact"
                                            :type="
                                                isPasswordVisible
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            :error-messages="
                                                form?.errors?.login_password
                                            "
                                            :append-inner-icon="
                                                isPasswordVisible
                                                    ? 'mdi-eye-off-outline'
                                                    : 'mdi-eye-outline'
                                            "
                                            @click:append-inner="
                                                isPasswordVisible =
                                                    !isPasswordVisible
                                            "
                                        />
                                    </VCol>
                                </VRow>
                            </VCol>
                            <VCol cols="12" md="6" class="pt-5">
                                <span class="tiggie-title">Logo</span>
                                <br />
                                <ImageUpload v-model="form.image" />
                            </VCol>
                            <VCol
                                cols="12"
                                class="d-flex flex-wrap justify-center gap-10"
                            >
                                <Link
                                    :href="route('organisations.index')"
                                    class="text-black"
                                >
                                    <VBtn
                                        color="gray"
                                        height="50"
                                        class=""
                                        width="200"
                                    >
                                        Cancel
                                    </VBtn>
                                </Link>
                                <VBtn
                                    type="submit"
                                    class=""
                                    height="50"
                                    width="200"
                                >
                                    Finish
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
            </VContainer>
        </VForm>
    </AdminLayout>
</template>

<style scoped>
.logo-position {
    /* position: absolute;
    top: 180px; */
}

.padding-left-40px {
    padding-left: 40px;
}
</style>
