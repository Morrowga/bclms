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
    name: "",
    contact_person: "",
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
        <div>
            <VForm
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="handleSubmit"
            >
                <VContainer>
                    <VRow>
                        <VCol cols="6">
                            <span class="text-xl tiggie-title"
                                >Reward Particulars</span
                            >
                            <VRow class="pt-5">
                                <VCol cols="8">
                                    <VLabel class="tiggie-label">Name</VLabel>
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.name"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.name"
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label"
                                        >Stars Required</VLabel
                                    >
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.name"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.name"
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label">Rarity</VLabel>
                                    <VSelect
                                        :items="items"
                                        rounded="50%"
                                        density="compact"
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label"
                                        >Description</VLabel
                                    >
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.name"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.name"
                                    />
                                </VCol>
                            </VRow>
                        </VCol>
                        <VCol cols="6" class="pt-5">
                            <span class="tiggie-title">Sticker</span>
                            <br />
                            <ImageUpload v-model="form.image" />
                        </VCol>
                        <VCol
                            cols="12"
                            class="d-flex flex-wrap justify-center gap-10"
                        >
                            <Link
                                :href="route('rewards.index')"
                                class="text-black"
                            >
                                <VBtn
                                    color="gray"
                                    height="50"
                                    class=""
                                    width="300"
                                >
                                    Cancel
                                </VBtn>
                            </Link>
                            <VBtn
                                type="submit"
                                class=""
                                height="50"
                                width="300"
                            >
                                Finish
                            </VBtn>
                        </VCol>
                    </VRow>
                </VContainer>
            </VForm>
        </div>
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
