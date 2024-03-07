<script setup>
import { VForm } from "vuetify/components";
import { themeConfig } from "@themeConfig";
import { router } from "@inertiajs/core";
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

 const signUpRoute = () => {
    window.location.href = 'https://forms.gle/Htu51mFVagzA2odBA';
 }

 const goMainPage = () => {
    window.location.href = '/bc/index';
 }

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
                class="navbar-content-container d-flex justify-space-between px-2 py-1"
            >
                <Link
                    @click="goMainPage()"
                    class="d-none d-lg-flex align-center"
                >
                    <img src="/images/logoblack.png" width="200" height="55" />
                </Link>
                <!-- <VBtn color="primary" class="b-0 text-white">
                    <Link :href="route('register')" class="text-white">
                        Register
                    </Link>
                </VBtn> -->
            </div>
        </div>

        <div>
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="form?.errors.length"
            />
           <VRow>
                <VCol cols="12" md="6" sm="6" lg="6">
                    <div class="container">
                        <fieldset class="text-center login-form px-5 mx-5">
                            <legend class="login-head-text">
                                Login
                            </legend>
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
                                                            @click="signUpRoute"
                                                            block
                                                            class="bg-signup"
                                                            type="button"
                                                            rounded
                                                        >
                                                            Sign Up
                                                        </VBtn>
                                                    </VCol>
                                                </VRow>
                                        </VCol>
                                    </VRow>
                                </VForm>
                            </VCardText>
                        </fieldset>
                    </div>
                </VCol>
           </VRow>
            <!-- <div class="login-card">
                <div class="d-flex align-center vh-100">

                </div>
            </div> -->
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";

.login-bg {
    background: url("/public/images/Login_page.png") no-repeat;
    background-size: cover !important;
    background-position: center !important;
    width: 100%;
    position: fixed;
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

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 0px);
}

.login-form {
    max-width: 400px;
    width: 100%;
}

.login-form{
    border-radius: 20px;
    padding: 5px;
    max-width: 400px;
    width: 100%;
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
    color: #000 !important;
    padding: 1vh;
    background: linear-gradient(45deg, #6FD9D1, #4167E4) !important; /* Adjust colors as needed */
    font-size: 2rem !important;
    -webkit-background-clip: text !important;
    color: transparent !important;
    background-clip: text !important;
    // top: 25.5%;
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
