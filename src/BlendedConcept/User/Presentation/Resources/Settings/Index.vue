<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import {
  emailValidator,
  requiredValidator,
  integerValidator
} from '@validators'
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
    contact_number: props?.setting?.contact_number,
});

function handleUpdateSite() {
    form.post(route("updateSetting"), {
        onSuccess: () => {
            toastAlert({ title: "updated" });
        },
        onError: (error) => {},
    });
}
</script>

<template>
    <AdminLayout>
        <v-container>
            <h1>Site Settings</h1>

            <VForm @submit.prevent="handleUpdateSite">
                <VRow>
                    <VCol cols="12">
                        <VTextField
                            label="Site Name"
                            v-model="form.site_name"
                            :rules="[requiredValidator]"
                            :error-messages="form?.errors?.site_name"
                            class="pt-5"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VTextField
                            label="SSL"
                            v-model="form.ssl"
                            class="pt-5"
                        />
                    </VCol>
                    <VCol cols="12">
                        <h4 class="pb-2">Site Logo</h4>
                        <ImageUpload
                            v-model="form.site_logo"
                            :old_img="$page?.props?.site_logo ?? ''"
                        />
                    </VCol>
                    <VCol cols="12">
                        <h4 class="pb-2">Site Favicon</h4>
                        <ImageUpload
                            v-model="form.fav_icon"
                            :old_img="$page?.props?.fav_icon ?? ''"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VSelect
                            :items="timezone"
                            v-model="form.timezone"
                            :error-messages="form?.errors?.timezone"
                            label="Site Time Zone"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VSelect
                            :items="locales"
                            label="Site Locale"
                            v-model="form.locale"
                            :error-messages="form?.errors?.locale"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VTextField
                            label="Email"
                            type="email"
                            v-model="form.email"
                            :rules="[emailValidator]"
                            :error-messages="form?.errors?.email"
                            class="pt-5"
                        />
                    </VCol>
                    <VCol cols="12">
                        <VTextField
                            label="Contact Number"
                            type="number"
                            v-model="form.contact_number"
                            :rules="[integerValidator]"
                            :error-messages="form?.errors?.contact_number"
                            class="pt-5"
                        />
                    </VCol>
                    <VCol cols="4" class="ml-2">
                        <VBtn type="submit">
                            <VIcon icon="mdi-wrench-outline" />
                            Update
                        </VBtn>
                    </VCol>
                </VRow>
            </VForm>
        </v-container>
    </AdminLayout>
</template>
