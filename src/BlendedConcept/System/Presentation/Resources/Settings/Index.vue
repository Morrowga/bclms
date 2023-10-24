<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";

import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

let props = defineProps(["setting"]);
let flash = computed(() => usePage().props.flash)
let page = usePage();

let form = useForm({
    site_name: props?.setting?.site_name,
    ssl: props?.setting?.ssl ?? "",
    fav_icon: "",
    site_logo: "",
    site_time_zone: props?.setting?.site_time_zone,
    site_locale: props?.setting?.site_locale,
    email: props?.setting?.email,
    contact_number: props?.setting?.contact_number,
    url: props?.setting?.url,
    sub_domain: "",
});
console.log(form);
let refForm = ref();
function handleUpdateSite() {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("updateSetting"), {
                onSuccess: () => {
                    FlashMessage({ flash })
                },
                onError: (error) => {},
            });
        }
    });
}
</script>

<template>
    <AdminLayout>
        <VContainer>
            <VForm ref="refForm" @submit.prevent="handleUpdateSite">
                <VRow>
                    <VCol cols="6">
                        <h4 class="tiggie-show-title pr-10 margin-buttom-18">
                            Website Details
                        </h4>
                        <VRow>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Site Name</VLabel>
                                <VTextField
                                    v-model="form.site_name"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.site_name"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">SSL</VLabel>
                                <VTextField
                                    v-model="form.ssl"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label"
                                    >Site Time Zone</VLabel
                                >
                                <VTextField
                                    v-model="form.site_time_zone"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.site_time_zone
                                    "
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label"
                                    >Site Locale</VLabel
                                >
                                <VTextField
                                    v-model="form.site_locale"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.site_locale"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Email</VLabel>
                                <VTextField
                                    type="email"
                                    v-model="form.email"
                                    :rules="[emailValidator, requiredValidator]"
                                    :error-messages="form?.errors?.email"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label"
                                    >Contact Number</VLabel
                                >
                                <VTextField
                                    type="number"
                                    v-model="form.contact_number"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">URL</VLabel>
                                <VTextField
                                    v-model="form.url"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Sub Domain</VLabel>
                                <VTextField
                                    v-model="form.sub_domain"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="12">
                                <h4 class="pb-2 tiggie-show-title">
                                    Website Logo
                                </h4>
                                <ImageUpload
                                    v-model="form.site_logo"
                                    :old_img="$page?.props?.site_logo ?? ''"
                                />

                                <VBtn class="w-100" height="55" max-width="400"
                                    >Change Logo</VBtn
                                >
                            </VCol>
                            <VCol cols="12">
                                <h4 class="pb-2 tiggie-show-title">
                                    Website Favicon
                                </h4>
                                <ImageUpload
                                    v-model="form.fav_icon"
                                    :old_img="$page?.props?.fav_icon ?? ''"
                                />

                                <VBtn class="w-100" height="55" max-width="400"
                                    >Change Favicon</VBtn
                                >
                            </VCol>
                        </VRow>
                    </VCol>
                </VRow>
                <VRow justify="center" class="mt-16">
                    <VCol cols="4" justify="center" class="ml-2">
                        <VBtn
                            type="submit"
                            class="tiggie-btn text-white"
                            height="50"
                            width="200"
                        >
                            Update
                        </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>

<style lang="scss" scoped>
:deep(.v-input__control) {
    border: 1px solid blue !important;
    border-radius: 10px !important;
}
/* :deep(.v-btn__content) {
    color: #fff !important;
} */
</style>
