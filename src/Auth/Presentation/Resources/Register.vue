<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";
import Plan from "./Plan.vue";
import {
    emailValidator,
    requiredValidator,
    contactNumberValidator,
} from "@validators";
import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";
let organisation = ref(false);
let isAlertVisible = ref(true);
const selectedUserType = ref('Teacher');

const isFormValid = ref(false);
const isRegisterFormFilled = ref(false);
let refForm = ref();
const isPasswordVisible = ref(false);
let agreed = ref("");
let props = defineProps(["ErrorMessage"]);
let form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    contact_number: "",
    password: "",
    password_confirmation: "",
});

const goPlan = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            isRegisterFormFilled.value = true
        }
    });
};

const radioClick = (type) => {
  selectedUserType.value = type;
};
</script>

<template>
    <div v-if="!isRegisterFormFilled">
        <div class="layout-navbar">
            <div
                class="navbar-content-container d-flex justify-space-between px-10 py-5"
            >
                <h1
                    class="text-h5 font-weight-bold leading-normal text-capitalize"
                >
                    {{ themeConfig.app.title }}
                </h1>
                <VBtn color="primary" class="b-0 text-white">
                    <Link :href="route('login')" class="text-white">
                        Login
                    </Link>
                </VBtn>
            </div>
        </div>
        <SystemErrorAlert
            :sytemErrorMessage="sytemErrorMessage"
            v-if="sytemErrorMessage"
        />

        <VDivider></VDivider>

        <div class="text-center mt-10">
            <p class="ruddy-bold signup-title">Sign Up For B2C Account</p>
            <VForm ref="refForm" v-model="isFormValid" @submit.prevent="goPlan">
                <VRow class="mt-10">
                    <VCol cols="4"> </VCol>
                    <VCol cols="4" class="text-left">
                        <VRow>
                            <VCol cols="6">
                                <div>
                                    <VLabel class="required">First Name</VLabel>
                                    <VTextField
                                        class="mt-3 custom-label-color"
                                        placeholder=""
                                        density="compact"
                                        variant="filled"
                                        v-model="form.first_name"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.first_name"
                                    />
                                </div>
                            </VCol>
                            <VCol size="6">
                                <div>
                                    <VLabel class="required">Last Name</VLabel>
                                    <VTextField
                                        class="mt-3 custom-label-color"
                                        placeholder=""
                                        density="compact"
                                        variant="filled"
                                        v-model="form.last_name"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.last_name"
                                    />
                                </div>
                            </VCol>
                        </VRow>
                        <div class="mt-4">
                            <VLabel class="required">Email</VLabel>
                            <VTextField
                                class="my-3 custom-label-color"
                                placeholder=""
                                density="compact"
                                variant="filled"
                                v-model="form.email"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.email"
                            />
                        </div>
                        <div>
                            <VLabel class="required">Contact Number</VLabel>
                            <VTextField
                                class="my-3 custom-label-color"
                                placeholder=""
                                density="compact"
                                type="number"
                                variant="filled"
                                v-model="form.contact_number"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.contact_number"
                            />
                        </div>
                        <div>
                            <VLabel class="required">Password</VLabel>
                            <VTextField
                                class="my-3 custom-label-color"
                                placeholder=""
                                density="compact"
                                variant="filled"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="
                                    isPasswordVisible
                                        ? 'mdi-eye-off-outline'
                                        : 'mdi-eye-outline'
                                "
                                @click:append-inner="
                                    isPasswordVisible = !isPasswordVisible
                                "
                                v-model="form.password"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.password"
                            />
                        </div>
                        <div>
                            <VLabel class="required">Confirm Password</VLabel>
                            <VTextField
                                class="my-3 custom-label-color"
                                placeholder=""
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="
                                    isPasswordVisible
                                        ? 'mdi-eye-off-outline'
                                        : 'mdi-eye-outline'
                                "
                                @click:append-inner="
                                    isPasswordVisible = !isPasswordVisible
                                "
                                density="compact"
                                variant="filled"
                                v-model="form.password_confirmation"
                                :rules="[requiredValidator]"
                                :error-messages="
                                    form?.errors?.password_confirmation
                                "
                            />
                        </div>
                        <div class="d-flex justify-start">
                            <div class="sign-up-as">
                                <span>Sign up as </span>
                            </div>
                            <VRadio
                            label="Teacher"
                            :value="'Teacher'"
                            v-model="selectedUserType"
                            @click="radioClick('Teacher')"
                            ></VRadio>
                            <VRadio
                            v-model="selectedUserType"
                            @click="radioClick('Parent')"
                            :value="'Parent'"
                            label="Parent"
                            ></VRadio>
                        </div>
                        <div class="my-3 d-flex align-center">
                            <v-checkbox
                            ></v-checkbox>
                            <VLabel class="required">
                                I agree to the terms and services
                            </VLabel>
                        </div>
                        <VBtn
                            block
                            type="submit"
                            variant="flat"
                            class="primary my-3"
                            rounded
                        >
                            Sign up
                        </VBtn>
                    </VCol>
                    <VCol cols="4"> </VCol>
                </VRow>
            </VForm>
        </div>
    </div>
    <Plan
    v-model:form="form"
    v-else></Plan>
</template>

<style lang="scss">
@use "@styles/@core/template/pages/page-auth.scss";
.regiser-image {
    //   background: url("/public/images/signupnew.png") 100% no-repeat;
    height: 100vh;
    background-size: cover;
}

.signup-title {
    color: var(--Text, #161616);
    /* H3 Ruddy */
    font-size: 30px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 52px; /* 130% */
    text-transform: capitalize;
}

.sign-up-as{
    padding: 10px;
}

.custom-label-color .v-label {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}
// .primary {
//   color: #001a8f !important;
// }
</style>
