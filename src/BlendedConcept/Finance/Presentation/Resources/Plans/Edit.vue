<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { requiredValidator } from "@validators";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";

let flash = computed(() => usePage().props.flash);
const isFormValid = ref(false);
let refForm = ref();
let form = useForm({
    name: "",
    description: "",
    price: 0,
    num_student_license: 0,
    storage_limit: 0,
    allow_customisation: false,
    allow_personalisation: false,
    allow_full_library_access: false,
    allow_concurrent_access: false,
    allow_weekly_learning_report: false,
    allow_dedicated_student_report: false,
});

// submit create form
let handleSubmit = () => {
    // SuccessDialog({ title: "You've successfully created organization" });

    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("plans.update", props.plan.id), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
                onError: (error) => {},
            });
        }
    });
};
onMounted(() => {
    form.name = props.plan?.name;
    form.description = props.plan?.description;
    form.price = props.plan?.price;
    form.num_student_license = props.plan?.num_student_license;
    form.storage_limit = props.plan?.storage_limit;
    form.allow_customisation = props.plan?.allow_customisation;
    form.allow_personalisation = props.plan?.allow_personalisation;
    form.allow_full_library_access = props.plan?.allow_full_library_access;
    form.allow_concurrent_access = props.plan?.allow_concurrent_access;
    form.allow_weekly_learning_report =
        props.plan?.allow_weekly_learning_report;
    form.allow_dedicated_student_report =
        props.plan?.allow_dedicated_student_report;
});
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VForm
                class="mt-6"
                v-model="isFormValid"
                @submit.prevent="handleSubmit"
            >
                <VRow justify="space-around" :gutter="10">
                    <VCol cols="6">
                        <span class="tiggie-title margin-buttom-18">
                            Edit Subscription Plan</span
                        >
                    </VCol>
                    <VCol cols="6"></VCol>
                    <VCol cols="6">
                        <span class="tiggie-subtitle">Basic Details</span>
                        <VRow gutters="5">
                            <VCol cols="8">
                                <VLabel class="tiggie-label required"
                                    >Plan Name</VLabel
                                >
                                <VTextField
                                    placeholder="Type here.."
                                    density="compact"
                                    v-model="form.name"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.name"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label required"
                                    >Description</VLabel
                                >
                                <VTextField
                                    placeholder="Type here..."
                                    density="compact"
                                    v-model="form.description"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.description"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label required"
                                    >Price</VLabel
                                >
                                <VTextField
                                    placeholder="Type here..."
                                    density="compact"
                                    type="number"
                                    v-model="form.price"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.price"
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="6">
                        <span class="tiggie-subtitle">Usage Allowance</span>
                        <VRow>
                            <VCol cols="8">
                                <VLabel class="tiggie-label required"
                                    >Number of Student Profile</VLabel
                                >
                                <VTextField
                                    placeholder="Type here.."
                                    density="compact"
                                    type="number"
                                    v-model="form.num_student_license"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.num_student_license
                                    "
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label required"
                                    >Storage space</VLabel
                                >
                                <VTextField
                                    placeholder="Type here..."
                                    density="compact"
                                    suffix="GB"
                                    v-model="form.storage_limit"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.storage_limit
                                    "
                                />
                            </VCol>
                            <VCol cols="8">
                                <VRow no-gutters>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Customization
                                        </VLabel>
                                        <VSwitch
                                            v-model="form.allow_customisation"
                                            inset
                                        />
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Personalization</VLabel
                                        >
                                        <VSwitch
                                            v-model="form.allow_personalisation"
                                            inset
                                        />
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Full Library Access
                                        </VLabel>
                                        <VSwitch
                                            v-model="
                                                form.allow_full_library_access
                                            "
                                            inset
                                        />
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Concurrent Access</VLabel
                                        >
                                        <VSwitch
                                            v-model="
                                                form.allow_concurrent_access
                                            "
                                            inset
                                        />
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Weekly Learning Report
                                        </VLabel>
                                        <VSwitch
                                            v-model="
                                                form.allow_weekly_learning_report
                                            "
                                            inset
                                        />
                                    </VCol>
                                    <VCol cols="6">
                                        <VLabel class="tiggie-label"
                                            >Dedicated Student Report</VLabel
                                        >
                                        <VSwitch
                                            v-model="
                                                form.allow_dedicated_student_report
                                            "
                                            inset
                                        />
                                    </VCol>
                                </VRow>
                            </VCol>
                        </VRow>
                    </VCol>

                    <VCol
                        cols="12"
                        class="d-flex flex-wrap justify-center gap-10"
                    >
                        <Link :href="route('plans.index')" class="text-black">
                            <VBtn color="gray" height="50" class="" width="250">
                                Cancel
                            </VBtn>
                        </Link>
                        <VBtn type="submit" class="" height="50" width="250">
                            Update
                        </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
