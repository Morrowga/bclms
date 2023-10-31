<script setup>
import { themeConfig } from "@themeConfig";
import { onMounted, ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { toastAlert } from "@Composables/useToastAlert";
import Plan from "./Plan.vue";
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
const checkExist = ref('none');

const studentCode = ref(null);
const isFormValid = ref(false);
const isRegisterFormFilled = ref(false);
const didChoose = ref(false);
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
    student_code: studentCode.value
});

const goPlan = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            isRegisterFormFilled.value = true;
        }
    });
};

const radioClick = (type) => {
    selectedUserType.value = type;
    form.user_type = type;
};


watch(studentCode, (newVal) => {
  if (newVal.length === 6) {
    fetchDataFromServer(newVal);
  } else {
    checkExist.value = 'none';
  }
});

async function fetchDataFromServer(value) {
    try {
        const response = await axios.get(
            `/search-student-code?student_code=${value}`
        );

        checkExist.value = response.data.exist
        form.email = response.data.parent.user.email;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

const goToRegisterForm = (type) => {
    form.student_code = studentCode.value
    if(type == 'teacher'){
        form.user_type = 'Teacher'
        didChoose.value = true;
    } else {
        form.user_type = 'Parent'
        if(checkExist.value == true){
            didChoose.value = true;
            isRegisterFormFilled.value = true;
        } else {
            didChoose.value = true;
        }
    }
}
</script>

<template>
    <div v-if="!didChoose">
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
            <VContainer>
                <VRow class="mt-10 mx-15">
                    <VCol cols="6">
                        <VCard>
                            <VCardText class="text-left">
                                <h1 class="pppangram-bold">Teacher</h1>

                                <div class="mt-5">
                                    <span class="signuptext">Sign up to access a world of educational resources and <br>
                                        enhance your teaching experience for your students with <br>
                                        our many exciting features.
                                        <br>
                                        <br>
                                        Join us to make a difference in the classroom!
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    </span>
                                </div>

                                <VBtn variant="flat" @click="goToRegisterForm('teacher')" class="mt-13" rounded>Sign Up</VBtn>
                            </VCardText>
                        </VCard>
                    </VCol>
                    <VCol cols="6">
                        <VCard>
                            <VCardText class="text-left">
                                <h1 class="pppangram-bold">Parent</h1>

                                <div class="mt-5">
                                    <span class="signuptext">Sign up to access a world of educational resources and <br>
                                        support for your child.Plus,if you have your <br>
                                        organisation's student code,you can enjoy exclusive <br>
                                        discounts on our services and monitor your child's <br>
                                        progress within the organization.
                                        <br>
                                        <br>
                                    </span>
                                    <span class="ppangram-bold color-black"
                                        >Do you have a student code ?</span>
                                    <VTextField
                                        class="mt-3 custom-label-student-code"
                                        density="compact"
                                        placeholder="Student / Promotion Code ( optional )"
                                        variant="solo"
                                        v-model="studentCode"
                                    >
                                        <template v-if="studentCode != ''" #append-inner>
                                            <VIcon icon="mdi-check-circle" v-if="checkExist == true" class="check-circle mt-1"></VIcon>
                                            <VIcon icon="mdi-close-circle" v-if="checkExist == false" class="check-false mt-1"></VIcon>
                                        </template>
                                    </VTextField>
                                </div>

                                <VBtn variant="flat" @click="goToRegisterForm('parent')" class="mt-6" rounded>Sign Up</VBtn>
                            </VCardText>
                        </VCard>
                    </VCol>
                </VRow>
            </VContainer>
        </div>


    </div>
    <div v-else>
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
                                            :error-messages="
                                                form?.errors?.first_name
                                            "
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
                                            :error-messages="
                                                form?.errors?.last_name
                                            "
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
                            <!-- <div class="d-flex justify-start">
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
                            </div> -->
                            <div class="my-3 d-flex align-center">
                                <v-checkbox></v-checkbox>
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
        <Plan v-model:form="form" :plans="props.plans" v-else></Plan>
    </div>
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

.sign-up-as {
    padding: 10px;
}

.signuptext{
    color: rgb(0,0,0,0.6) !important;
}

.custom-label-color .v-label {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}

.custom-label-student-code {
    color: #000; /* Change the label color to red */
    font-size: 15px !important;
}
.check-circle{
    color: green;
}

.check-false{
    color: red;
}

.color-black{
    color: #000 !important;
}
</style>
