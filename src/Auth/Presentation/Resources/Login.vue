<script setup>
import { VForm } from "vuetify/components";
import { themeConfig } from "@themeConfig";
import { emailValidator, requiredValidator } from "@validators";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";
const isPasswordVisible = ref(false);
// toast
import { toastAlert } from "../../../Common/Layouts/Composables/useToastAlert";
const rememberMe = ref(false);
// recevied error message
let errorMessage = defineProps(['errorMessage'])

let form = useForm({
  email: "",
  password: "",
});
const onSubmit = () => {
  form.post(route("login-post"), {
    onSuccess: () => {},
    onError: (error) => {
      console.log(error,'hello world')
      toastAlert({
          title:errorMessage.value,
          icon: "error",
          bgColor: "red",
          textColor: "white",
          iconColor: "white",
        });
    },
  });
};
</script>
<template>
  <div class="container">
    <div class="layout-navbar">
        <div class="navbar-content-container d-flex justify-space-between px-10 py-5">
        <h1 class="text-h5 font-weight-bold leading-normal text-capitalize">  {{ themeConfig.app.title }}</h1>
        <VBtn color="primary" class="b-0 text-white">
        <Link :href="route('register')" class="text-white">
         Register
        </Link>
       </VBtn>
        </div>
      </div>
      <VDivider></VDivider>
    <div class="login-bg">
      <VRow
        no-gutters
        class="auth-wrapper d-flex justify-center align-center"
        style="height: 100vh"
      >
        <VCol
          cols="12"
          md="4"
          class="auth-card-v2 d-flex align-center justify-center"
          style="background-color: rgb(var(--v-theme-surface))"
        >
          <div :max-width="500" class="mt-12 mt-sm-0 pa-4">
            <VCardText>
              <h5 class="text-h4 text-center font-weight-semibold mb-1 primary">
                Enter your email address
              </h5>
            </VCardText>
            <VCardText>
              <VForm @submit.prevent="onSubmit">
                <VRow>
                  <!-- email -->
                  <VCol cols="12">
                    <label-input class="primary"
                      >Enter your work email</label-input
                    >
                    <VTextField
                      v-model="form.email"
                      type="email"
                      class="bg-primary"
                      :rules="[requiredValidator, emailValidator]"
                      :error-messages="form?.errors?.email"
                    />
                  </VCol>
                  <!-- password -->
                  <VCol cols="12">
                    <label-input class="primary"
                      >Enter your password</label-input
                    >
                    <VTextField
                      v-model="form.password"
                      :rules="[requiredValidator]"
                      :type="isPasswordVisible ? 'text' : 'password'"
                      :error-messages="form?.errors?.password"
                      :append-inner-icon="
                        isPasswordVisible
                          ? 'mdi-eye-off-outline'
                          : 'mdi-eye-outline'
                      "
                      @click:append-inner="
                        isPasswordVisible = !isPasswordVisible
                      "
                    />
                    <div
                      class="d-flex align-center flex-wrap justify-space-between mt-1 mb-4"
                    >
                      <VCheckbox v-model="rememberMe" label="Remember me" />
                    </div>
                    <VBtn block class="bg-primary" type="submit"> Login </VBtn>
                  </VCol>
                  <!-- create account -->
                  <VCol cols="12" class="text-base text-center primary">
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
      </VRow>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@use "@styles/@core/template/pages/page-auth.scss";
.login-bg {
  background: url("/public/images/register.png") 100% no-repeat;
  height: 100%;
  background-size: 100% 100%;
}
.primary {
  color: #001a8f !important;
}
.v-text-field,
.v-text-field input {
  background-color: white !important;
}
</style>
