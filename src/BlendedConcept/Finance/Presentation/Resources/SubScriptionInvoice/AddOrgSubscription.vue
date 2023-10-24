<script setup>
import { useForm, Link, usePage } from "@inertiajs/vue3";
import { ref, defineProps, computed, watch } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import { toastAlert } from "@Composables/useToastAlert";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
import ImageDropFile from "@mainRoot/components/DropFile/ImageDropFile.vue";

const isFormValid = ref(false);
const isDialogVisible = ref(false);
let refForm = ref();

let flash = computed(() => usePage().props.flash);
let isPasswordVisible = ref(false);
let selectedOrg = ref(null);
const props = defineProps(["organisations"]);
let form = useForm({
    start_date: "",
    end_date: "",
    payment_date: "",
    payment_status: "UNPAID",
    stripe_price: "",
    id: null,
    image: "",
    b2b_subscription: {
        storage_limit: "",
        num_teacher_license: "",
        num_student_license: "",
        organisation_id: null,
        subscription_id: null,
    },
    _method: "PUT",
});

// submit create form
let handleSubmit = () => {

    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("subscriptions.store_subscription", form.id), {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
                onError: (error) => {
                    SuccessDialog({
                        title: error?.isExpire,
                        icon: "warning",
                        color: "#ff6262",
                        mainTitle: "Failed!",
                    });
                },
            });
        }
    });
};
watch(selectedOrg, (value) => {
    let data = props.organisations.find(
        (organisation) => organisation.id == value
    );
    form.id = data.id;
    form.b2b_subscription.organisation_id = data.id;
    form.b2b_subscription.subscription_id = data.curr_subscription_id;
});
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
                                <div class="d-flex align-center">
                                    <span class="text-h6 mr-4"
                                        >Adding Subscription for
                                    </span>
                                    <v-select
                                        placeholder="Select"
                                        class="mt-4"
                                        v-model="selectedOrg"
                                        item-value="id"
                                        item-title="name"
                                        :items="props.organisations"
                                        :rules="[requiredValidator]"
                                    ></v-select>
                                </div>
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
                                <VRow class="pt-16">
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
                                        <!-- <ImageUpload
                                            :hide_count="true"
                                            data_type="user"
                                            v-model="form.image"
                                        /> -->
                                        <ImageDropFile
                                            v-model="form.image"
                                            memeType="image"
                                            :id="3"
                                        />
                                    </VCol>
                                </VRow>
                            </VCol>

                            <VCol
                                cols="12"
                                class="d-flex flex-wrap justify-center gap-10"
                            >
                                <Link
                                    :href="route('subscription_invoice')"
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
