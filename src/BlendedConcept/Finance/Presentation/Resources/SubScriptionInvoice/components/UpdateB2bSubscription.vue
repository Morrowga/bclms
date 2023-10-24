<script setup>
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, defineProps } from "vue";
const isDialogVisible = ref(false);
const date = ref("");
const isFormValid = ref(false);
let refForm = ref();
const props = defineProps(["subscription", "flash"]);
let flash = computed(() => usePage().props.flash);
const form = useForm({
    end_date: "",
    start_date: "",
    payment_status: "",
    stripe_status: "",
    b2b_subscription: {
        storage_limit: 0,
        num_teacher_license: 0,
        num_student_license: 0,
    },
    _method: "PUT",
});
const updateSubscription = () => {
    SuccessDialog({
        title: "You have successfully updated subscription and sent email to affected user",
    });
    isDialogVisible.value = false;
};

let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(
                route("subscription_invoice.updateb2b", props.subscription.id),
                {
                    onSuccess: () => {
                        FlashMessage({ flash });
                        isDialogVisible.value = false;
                    },
                    onError: (error) => {},
                }
            );
        }
    });
};
onUpdated(() => {
    form.end_date = props.subscription.end_date;
    form.start_date = props.subscription.start_date;
    form.stripe_status = props.subscription.stripe_status ?? "INACTIVE";
    form.payment_status = props.subscription.payment_status ?? "UNPAID";
    form.b2b_subscription.storage_limit =
        props.subscription?.b2b_subscription?.storage_limit ?? 0;
    form.b2b_subscription.num_student_license =
        props.subscription?.b2b_subscription?.num_student_license ?? 0;
    form.b2b_subscription.num_teacher_license =
        props.subscription?.b2b_subscription?.num_teacher_license ?? 0;
});
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500" persistent>
        <!-- Activator -->
        <template #activator="{ props }">
            <VListItemTitle v-bind="props">Update</VListItemTitle>
        </template>

        <!-- Dialog Content -->
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
        >
            <VCard class="update-subscription pa-7">
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="isDialogVisible = false"
                />

                <VCardTitle class="tiggie-title"
                    >Update Subscription</VCardTitle
                >

                <VCardText>
                    <VRow justify="center" align="center" class="subscription">
                        <VCol cols="6" class="date-time">
                            <VLabel class="tiggie-label">Teacher</VLabel>
                            <VTextField
                                v-model="
                                    form.b2b_subscription.num_teacher_license
                                "
                                class="subplan-icon blue-outline-field"
                                variant="plain"
                            >
                            </VTextField>
                        </VCol>
                        <VCol cols="6" class="date-time">
                            <VLabel class="tiggie-label">Start Date</VLabel>
                            <AppDateTimePicker
                                v-model="form.start_date"
                                class="subplan-icon blue-outline-field"
                                append-inner-icon="fa:fa-regular fa-calendar"
                                variant="plain"
                            >
                            </AppDateTimePicker>
                        </VCol>
                        <VCol cols="6" class="date-time">
                            <VLabel class="tiggie-label">Student</VLabel>
                            <VTextField
                                v-model="
                                    form.b2b_subscription.num_student_license
                                "
                                class="subplan-icon blue-outline-field"
                                variant="plain"
                            >
                            </VTextField>
                        </VCol>
                        <VCol cols="6" class="date-time">
                            <VLabel class="tiggie-label">End Date</VLabel>
                            <AppDateTimePicker
                                v-model="form.end_date"
                                class="subplan-icon blue-outline-field"
                                append-inner-icon="fa:fa-regular fa-calendar"
                                variant="plain"
                            />
                        </VCol>
                        <VCol cols="6" class="date-time">
                            <VLabel class="tiggie-label">Storage</VLabel>
                            <VTextField
                                v-model="form.b2b_subscription.storage_limit"
                                class="subplan-icon blue-outline-field"
                                variant="plain"
                            >
                            </VTextField>
                        </VCol>
                        <VCol cols="6" class="date-time">
                            <div
                                class="d-flex justify-space-between align-center"
                            >
                                <div class="active">
                                    <VLabel class="tiggie-label">
                                        Active
                                    </VLabel>
                                    <VSwitch
                                        inset
                                        color="primary"
                                        v-model="form.stripe_status"
                                        true-value="ACTIVE"
                                        false-value="INACTIVE"
                                    />
                                </div>
                                <div class="paid">
                                    <VLabel class="tiggie-label"> Paid </VLabel>
                                    <VSwitch
                                        inset
                                        color="primary"
                                        v-model="form.payment_status"
                                        true-value="PAID"
                                        false-value="UNPAID"
                                    />
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </VCardText>

                <VCardActions
                    class="d-flex justify-space-around gap-5 ml-5 mt-5"
                >
                    <VBtn
                        color="gray"
                        variant="flat"
                        width="164px"
                        height="50"
                        @click="isDialogVisible = false"
                    >
                        <span class="text-white">Cancel</span>
                    </VBtn>
                    <VBtn
                        color="primary"
                        variant="flat"
                        width="164px"
                        height="50"
                        type="submit"
                    >
                        <span class="text-white">Save</span>
                    </VBtn>
                </VCardActions>
            </VCard>
        </VForm>
    </VDialog>
</template>
<style scoped>
/* .subplan .v-selection-control-group--inline {
    justify-content: center;
} */
.update-subscription .subplan-icon .v-field__append-inner i {
    font-size: 25px !important;
}
.update-subscription .blue-outline-field {
    border: 1px solid var(--Primary, #001a8f);
    border-radius: 5px;
    background: var(--White, #fff);
    padding: 4px 16px;
}
:deep(.v-field__input) {
    padding-top: 0 !important;
}
body
    > div.v-overlay-container
    > div.v-overlay.v-overlay--active.v-theme--light.v-locale--is-ltr.v-dialog.v-overlay--scroll-blocked
    > div.v-overlay__content
    > div
    > div.v-card-text
    > div.subscription
    > div
    > div
    > div
    > div
    > div.v-field__append-inner {
    padding-top: 6px !important;
}
</style>
