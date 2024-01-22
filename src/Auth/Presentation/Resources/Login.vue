<script setup>
import { VForm } from "vuetify/components";
import { themeConfig } from "@themeConfig";
import { requiredValidator, emailValidator } from "@validators";
import { Link, useForm } from "@inertiajs/vue3";
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import { toastAlert } from "@Composables/useToastAlert";
import { SuccessDialog } from "@actions/useSuccess";

const isPasswordVisible = ref(false);
const rememberMe = ref(false);
let props = defineProps(["errorMessage", "sytemErrorMessage", "tenant"]);

let form = useForm({
    email: "",
    password: "",
});

/***
 *  `${props?.tenant}login-post
 *   this will get tenant route name that extends @route c.login-post  if it has
 *   organiztion or just simple @route login-post
 */

const onSubmit = () => {
    form.post(route(`${props?.tenant}login-post`), {
        onSuccess: () => {
            localStorage.setItem("tenant", props?.tenant ? "c" : "");
        },
        onError: (error) => {
            // toastAlert({
            //     title: "Invalid Creditional",
            //     icon: "error",
            //     bgColor: "red",
            //     textColor: "white",
            //     iconColor: "white",
            // });
            SuccessDialog({
                title: "Invalid Credential",
                mainTitle: "Error!",
                color: "#ff6262",
                icon: "error",
            });
        },
    });
};
</script>

<template>
    <div class="login-bg">
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
                    <Link :href="route('register')" class="text-white">
                        Register
                    </Link>
                </VBtn>
            </div>
        </div>

        <div>
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="form?.errors.length"
            />
            <div class="login-card">
                <VRow class="h-100">
                    <VCol
                        cols="12"
                        sm="6"
                        lg="6"
                        class="bg-surface"
                    >
                        <div class="d-flex justify-center">
                            <div class="login-head-text">
                                <h1 class="px-3 py-2">Login</h1>
                            </div>
                            <div class="login-form pt-3" style="width: 50vh; height: 70vh;">
                                <VCardText>
                                    <VForm @submit.prevent="onSubmit">
                                        <VRow class="login-field">
                                            <VCol cols="12">
                                                <VTextField
                                                    variant="solo"
                                                    v-model="form.email"
                                                    :rules="[requiredValidator]"
                                                    :error-messages="
                                                        form?.errors?.email
                                                    "
                                                />
                                            </VCol>
                                            <VCol cols="12">
                                                <VTextField
                                                    variant="solo"
                                                    v-model="form.password"
                                                    :rules="[requiredValidator]"
                                                    :type="
                                                        isPasswordVisible
                                                            ? 'text'
                                                            : 'password'
                                                    "
                                                    :error-messages="
                                                        form?.errors?.password
                                                    "
                                                    :append-inner-icon="
                                                        isPasswordVisible
                                                            ? 'mdi-eye-off-outline'
                                                            : 'mdi-eye-outline'
                                                    "
                                                    @click:append-inner="
                                                        isPasswordVisible =
                                                            !isPasswordVisible
                                                    "
                                                />

                                                <span
                                                    class="red-top"
                                                    v-if="props?.errorMessage"
                                                >
                                                    {{ props?.errorMessage }}
                                                </span>
                                                <div
                                                    class="d-flex align-center flex-wrap justify-space-between mt-1 mb-4"
                                                >
                                                    <VCheckbox
                                                        class="text-black"
                                                        v-model="rememberMe"
                                                        label="Remember me"
                                                    />
                                                </div>
                                                <VRow>
                                                        <VCol cols="6">
                                                            <v-btn
                                                                block
                                                                class="btn-linear"
                                                                type="submit"
                                                                rounded
                                                            >
                                                                Login
                                                            </v-btn>
                                                        </VCol>
                                                        <VCol cols="6">
                                                            <VBtn
                                                                block
                                                                class="bg-signup"
                                                                type="submit"
                                                                rounded
                                                            >
                                                                Sign Up
                                                            </VBtn>
                                                        </VCol>
                                                    </VRow>
                                                    <VRow>
                                                        <VCol cols="4">
                                                            <div class="divider-1 mt-3"></div>
                                                        </VCol>
                                                        <VCol cols="4">
                                                            <div class="text-center">
                                                                <p class="fs-10">Or Login with social</p>
                                                            </div>
                                                        </VCol>
                                                        <VCol cols="4">
                                                            <div class="divider-1 mt-3"></div>
                                                        </VCol>
                                                    </VRow>
                                                    <VRow>
                                                        <VCol cols="12">
                                                            <v-btn
                                                                block
                                                                class="social-btn"
                                                                type="submit"
                                                                prepend-icon="mdi-facebook"
                                                            >
                                                                Facebook
                                                            </v-btn>
                                                        </VCol>
                                                        <VCol cols="12">
                                                            <VBtn
                                                                block
                                                                class="social-btn"
                                                                type="submit"
                                                                prepend-icon="mdi-google"
                                                            >
                                                                Google
                                                            </VBtn>
                                                        </VCol>
                                                    </VRow>
                                            </VCol>
                                        </VRow>
                                    </VForm>
                                </VCardText>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" lg="6" class="d-flex justify-center bg-surface-variant">
                        <div class="d-flex align-end mx-3">
                            <img :src="'../images/logon-img.png'" width="360">
                        </div>
                    </VCol>
                </VRow>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";

.login-bg {
    background: url("/public/images/Login_page.png") 100% no-repeat;
    background-size: cover !important;
    background-position: center !important;
    min-height: calc(100vh - 0px);
}

:deep(.v-input__details > .v-messages > .v-messages__message) {
    color: red !important;
}
.bg-surface {
    background-color: rgb(var(--v-theme-surface)) !important;
}
.red-top {
    color: red !important;
    padding-top: 10px !important;
}
.lh-h {
    line-height: 45px !important;
}

.login-card{
    padding-top: 10vh;
}

.login-form{
    border-radius: 20px;
    padding: 5px;
    border: 4px solid;
    border-image: linear-gradient(45deg, #6ED7CF, #4066E4); /* Adjust colors as needed */
    border-image-slice: 1;
}

.btn-linear{
    background: linear-gradient(91deg, #6ED8D0 6.88%, #4066E4 93.51%) !important;
    width: 230px;
    padding: 17px 24px !important;
}

.bg-signup{
    background-color: #565660 !important;
    padding: 17px 24px !important;
}

.fs-10{
    font-size: 10px !important;
}

.social-btn{
    background: #D7DDF2 !important;
    color: #4066E4 !important;
}

.login-head-text{
    position: absolute;
    background: #fff !important;
    z-index: 1 !important;
    top: 17.5%;
}

.login-head-text > h1 {
    font-size: 30px !important;
    font-weight: bold;
    background: linear-gradient(45deg, #6FD9D1, #4167E4); /* Adjust colors as needed */
    -webkit-background-clip: text;
    color: transparent;
    background-clip: text;
    display: inline-block; /* Ensures the gradient is applied only to the text */
}

.divider-1{
    border-top: 2px solid #6DD5CE;
    width: 100%;
}

.login-input{
    border: 4px solid #000;
    border-radius: 4px;
}

</style>


<!-- <VRow class="h-100 auth-wrapper d-flex justify-start">
                <VCol
                    cols="6"
                    sm="6"
                    lg="5"
                    class="auth-card-v2 d-flex align-center justify-center bg-surface"
                >
                    <div :max-width="500" class="h-100 login-card">
                        <VCardText>
                            <h5
                                class="text-h4 text-center font-weight-semibold mb-1 primary lh-h"
                            >
                                Login
                            </h5>
                        </VCardText>
                        <VCardText>
                            <VForm @submit.prevent="onSubmit">
                                <VRow class="login-field">
                                    <VCol cols="12">
                                        <label-input class="primary"
                                            >Enter your work email</label-input
                                        >
                                        <VTextField
                                            variant="solo"
                                            v-model="form.email"
                                            class="bg-primary"
                                            :rules="[requiredValidator]"
                                            :error-messages="
                                                form?.errors?.email
                                            "
                                        />
                                    </VCol>
                                    <VCol cols="12">
                                        <label-input class="primary"
                                            >Enter your password</label-input
                                        >
                                        <VTextField
                                            variant="solo"
                                            v-model="form.password"
                                            :rules="[requiredValidator]"
                                            :type="
                                                isPasswordVisible
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            :error-messages="
                                                form?.errors?.password
                                            "
                                            :append-inner-icon="
                                                isPasswordVisible
                                                    ? 'mdi-eye-off-outline'
                                                    : 'mdi-eye-outline'
                                            "
                                            @click:append-inner="
                                                isPasswordVisible =
                                                    !isPasswordVisible
                                            "
                                        />

                                        <span
                                            class="red-top"
                                            v-if="props?.errorMessage"
                                        >
                                            {{ props?.errorMessage }}
                                        </span>
                                        <div
                                            class="d-flex align-center flex-wrap justify-space-between mt-1 mb-4"
                                        >
                                            <VCheckbox
                                                class="text-black"
                                                v-model="rememberMe"
                                                label="Remember me"
                                            />
                                        </div>
                                        <VBtn
                                            block
                                            class="bg-primary"
                                            type="submit"
                                        >
                                            Login
                                        </VBtn>
                                    </VCol>
                                    <VCol
                                        cols="12"
                                        class="text-base text-center primary"
                                    >
                                        <span>New on our platform?</span>
                                        <Link
                                            class="ms-2 text-decoration-underline"
                                            :href="register"
                                        >
                                            Sign up
                                        </Link>
                                    </VCol>
                                </VRow>
                            </VForm>
                        </VCardText>
                    </div>
                </VCol>
            </VRow> -->
