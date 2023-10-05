<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import { toastAlert } from "@Composables/useToastAlert";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
const isFormValid = ref(false);
const isDialogVisible = ref(false);
let refForm = ref();

let flash = computed(() => usePage().props.flash);
let isPasswordVisible = ref(false);
const props = defineProps(["organisation"]);
let form = useForm({
    start_date: "",
    end_date: "",
    payment_date: "",
    payment_status: "UNPAID",
    stripe_price: "",
    b2b_subscription: {
        storage_limit: "",
        num_teacher_license: "",
        num_student_license: "",
        organisation_id: props.organisation?.id,
        subscription_id: props.organisation?.subscription?.id ?? null,
        image: "",
    },
    _method: "PUT",
});

// submit create form
let handleSubmit = () => {
    // SuccessDialog({ title: "You've successfully created organisation" });

    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(
                route(
                    "organisations.storeSubscription",
                    props.organisation?.id
                ),
                {
                    onSuccess: () => {
                        SuccessDialog({ title: flash?.successMessage });
                    },
                    onError: (error) => {},
                }
            );
        }
    });
};
</script>

<template>
    <AdminLayout>
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
        >
            <VContainer class="add-subscription">
                <VRow justify="center">
                    <VCol cols="12" md="10" offset-md="1">
                        <VRow>
                            <VCol cols="12" md="6">
                                <span class="text-xl tiggie-title d-block"
                                    >Add Subscription</span
                                >
                                <span class="text-h6"
                                    >Adding Subscription for
                                    <span class="l-blue text-h6">{{
                                        props.organisation?.name
                                    }}</span></span
                                >
                                <VRow class="pt-5">
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >No. Of Teachers</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="
                                                form.b2b_subscription
                                                    .num_teacher_license
                                            "
                                            class="w-100"
                                            placeholder="Type here ..."
                                            type="number"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.b2b_subscription
                                                    ?.num_teacher_license
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >No. Of Student</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            v-model="
                                                form.b2b_subscription
                                                    .num_student_license
                                            "
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            type="number"
                                            :error-messages="
                                                form?.errors?.b2b_subscription
                                                    ?.num_student_license
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Storage Size</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            placeholder="Type here ..."
                                            type="number"
                                            v-model="
                                                form.b2b_subscription
                                                    .storage_limit
                                            "
                                            class="w-100"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.b2b_subscription
                                                    ?.storage_limit
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Start Date</VLabel
                                        >
                                        <AppDateTimePicker
                                            density="compact"
                                            v-model="form.start_date"
                                            class="subplan-icon blue-outline-field"
                                            append-inner-icon="fa:fa-regular fa-calendar"
                                            variant="plain"
                                            :error-messages="
                                                form?.errors?.start_date
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >End Date</VLabel
                                        >
                                        <AppDateTimePicker
                                            density="compact"
                                            v-model="form.end_date"
                                            class="subplan-icon blue-outline-field"
                                            append-inner-icon="fa:fa-regular fa-calendar"
                                            variant="plain"
                                            :error-messages="
                                                form?.errors?.end_date
                                            "
                                        />
                                    </VCol>
                                </VRow>
                            </VCol>
                            <VCol cols="12" md="6" class="marging-same-left">
                                <VRow class="pt-5">
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Payment Amount</VLabel
                                        >
                                        <VTextField
                                            density="compact"
                                            v-model="form.stripe_price"
                                            class="w-100"
                                            placeholder="Type here ..."
                                            type="number"
                                            :rules="[requiredValidator]"
                                        />
                                    </VCol>

                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Payment Date</VLabel
                                        >
                                        <AppDateTimePicker
                                            density="compact"
                                            v-model="form.payment_date"
                                            class="subplan-icon blue-outline-field"
                                            append-inner-icon="fa:fa-regular fa-calendar"
                                            variant="plain"
                                            :error-messages="
                                                form?.errors?.payment_date
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <VLabel class="tiggie-label required"
                                            >Payment Receipt</VLabel
                                        >
                                        <ImageUpload
                                            :hide_count="true"
                                            data_type="user"
                                            v-model="
                                                form.b2b_subscription.image
                                            "
                                        />
                                    </VCol>
                                </VRow>
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

<style>
.logo-position {
    /* position: absolute;
    top: 180px; */
}

.add-subscription .padding-left-40px {
    padding-left: 40px;
}
.add-subscription .subplan-icon .v-field__append-inner i {
    font-size: 25px !important;
}
.add-subscription .subplan-icon .v-field__append-inner {
    padding-top: 0 !important;
}
.add-subscription .blue-outline-field {
    border: 1px solid rgb(118, 118, 118);
    border-radius: 5px;
    /* background: var(--White, #fff); */
    padding: 4px 16px;
}
.marging-same-left {
    padding-top: 83px !important;
}
</style>
