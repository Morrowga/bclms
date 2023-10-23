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
    confirmedValidator,
} from "@validators";
import B2CRegister from "./B2CRegister.vue";
import B2BRegister from "./B2BRegister.vue";
let organisation = ref(false);
let isAlertVisible = ref(true);
const selectedUserType = ref("Teacher");

const isFormValid = ref(false);
const isRegisterFormFilled = ref(false);
let refForm = ref();
const isPasswordVisible = ref(false);
let agreed = ref("");
let props = defineProps(["ErrorMessage", "plans"]);
let form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    contact_number: "",
    plan: 1,
    plan_price: '0.00',
    password: "",
    password_confirmation: "",
    user_type: "Teacher",
});



const goPlan = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            isRegisterFormFilled.value = true;
        }
    });
};

const login = () => {
    router.get(route("login"));
}



console.log(props.plans)

const radioClick = (type) => {
    selectedUserType.value = type;
    form.user_type = type;
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
            </div>
        </div>
        <SystemErrorAlert
            :sytemErrorMessage="sytemErrorMessage"
            v-if="sytemErrorMessage"
        />

        <VDivider></VDivider>

        <div class="text-center margin-verify">
            <VIcon icon="mdi-check-circle-outline" size="130" color="#16cab6"></VIcon>
            <div class="mt-5">
                <span class="thankyou pppangram-bold">Thank You!</span>
            </div>
            <div class="mt-5">
                <p class="verify-description">Your email has been verified.
                    <br>
                    Please use the link below to log in your account
                </p>
            </div>
            <div class="d-flex justify-center mt-10">
                <div class="verify-btn">
                    <!-- <VCol cols="4" offset-md="4"> -->
                        <VBtn color="#16cab6" @click="login" class="text-white pppangram-bold" size="55" block>Login your account</VBtn>
                    <!-- </VCol> -->
                </div>
            </div>
        </div>
    </div>
    <Plan v-model:form="form" :plans="props.plans" v-else></Plan>
</template>

<style lang="scss">
@use "@styles/@core/template/pages/page-auth.scss";
.regiser-image {
    //   background: url("/public/images/signupnew.png") 100% no-repeat;
    height: 100vh;
    background-size: cover;
}

.thankyou{
    color: #000 !important;
    font-size: 40px !important;
}

.margin-verify{
    margin-top: 10%;
}

.verify-btn{
    width: 30%;
    height: 10vh;
}

.verify-description{
    font-size: 25px !important;
    line-height: 1.5 !important;
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

.sign-up-as {
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
