<script setup>
import { VForm } from "vuetify/components";
import { themeConfig } from "@themeConfig";
import { emailValidator, requiredValidator } from "@validators";
import {useForm,Link} from "@inertiajs/inertia-vue3"
const isPasswordVisible = ref(false);
const refVForm = ref()
let form = useForm({
  email: "",
  password: "",
});
const rememberMe = ref(false);

const onSubmit = () => {
   form.post(route("login"), {
    onSuccess: () => {},
    onError: (error) => {

    },
  });
};


</script>

<template>
  <div class="auth-logo d-flex align-center gap-x-2">
    <h5 class="text-h5 font-weight-bold leading-normal text-capitalize">
      {{ themeConfig.app.title }}
    </h5>
  </div>
  <div class="bg-image">
  <VRow no-gutters class="auth-wrapper  d-flex justify-center align-center" style="height:100vh;">
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
          <VForm   @submit.prevent="onSubmit">
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <label-input>Enter your work email</label-input>
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
                <label-input>Enter your password</label-input>
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
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <div
                  class="d-flex align-center flex-wrap justify-space-between mt-1 mb-4"
                >
                  <VCheckbox v-model="rememberMe" label="Remember me" />

                </div>

                <VBtn block type="submit"> Login </VBtn>
              </VCol>

              <!-- create account -->
              <VCol cols="12" class="text-base text-center">
                <span>New on our platform?</span>
                <Link
                  class="text-primary ms-2"
                  :href='register'
                >
                  Create an account
                </Link>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </div>
    </VCol>
  </VRow>
  </div>
</template>

<style lang="scss">
@use "@styles/@core/template/pages/page-auth.scss";

.bg-image{
    padding: 0 !important;
    margin: 0 !important;
    background: url('images/LoginPage.svg');
    object-fit: cover;
}

</style>


