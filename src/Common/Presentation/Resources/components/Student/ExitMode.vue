<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["route", "count", "label"]);
const isDialogVisible = ref(false)
let passwordVisible = ref(false);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value;
}

</script>
<template #activator="{ props }">
    <v-btn  @click="isDialogVisible = true"
        varient="flat"
        color="#BFC0C1"
        class="textcolor w-100 pppangram-bold"
        rounded
    >
        Exit Kids Mode
    </v-btn>
    <VDialog
        v-model="isDialogVisible"
        width="500"
    >
        <!-- Activator -->
        <!-- Dialog Content -->
        <VCard class="rolling-card">
        <VCardText>
            <div class="text-center mt-15">
                <span class="password-label pppangram-bold">Enter Password</span>
                <div class="passwordinput-container mt-3 mx-15">
                    <VTextField v-bind:type="passwordVisible ? 'text' : 'password'" class="mt-3 passwordinput mx-5" placeholder="Password"/>
                    <span class="toggle-password" v-on:click="togglePasswordVisibility">
                        <VIcon
                        :icon="passwordVisible ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                        />
                    </span>
                </div>
            </div>

            <div class="d-flex justify-center mt-15">
                <v-btn
                    varient="flat"
                    color="#D7F2F0"
                    class="pppangram-bold mr-3 confirmbtn"
                >
                    Confirm
            </v-btn>
            <v-btn  @click="isDialogVisible = false"
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
    </VDialog>
</template>
<style scoped>
.cancelbtn{
    width: 150px !important;
    height: 50px !important;
    color: #fff;
}
/* .passwordinput{
    width: 80%px !important;
} */
.confirmbtn{
    width: 150px !important;
    height: 50px !important;
    color: #17CAB6;
}

.password-label{
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
