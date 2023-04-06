<script setup>
import { useGenerateImageVariant } from "@/@core/composable/useGenerateImageVariant";
import AuthProvider from "@/views/pages/authentication/AuthProvider.vue";
import authV1RegisterMaskDark from "@images/pages/auth-v1-register-mask-dark.png";
import authV1RegisterMaskLight from "@images/pages/auth-v1-register-mask-light.png";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { themeConfig } from "@themeConfig";

import { ref } from "vue";
// inertia
import { Link, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";

let organization = ref(false);
const items = [
    "California",
    "Colorado",
    "Florida",
    "Georgia",
    "Texas",
    "Wyoming",
];

const isPasswordVisible = ref(false);
let agreed = ref("");
</script>

<template>
    <div style="max-width:1024px;margin-inline:auto;margin-top:100px;background:url('images/signup.svg') 100vw">
    <VRow class="d-flex justify-center  text-center">
        <VCol lg="6" md="6" sm="12">
            <VCard class="auth-card pa-2 pt-16" max-width="448">
                <VCardText class="pt-2">
                    <h1 class="mb-1 pb-3 text-center">
                        Are you signing up under
                    </h1>
                    <h1 class="text-center">an Organization account?</h1>
                </VCardText>

                <VCardText>
                    <VRow class="">
                        <VCol cols="12" class="">
                            <VRadioGroup
                                v-model="organization"
                                inline
                                class="border-dashed border-3"
                                style="padding-left: 120px"
                            >
                                <VRadio label="Yes" value="on" />
                                <VRadio label="No" value="off" />
                            </VRadioGroup>
                        </VCol>
                        <VCol>
                            <h2 class="text-center pb-3">
                                Please Select Organization
                            </h2>
                            <VAutocomplete variant="outlined" :items="items" />
                        </VCol>

                        <!-- login instead -->
                        <VCol cols="12" class="d-flex">
                            <VCheckbox v-model="agreed" />
                            <Vlabel class="text-justify pt-3 pl-3">
                                Yes! I would like to receive udpates, special
                                offers, and other information from Ed+
                            </Vlabel>
                        </VCol>
                    </VRow>
                </VCardText>
            </VCard>
        </VCol>
        <VCol md="6" lg="6" sm="12" v-if="organization">
            <B2BRegister
                v-if="organization == 'on'"
                :class="organization == 'on'? 'animate__animated animate__backInRight animate__delay-0.1s': 'text-clip'"
            />
            <B2CRegister
                v-if="organization == 'off'"
                :class="organization == 'off' ? 'animate__animated animate__backInRight animate__delay-0.1s': 'text-clip'"
            />
        </VCol>
    </VRow>
    </div>
</template>
@use "@styles/@core/template/pages/page-auth.scss";

<style lang="scss"></style>
