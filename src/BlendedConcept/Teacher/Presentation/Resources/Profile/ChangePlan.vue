<script setup>
const isDialogVisible = ref(false)
import PlanCard from "./components/PlanCard.vue"
import PaymentForm from "./components/PaymentForm.vue";
</script>

<template>
    <VDialog v-model="isDialogVisible" width="80%">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" color="orange" variant='flat' rounded>
                Change Plan
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard>
            <VCardText>
                <h1 class="text-center plan-title mb-4">Plans</h1>
                <VRow>
                    <VCol cols="3">
                        <PlanCard :plandata="{
                            plan_type: 'Free',
                            pay_amount: '0.0'
                        }" />
                    </VCol>
                    <VCol cols="3">
                        <PlanCard :plandata="{
                            plan_type: 'Base',
                            pay_amount: '0.0'
                        }" />
                    </VCol>
                    <VCol cols="3">
                        <PlanCard :plandata="{
                            plan_type: 'Pro',
                            pay_amount: '0.0'
                        }" />
                    </VCol>
                    <VCol cols="3">
                        <PlanCard :plandata="{
                            plan_type: 'Set up your wallet',
                            pay_amount: '0.0'
                        }" />
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="3">
                        <PaymentForm/>
                    </VCol>
                </VRow>

            </VCardText>
            <VCardActions>
            </VCardActions>
        </VCard>
    </VDialog>
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
