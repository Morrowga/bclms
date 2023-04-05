<script setup>
import { VForm } from "vuetify/components";
import { useGenerateImageVariant } from "@/@core/composable/useGenerateImageVariant";
import { useAppAbility } from "@/plugins/casl/useAppAbility";
import AuthProvider from "@/views/pages/authentication/AuthProvider.vue";
import axios from "@axios";
import authV2LoginIllustrationBorderedDark from "@images/pages/auth-v2-login-illustration-bordered-dark.png";
import authV2LoginIllustrationBorderedLight from "@images/pages/auth-v2-login-illustration-bordered-light.png";
import authV2LoginIllustrationDark from "@images/pages/auth-v2-login-illustration-dark.png";
import authV2LoginIllustrationLight from "@images/pages/auth-v2-login-illustration-light.png";
import authV2LoginMaskDark from "@images/pages/auth-v2-login-mask-dark.png";
import authV2LoginMaskLight from "@images/pages/auth-v2-login-mask-light.png";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { themeConfig } from "@themeConfig";
import { emailValidator, requiredValidator } from "@validators";
import {useForm} from "@inertiajs/inertia-vue3"
const isPasswordVisible = ref(false);
const authV2LoginMask = useGenerateImageVariant(
  authV2LoginMaskLight,
  authV2LoginMaskDark
);



const ability = useAppAbility();

const errors = ref({
  email: undefined,
  password: undefined,
});

const refVForm = ref();
let form = useForm({
  email: "",
  password: "",
});
const rememberMe = ref(false);

const login = () => {

   form.post(route("login"), form, {
    onSuccess: () => {},
    onError: (error) => {
      const { errors: formErrors } = e.response.data;
      errors.value = formErrors;
      console.error(e.response.data);
    },
  });
};

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) login();
  });
};
</script>

<template>
  <div class="auth-logo d-flex align-center gap-x-2">
    <div>
      <VNodeRenderer :nodes="themeConfig.app.logo" />
    </div>

    <h5 class="text-h5 font-weight-bold leading-normal text-capitalize">
      {{ themeConfig.app.title }}
    </h5>
  </div>
  <VRow no-gutters class="auth-wrapper  d-flex justify-center align-center bg-image" style="height:100vh;">
    <VCol
      cols="12"
      md="4"
      class="auth-card-v2 d-flex align-center justify-center"
      style="background-color: rgb(var(--v-theme-surface))"
    >
      <div :max-width="500" class="mt-12 mt-sm-0 pa-4">
        <VCardText>
          <h5 class="text-h5 text-center text-primary font-weight-semibold mb-1">
           Enter your email address
          </h5>

        </VCardText>
        <VCardText>
          <VForm ref="refVForm" @submit.prevent="onSubmit">
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <label-input>Enter your work email</label-input>
                <VTextField
                  v-model="form.email"
                  type="email"
                  class="bg-primary"
                  :rules="[requiredValidator, emailValidator]"
                  :error-messages="errors.email"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <label-input>Enter your password</label-input>
                <VTextField
                  v-model="form.password"
                  :rules="[requiredValidator]"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :error-messages="errors.password"
                  :append-inner-icon="
                    isPasswordVisible
                      ? 'mdi-eye-off-outline'
                      : 'mdi-eye-outline'
                  "
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <div
                  class="d-flex align-center flex-wrap justify-space-between mt-1 mb-4"
                >
                  <VCheckbox v-model="rememberMe" label="Remember me" />
                  <RouterLink
                    class="text-primary ms-2 mb-1"
                    :to="{ name: 'forgot-password' }"
                  >
                    Forgot Password?
                  </RouterLink>
                </div>

                <VBtn block type="submit"> Login </VBtn>
              </VCol>

              <!-- create account -->
              <VCol cols="12" class="text-base text-center">
                <span>New on our platform?</span>
                <RouterLink
                  class="text-primary ms-2"
                  :to="{ name: 'register' }"
                >
                  Create an account
                </RouterLink>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </div>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@styles/@core/template/pages/page-auth.scss";

.bg-image{
    background: url('images/LoginPage.svg');
    object-fit: cover;
}

</style>


