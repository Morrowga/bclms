<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";
import Plan from "./Plan.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import axios from "axios";
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
const checkExist = ref("none");
const gender = ref(["Male", "Female"]);
const isDoneRegister = ref(false);
const studentCode = ref(null);
const isFormValid = ref(false);
const isRegisterFormFilled = ref(false);
const didChoose = ref(true);
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
    plan_price: "0.00",
    password: "",
    password_confirmation: "",
    user_type: "Teacher",
    student_code: studentCode.value,
    child_first_name: "",
    child_last_name: "",
    child_gender: "",
    child_dob: "",
    child_education_level: ""
});

const goChildRegister = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            isRegisterFormFilled.value = true;
        }
    });
};

const  register = () => {
    if(form.child_first_name == "" || form.child_first_name == ""){
        isRegisterFormFilled.value = true;
    } else {
        form.post(route("choose-free-plan"), {
            onSuccess: () => {
                isDoneRegister.value = true;
            },
        });
    }
}

const resend = () => {
    form.post(route("resend"), {
        onSuccess: () => {
            // router.get(route("login"));
        },
    });
};

const closeAndLogin = () => {
    isDoneRegister.value = false;
    router.get(route("login"));
};

const radioClick = (type) => {
    selectedUserType.value = type;
    form.user_type = type;
};

watch(studentCode, (newVal) => {
    if (newVal.length === 6) {
        fetchDataFromServer(newVal);
    } else {
        if (newVal.length > 6) {
            checkExist.value = false;
        } else {
            checkExist.value = "none";
        }
    }
});

async function fetchDataFromServer(value) {
    try {
        const response = await axios.get(
            `/search-student-code?student_code=${value}`
        );

        checkExist.value = response.data.exist;

        if (!checkExist.value) {
            studentCode.value = null;
        } else {
            form.email = response.data.parent.user.email;
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

// const goToRegisterForm = (type) => {
//     form.student_code = studentCode.value == "" ? null : studentCode.value;
//     if (type == "teacher") {
//         form.user_type = "Teacher";
//         didChoose.value = true;
//     } else {
//         form.user_type = "Parent";
//         if (checkExist.value == true) {
//             didChoose.value = true;
//             isRegisterFormFilled.value = true;
//         } else {
//             didChoose.value = true;
//         }
//     }
// };
</script>

<template>
    <!-- <div v-if="!didChoose" class="register-image">
        <div class="layout-navbar">
            <div
                class="navbar-content-container px-10 py-5"
            >
                <div>
                    <v-img src="images/logoblack.png" width="200" height="50"></v-img>
                </div>
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

        <div class="mx-15 my-3 d-flex justify-start">
            <span class="font-weight-bold pppangram-bold">Home <VIcon icon="mdi-chevron-right" color="#94908f" class="font-weight-bold pppangram-bold"></VIcon> <strong class="text-blue font-weight-bold">Sign Up</strong></span>
        </div>

        <VRow>
            <VCol cols="6">

            </VCol>
        </VRow>

        <div class="text-center mt-10">
            <p class="ruddy-bold signup-title">Sign Up For B2C Account</p>
            <VContainer>
                <VRow class="mt-10 mx-15">
                    <VCol cols="6">
                        <VCard>
                            <VCardText class="text-left">
                                <h1 class="pppangram-bold">Teacher</h1>

                                <div class="mt-5">
                                    <span class="signuptext"
                                        >Sign up to access a world of
                                        educational resources and <br />
                                        enhance your teaching experience for
                                        your students with <br />
                                        our many exciting features.
                                        <br />
                                        <br />
                                        Join us to make a difference in the
                                        classroom!
                                    </span>
                                </div>

                                <VBtn
                                    variant="flat"
                                    @click="goToRegisterForm('teacher')"
                                    class="mt-13"
                                    rounded
                                    >Sign Up</VBtn
                                >
                            </VCardText>
                        </VCard>
                    </VCol>
                    <VCol cols="6">
                        <VCard>
                            <VCardText class="text-left">
                                <h1 class="pppangram-bold">Parent</h1>

                                <div class="mt-5">
                                    <span class="signuptext"
                                        >Sign up to access a world of
                                        educational resources and <br />
                                        support for your child.Plus,if you have
                                        your <br />
                                        organisation's student code,you can
                                        enjoy exclusive <br />
                                        discounts on our services and monitor
                                        your child's <br />
                                        progress within the organization.
                                        <br />
                                        <br />
                                    </span>
                                </div>

                                <VBtn
                                    variant="flat"
                                    @click="goToRegisterForm('parent')"
                                    class="mt-6"
                                    rounded
                                    >Sign Up</VBtn
                                >
                            </VCardText>
                        </VCard>
                    </VCol>
                </VRow>
            </VContainer>
        </div>
    </div> -->
    <div class="register-container">
        <img src="images/signup-v3.png" alt="Snow" style="width:100%; height: auto !important;">
        <div class="top-left">
            <div>
                <div>
                    <div class="layout-navbar">
                        <div
                            class="navbar-content-container px-10 py-5"
                        >
                            <div>
                                <v-img src="images/logoblack.png" width="200" height="50"></v-img>
                            </div>
                        </div>
                    </div>
                    <SystemErrorAlert
                        :sytemErrorMessage="sytemErrorMessage"
                        v-if="sytemErrorMessage"
                    />

                    <VDivider></VDivider>

                    <div class="mx-15 my-3 d-flex justify-start">
                        <span class="font-weight-bold pppangram-bold">Home <VIcon icon="mdi-chevron-right" color="#94908f" class="font-weight-bold pppangram-bold"></VIcon> <strong class="text-blue font-weight-bold">Sign Up</strong></span>
                    </div>
                    <VRow class="d-flex justify-start">
                        <VCol cols="8">
                            <div class="text-center mt-10 form-container">
                                <VForm
                                    ref="refForm"
                                    v-model="isFormValid"
                                    @submit.prevent="register"
                                >
                                    <VRow class="mt-5">
                                        <VCol cols="3"> </VCol>
                                        <VCol cols="6" class="text-left">
                                            <div class="form-border">
                                                <div class="py-5" v-if="!isRegisterFormFilled">
                                                    <VRow>
                                                        <VCol cols="6">
                                                            <div>
                                                                <!-- <VLabel class="required"
                                                                    >First Name</VLabel
                                                                > -->
                                                                <VTextField
                                                                    class="mt-3 custom-label-color"
                                                                    placeholder=""
                                                                    label="First Name"
                                                                    density="compact"
                                                                    variant="solo"
                                                                    v-model="form.first_name"
                                                                    :rules="[requiredValidator]"
                                                                    :error-messages="
                                                                        form?.errors?.first_name
                                                                    "
                                                                />
                                                            </div>
                                                        </VCol>
                                                        <VCol size="6">
                                                            <div>
                                                                <!-- <VLabel class="required"
                                                                    >Last Name</VLabel
                                                                > -->
                                                                <VTextField
                                                                    class="mt-3 custom-label-color"
                                                                    placeholder=""
                                                                    label="Last Name"
                                                                    density="compact"
                                                                    variant="solo"
                                                                    v-model="form.last_name"
                                                                    :rules="[requiredValidator]"
                                                                    :error-messages="
                                                                        form?.errors?.last_name
                                                                    "
                                                                />
                                                            </div>
                                                        </VCol>
                                                    </VRow>
                                                    <div class="mt-4">
                                                        <!-- <VLabel class="required">Email</VLabel> -->
                                                        <VTextField
                                                            class="my-3 custom-label-color"
                                                            placeholder=""
                                                            density="compact"
                                                            label="Email"
                                                            variant="solo"
                                                            v-model="form.email"
                                                            :rules="[requiredValidator]"
                                                            :error-messages="form?.errors?.email"
                                                        />
                                                    </div>
                                                    <div>
                                                        <!-- <VLabel class="required">Contact Number</VLabel> -->
                                                        <VTextField
                                                            class="my-3 custom-label-color"
                                                            placeholder=""
                                                            label="Contact Number"
                                                            density="compact"
                                                            type="number"
                                                            variant="solo"
                                                            v-model="form.contact_number"
                                                            :rules="[requiredValidator]"
                                                            :error-messages="
                                                                form?.errors?.contact_number
                                                            "
                                                        />
                                                    </div>
                                                    <div>
                                                        <!-- <VLabel class="required">Password</VLabel> -->
                                                        <VTextField
                                                            class="my-3 custom-label-color"
                                                            placeholder=""
                                                            density="compact"
                                                            variant="solo"
                                                            label="Password"
                                                            :type="
                                                                isPasswordVisible ? 'text' : 'password'
                                                            "
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
                                                        <!-- <VLabel class="required"
                                                            >Confirm Password</VLabel
                                                        > -->
                                                        <VTextField
                                                            class="my-3 custom-label-color"
                                                            placeholder=""
                                                            label="Confirm Password"
                                                            :type="
                                                                isPasswordVisible ? 'text' : 'password'
                                                            "
                                                            :append-inner-icon="
                                                                isPasswordVisible
                                                                    ? 'mdi-eye-off-outline'
                                                                    : 'mdi-eye-outline'
                                                            "
                                                            @click:append-inner="
                                                                isPasswordVisible = !isPasswordVisible
                                                            "
                                                            density="compact"
                                                            variant="solo"
                                                            v-model="form.password_confirmation"
                                                            :rules="[
                                                                requiredValidator,
                                                                confirmedValidator(
                                                                    form.password_confirmation,
                                                                    form.password
                                                                ),
                                                            ]"
                                                            :error-messages="
                                                                form?.errors?.password_confirmation
                                                            "
                                                        />
                                                    </div>
                                                    <VBtn
                                                        block
                                                        type="submit"
                                                        variant="flat"
                                                        class="primary my-3"
                                                        rounded
                                                    >
                                                        Next
                                                    </VBtn>
                                                </div>
                                                <div class="py-5" v-else>
                                                    <h3 class="pppangram-bold text-dark">Child Information</h3>
                                                    <VRow>
                                                        <VCol cols="6">
                                                            <div>
                                                                <VTextField
                                                                    class="mt-3 custom-label-color"
                                                                    placeholder=""
                                                                    label="First Name"
                                                                    density="compact"
                                                                    variant="solo"
                                                                    v-model="form.child_first_name"
                                                                    :rules="[requiredValidator]"
                                                                    :error-messages="
                                                                        form?.errors?.child_first_name
                                                                    "
                                                                />
                                                            </div>
                                                        </VCol>
                                                        <VCol size="6">
                                                            <div>
                                                                <VTextField
                                                                    class="mt-3 custom-label-color"
                                                                    placeholder=""
                                                                    label="Last Name"
                                                                    density="compact"
                                                                    variant="solo"
                                                                    v-model="form.child_last_name"
                                                                    :rules="[requiredValidator]"
                                                                    :error-messages="
                                                                        form?.errors?.child_last_name
                                                                    "
                                                                />
                                                            </div>
                                                        </VCol>
                                                    </VRow>
                                                    <div class="mt-5">
                                                        <v-select
                                                            label="Gender"
                                                            class="select-custom"
                                                            v-model="form.child_gender"
                                                            :items="gender"
                                                            variant="outlined"
                                                            :rules="[requiredValidator]"
                                                            :error-messages="form?.errors?.chil_gender"
                                                        />
                                                    </div>
                                                    <div class="mt-7">
                                                        <AppDateTimePicker
                                                            label="Date Of Birth"
                                                            v-model="form.child_dob"
                                                            :rules="[requiredValidator]"
                                                            :error-messages="form?.errors?.child_dob"
                                                            density="compact"
                                                            :config="{
                                                                minDate: null,
                                                                maxDate: 'today',
                                                            }"
                                                        />
                                                    </div>
                                                    <div class="mt-4">
                                                        <VTextField
                                                            class="mt-3 custom-label-color"
                                                            placeholder=""
                                                            label="Education Level"
                                                            density="compact"
                                                            variant="solo"
                                                            v-model="form.child_education_level"
                                                            :rules="[requiredValidator]"
                                                            :error-messages="
                                                                form?.errors?.child_education_level
                                                            "
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-start">
                                                        <div class="sign-up-as">
                                                            <span>Sign up as </span>
                                                        </div>
                                                        <VRadio
                                                            v-model="selectedUserType"
                                                            name="type"
                                                            label="Teacher"
                                                            :value="'Teacher'"
                                                            @click="radioClick('Teacher')"
                                                        ></VRadio>
                                                        <VRadio
                                                            v-model="selectedUserType"
                                                            name="type"
                                                            @click="radioClick('Parent')"
                                                            :value="'Parent'"
                                                            label="Parent"
                                                        ></VRadio>
                                                    </div>
                                                    <div class="my-3 d-flex align-center">
                                                        <v-checkbox
                                                            class="custom-checkbox"
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
                                                </div>
                                            </div>
                                        </VCol>
                                        <VCol cols="3"> </VCol>
                                    </VRow>
                                </VForm>
                                <div class="sign-up-title-div">
                                    <p class="pppangram-bold signup-title px-5">Sign Up</p>
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <VDialog v-model="isDoneRegister" width="50%">
                    <VCard class="pa-16">
                        <div class="text-end">
                            <VBtn
                                color="secondary"
                                variant="text"
                                @click="isDoneRegister = false"
                                icon
                            >
                                <VIcon>mdi-close</VIcon>
                            </VBtn>
                        </div>

                        <VCardSubtitle class="text-center">
                            <span class="pppangram-bold head-signup"
                                >Thank You For Signing Up!</span
                            >
                            <p class="mt-4">
                                We've sent a verification email to
                                <Link href="">{{ form.email }}</Link> to verify your
                                email address and <br />
                                activate your account. The link is your email will
                                expire in 24 hours.
                            </p>
                        </VCardSubtitle>

                        <VCardActions class="mt-10">
                            <VRow justify="center">
                                <VCol cols="5">
                                    <SecondaryBtn
                                        type="button"
                                        @click="closeAndLogin"
                                        title="Close"
                                    />
                                </VCol>
                                <VCol cols="5">
                                    <PrimaryBtn
                                        @click="resend"
                                        :isLink="false"
                                        type="button"
                                        title="Resend Email"
                                    />
                                </VCol>
                            </VRow>
                        </VCardActions>
                    </VCard>
                </VDialog>
                <!-- <Plan v-model:form="form" :plans="props.plans" v-else></Plan> -->
            </div>
        </div>
    </div>

</template>

<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";
// .register-image {
//     background: url("images/signup-v3.png") 100% no-repeat;
//     height: 100vh;
//     background-position: top;
//     background-size: cover;
// }
.top-left {
  position: absolute;
  top: 8px;
  width: 100%;
  left: 16px;
}

.register-container {
  position: relative;
}

.text-blue{
    color: #4965dc;
}

.sign-up-title-div{
    position: absolute;
    top: 4%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.signup-title {
    color: var(--Text, #161616);
    background: #f6f6f6;
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

.form-container{
    position: relative;
}

.signuptext {
    color: rgb(0, 0, 0, 0.6) !important;
}

.custom-label-color .v-label {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}

:deep(.select-custom > .v-input__control){
    border-radius: 10px;
}

:deep(.custom-label-color > .v-input__control){
    border: 2px solid #000 !important;
    border-radius: 10px;
}

.custom-label-student-code {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}
.check-circle {
    color: green;
}

.check-false {
    color: red;
}

.color-black {
    color: #000 !important;
}
:deep(.v-field-label--floating::after){
    content: '*';
    color: var(--candy-red, #FF6262) !important;
    /* Body Style Small */
    padding-left: 5px;
    font-family: PP Pangram Sans;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: 26px;
}

:deep(.v-field-label--floating){
    color: #000 !important;
}

:deep(.v-input__slot::before) {
    border-style: none !important;
}

.form-border{
    border: 3px solid #000;
    border-radius: 20px;
    padding: 20px;
}

:deep(.v-messages__message){
    color: red !important;
}

.head-signup {
    font-size: 20px !important;
    color: #000;
}
</style>
