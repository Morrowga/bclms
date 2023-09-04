<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { SuccessDialog } from "@actions/useSuccess";

import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
const timezone = [
    "Pacific/Honolulu",
    "Pacific/Honolulu",
    "America/Anchorage",
    "Pacific/Midway",
    "Pacific/Honolulu",
    "America/Los_Angeles",
    "America/Denver",
    "America/Chicago",
    "America/New_York",
    "America/Halifax",
    "America/Santo_Domingo",
    "America/Caracas",
    "America/Manaus",
    "America/Santiago",
    "America/St_Johns",
    "America/Godthab",
    "America/Argentina/Buenos_Aires",
    "Atlantic/South_Georgia",
    "Atlantic/Azores",
    "Africa/Casablanca",
    "Europe/London",
    "Europe/Berlin",
    "Europe/Paris",
    "Europe/Madrid",
    "Africa/Lagos",
    "Europe/Istanbul",
    "Europe/Kiev",
    "Asia/Jerusalem",
    "Asia/Riyadh",
    "Asia/Baghdad",
    "Asia/Tehran",
    "Asia/Muscat",
    "Asia/Baku",
    "Asia/Yekaterinburg",
    "Asia/Karachi",
    "Asia/Kolkata",
    "Asia/Kathmandu",
    "Asia/Dhaka",
    "Asia/Bangkok",
    "Asia/Hong_Kong",
    "Asia/Shanghai",
    "Asia/Tokyo",
    "Australia/Brisbane",
    "Australia/Adelaide",
    "Australia/Sydney",
    "Pacific/Auckland",
];
const locales = [
    "af",
    "ar",
    "az",
    "be",
    "bg",
    "bn",
    "bs",
    "ca",
    "cs",
    "cy",
    "da",
    "de",
    "el",
    "en",
    "eo",
    "es",
    "et",
    "eu",
    "fa",
    "fi",
    "fr",
    "ga",
    "gl",
    "gu",
    "he",
    "hi",
    "hr",
    "ht",
    "hu",
    "hy",
    "id",
    "is",
    "it",
    "ja",
    "ka",
    "kk",
    "km",
    "kn",
    "ko",
    "ku",
    "ky",
    "lb",
    "lo",
    "lt",
    "lv",
    "mg",
    "mk",
    "ml",
    "mn",
    "mr",
    "ms",
    "mt",
    "nb",
    "ne",
    "nl",
    "nn",
    "no",
    "oc",
    "or",
    "pa",
    "pl",
    "ps",
    "pt",
    "ro",
    "ru",
    "si",
    "sk",
    "sl",
    "sq",
    "sr",
    "sv",
    "sw",
    "ta",
    "te",
    "tg",
    "th",
    "tk",
    "tr",
    "tt",
    "ug",
    "uk",
    "ur",
    "uz",
    "vi",
    "xh",
    "yi",
    "yo",
    "zh",
    "zu",
];

let props = defineProps(["setting"]);
let page = usePage();

console.log(props.setting);

let form = useForm({
    site_name: props?.setting?.site_name,
    ssl: props?.setting?.ssl ?? "",
    fav_icon: "",
    site_logo: "",
    timezone: props?.setting?.timezone,
    locale: props?.setting?.locale,
    email: props?.setting?.email,
    contact_number: props?.setting?.contact_number ?? "",
    url: "",
    sub_domain: "",
});

function handleUpdateSite() {
    form.post(route("updateSetting"), {
        onSuccess: () => {
            SuccessDialog({
                title: "You have successfully updated site setting",
            });
        },
        onError: (error) => {},
    });
}
</script>

<template>
    <AdminLayout>
        <VContainer>
            <VForm @submit.prevent="handleUpdateSite">
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
                                    class=""
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">SSL</VLabel>
                                <VTextField v-model="form.ssl" class="" />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label"
                                    >Site Time Zone</VLabel
                                >
                                <VSelect
                                    :items="timezone"
                                    v-model="form.timezone"
                                    :error-messages="form?.errors?.timezone"
                                    class=""
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label"
                                    >Site Locale</VLabel
                                >
                                <VSelect
                                    :items="locales"
                                    v-model="form.locale"
                                    :error-messages="form?.errors?.locale"
                                    class=""
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Email</VLabel>
                                <VTextField
                                    type="email"
                                    v-model="form.email"
                                    :rules="[emailValidator]"
                                    :error-messages="form?.errors?.email"
                                    class=""
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
                                    class=""
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">URL</VLabel>
                                <VTextField
                                    v-model="form.url"
                                    :rules="[requiredValidator]"
                                    class=""
                                />
                            </VCol>
                            <VCol cols="8">
                                <VLabel class="tiggie-label">Sub Domain</VLabel>
                                <VTextField
                                    v-model="form.sub_domain"
                                    :rules="[requiredValidator]"
                                    class=""
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
