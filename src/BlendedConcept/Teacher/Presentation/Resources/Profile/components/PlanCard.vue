<script setup>
import { defineProps } from "vue";
const planData = defineProps(["plandata"]);

import PaymentForm from "./PaymentForm.vue";
</script>

<template>
    <VCard class="" color="#F6F6F6">
        <VCardText class="d-flex flex-column">
            <VBtn color="primary" size="50" class="mb-4 mx-auto">
                <VIcon icon="mdi-wallet" size="30"></VIcon>
            </VBtn>

            <h6 class="plan-title text-center text-text fs-bold fs-20">
                {{ planData.plandata.plan_type }}
            </h6>
            <ul class="justify-self-start">
                <li>Lorem ipsum</li>
                <li>Lorem ipsum</li>
                <li>Lorem ipsum</li>
                <li>Lorem ipsum</li>
                <li>Lorem ipsum</li>
            </ul>
        </VCardText>

        <VCardText> </VCardText>

        <VCardActions class="justify-center">
            <VBtn color="sun-yellow" variant="flat" rounded>
                <span class="text-white">
                    $ {{ planData.plandata.pay_amount }} / month</span
                >
            </VBtn>
        </VCardActions>
    </VCard>
</template>

<style scoped>
ul {
    list-style: disc;
}

.plan-title {
    color: #161616 !important;
    font-size: 36px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 44px !important;
    text-transform: capitalize !important;
}
</style>
