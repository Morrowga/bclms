<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

const isFormValid = ref(false);
const isDialogVisible = ref(false);
let refForm = ref();

let flash = computed(() => usePage().props.flash);

let form = useForm({
    name: "Blended Concept",
    contact_person: "Jordan Stevenson",
    contact_email: "",
    contact_number: "",
    price: "",
    teacher_license: "",
    allocated_storage: "",
    payment_period: "",
    // payment_type: "card",
    image: "",
});

// submit create form
let handleSubmit = () => {
    SuccessDialog({ title: "You've successfully created organization" });

    // refForm.value?.validate().then(({ valid }) => {
    //     if (valid) {
    //         form.post(route("organizations.store"), {
    //             onSuccess: () => {
    //                 SuccessDialog({title:flash?.successMessage})
    //                 isDialogVisible.value = false;
    //             },
    //             onError: (error) => { },
    //         });
    //     }
    // });
};
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
                                    >Organization Details</span
                                >
                                <VRow class="pt-5">
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organization Name</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="form.name"
                                            class="w-100"
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
                                            v-model="form.contact_person"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.contact_person
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Contact Email</VLabel
                                        >
                                        <VTextField
                                            density="compact"
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
                                            v-model="form.contact_number"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.contact_number
                                            "
                                        />
                                    </VCol>
                                </VRow>
                                <!--  -->
                                <!-- Organization Plan -->
                                <VRow>
                                    <VCol cols="12">
                                        <span class="text-xl tiggie-title"
                                            >Organization Admin</span
                                        >
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organization Admin Name</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="form.teacher_license"
                                            class="w-100"
                                            :error-messages="
                                                form?.errors?.teacher_license
                                            "
                                            :rules="[requiredValidator]"
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Organization Admin Contact
                                            Number</VLabel
                                        >

                                        <VTextField
                                            density="compact"
                                            v-model="form.allocated_storage"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.allocated_storage
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
                                            v-model="form.price"
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.price
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Login Password</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="form.payment_period"
                                            class="w-100"
                                            :error-messages="
                                                form?.errors?.payment_period
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
                                    :href="route('organizations.index')"
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
