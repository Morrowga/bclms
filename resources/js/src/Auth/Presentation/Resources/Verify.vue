<template>
  <FrontendLayout :route="{ name: route('login'), label: 'Login' }">
    <div class="verify-bg">
      <div class="container mr-auto">
        <div class="w-80 m-auto">
          <h1 v-if="verified" class="text-2xl font-bold text-justify mb-10">
            Email is successfully verified!
          </h1>
          <h1 v-else class="text-2xl font-bold text-justify mb-10">
            Welcome to Ed+. Please verify your email account to proceed
          </h1>
          <!-- <a href="/" class="pl-20  underline decoration-1 mt-32 ">Email account verify</a> -->

          <Link :href="route('portal')" class="pl-auto">
            <Button label="Back" icon="pi pi-arrow-left" />
          </Link>
        </div>
      </div>
    </div>
  </FrontendLayout>
</template>

<script setup>
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import Button from "primevue/button";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, defineProps, onMounted, watch } from "vue";
import { useToast } from "primevue/usetoast";
let props = defineProps(["verified", "flash"]);
let toast = useToast();
onMounted(() => {
  if (props?.flash?.successMessage) {
    toast.add({
      severity: "success",
      summary: "Verified!",
      detail: props?.flash?.successMessage,
      life: 3000,
    });
  }
});
</script>
<style scoped>
.verify-bg {
  background: url("/public/images/LoginPage.svg") no-repeat;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>