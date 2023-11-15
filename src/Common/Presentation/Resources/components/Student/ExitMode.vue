<script setup>
import { router } from "@inertiajs/core";
import { usePage, useForm } from "@inertiajs/vue3";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import LogoutUserExperienceSurvey from "../../../../../BlendedConcept/System/Presentation/Resources/Student/components/LogoutUserExperienceSurvey.vue";

let props = defineProps(["route", "count", "teacher_id", "student_id"]);

const page = usePage();
let user_survey_logout = computed(() => page?.props?.user_survey_logout);

const isDialogVisible = ref(false);
const hasSurvey = ref(false);
let passwordVisible = ref(false);

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
};

const form = useForm({
    password: null,
    student_id: props.student_id,
    user_id: props.teacher_id,
});

const checkSurvey = () => {
    if (user_survey_logout.value != "") {
        hasSurvey.value = true;
    } else {
        isDialogVisible.value = true;
    }
};

const getCookie = (name) => {
    const cookies = document.cookie.split("; ");
    for (const cookie of cookies) {
        const [cookieName, cookieValue] = cookie.split("=");
        if (cookieName === name) {
            return cookieValue;
        }
    }
    return null;
};

const cookieValue = getCookie("kidmode");
// console.log(props.teacher_id);

const logout = () => {
    form.post(route("teacher_students.exitmode"), {
        onSuccess: () => {},
        onError: (error) => {},
    });
};

// console.log(cookieValue);
</script>
<template #activator="{ props }">
    <div>
        <v-btn
            @click="checkSurvey"
            varient="flat"
            color="#BFC0C1"
            class="textcolor w-100 pppangram-bold"
            rounded
        >
            {{ cookieValue == 1 ? "Exit Kids Mode" : "Log Out" }}
        </v-btn>
        <VDialog v-model="isDialogVisible" width="500">
            <VForm @submit.prevent="logout()">
                <VCard class="rolling-card">
                    <VCardText>
                        <div class="text-center mt-15">
                            <span class="password-label pppangram-bold"
                                >Enter Password</span
                            >
                            <div class="passwordinput-container mt-3 mx-15">
                                <VTextField
                                    v-model="form.password"
                                    v-bind:type="
                                        passwordVisible ? 'text' : 'password'
                                    "
                                    class="mt-3 passwordinput mx-5"
                                    placeholder="Password"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.password"
                                />
                                <span
                                    class="toggle-password"
                                    v-on:click="togglePasswordVisibility"
                                >
                                    <VIcon
                                        :icon="
                                            passwordVisible
                                                ? 'mdi-eye-off-outline'
                                                : 'mdi-eye-outline'
                                        "
                                    />
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-center mt-15">
                            <v-btn
                                type="submit"
                                varient="flat"
                                color="#D7F2F0"
                                class="pppangram-bold mr-3 confirmbtn"
                            >
                                Confirm
                            </v-btn>
                            <v-btn
                                @click="isDialogVisible = false"
                                varient="flat"
                                color="#BFC0C1"
                                class="pppangram-bold ml-5 cancelbtn"
                            >
                                Cancel
                            </v-btn>
                        </div>
                    </VCardText>
                    <!-- <VCardActions>
                <VSpacer />
                <VBtn @click="isDialogVisible = false">
                I accept
                </VBtn>
            </VCardActions> -->
                </VCard>
            </VForm>
        </VDialog>
        <LogoutUserExperienceSurvey
            v-model:hasSurvey="hasSurvey"
            v-model:isDialogVisible="isDialogVisible"
            :data="user_survey_logout"
        />
    </div>
</template>
<style scoped>
.cancelbtn {
    width: 150px !important;
    height: 50px !important;
    color: #fff;
}
/* .passwordinput{
    width: 80%px !important;
} */
.confirmbtn {
    width: 150px !important;
    height: 50px !important;
    color: #17cab6;
}

.password-label {
    color: var(--graphite, #282828) !important;
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 38px !important; /* 158.333% */
}

.password-input-container {
    text-align: center;
    margin-top: 15px;
}

.password-label {
    display: block;
    font-weight: bold;
}

.password-input-wrapper {
    position: relative;
    margin-top: 10px;
}

.password-input {
    padding-right: 40px; /* Space for the icon */
    width: 100%;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 24%;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>
