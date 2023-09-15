<script setup>
import { defineProps } from "vue";
const props = defineProps({
    isDialogVisible: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <VDialog v-model="props.isDialogVisible" width="800">
        <!-- Activator -->
        <!-- <template #activator="{ props }">
            <VBtn v-bind="props">
                Show Review Details
            </VBtn>
        </template> -->

        <!-- Dialog Content -->
        <VCard>
            <VCardTitle>
                <VRow align="center">
                    <VCol cols="3">
                        <VImg src="/images/image1.png" />
                    </VCol>
                    <VCol cols="3">
                        <h1 class="tiggie-label">Toy Story 2</h1>
                        <VRating :model-value="1" active-color="#4C4E64" />
                    </VCol>
                </VRow>
            </VCardTitle>
            <VCardText>
                <h1 class="tiggie-label">Absolute Garbage Book! Refund!!!</h1>
                <p class="tiggie-p">
                    Bear claw pastry cotton candy jelly toffee. Pudding
                    chocolate cake shortbread bonbon biscuit sweet. Lemon drops
                    cupcake muffin brownie fruitcake. Pastry pastry tootsie roll
                    jujubes chocolate cake gummi bears muffin pudding caramels.
                    Jujubes lollipop gummies croissant shortbread. Cupcake
                    dessert marzipan topping gingerbread apple pie chupa chups
                    powder. Cake croissant halvah candy canes gummies.
                </p>
            </VCardText>

            <VCardActions class="pt-3 justify-space-between">
                <div class="d-flex align-center">
                    <img
                        src="/images/profile/profiletwo.png"
                        class="width-high-50"
                    />
                    <div class="">
                        <h5>Customer</h5>
                        <div class="tiggie-p">Jordan Stevenson</div>
                    </div>
                </div>
                <VBtn
                    color="secondary"
                    text-color="white"
                    variant="tonal"
                    class="pl-16 pr-16"
                    @click="isDialogVisible = false"
                    height="50"
                >
                    <span class="text-dark">Close</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>
<style scoped>
.width-high {
    width: 50px !important;
    height: 50px !important;
}
</style>
