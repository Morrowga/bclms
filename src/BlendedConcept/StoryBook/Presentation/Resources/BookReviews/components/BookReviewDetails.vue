<script setup>
import { defineProps, onUpdated } from "vue";
// const props = defineProps({
//     isDialogVisible: {
//         type: Boolean,
//         default: false,
//     }
// });

const props = defineProps(["isDialogVisible", "bookreviews"]);
const bookReviewDetails = ref({});

onUpdated(() => {
    bookReviewDetails.value = props.bookreviews;
});
</script>

<template>
    <VDialog v-model="props.isDialogVisible" width="800">
        <VCard>
            <VCardTitle>
                <VRow align="center">
                    <VCol cols="3">
                        <VImg src="/images/image1.png" />
                    </VCol>
                    <VCol cols="3">
                        <h1 class="tiggie-label">
                            {{ bookReviewDetails?.storybooks?.name }}
                        </h1>
                        <VRating
                            readonly
                            :model-value="bookReviewDetails.stars"
                            active-color="#4C4E64"
                        />
                    </VCol>
                </VRow>
            </VCardTitle>
            <VCardText>
                <h1 class="tiggie-label">Feedbacks</h1>
                <p class="tiggie-p">
                    {{ bookReviewDetails.feedback }}
                </p>
            </VCardText>

            <VCardActions class="pt-3 justify-space-between">
                <div class="d-flex align-center">
                    <img
                        src="/images/profile/profiletwo.png"
                        class="width-high-50"
                    />
                    <div class="ml-10">
                        <h5>Customer</h5>
                        <div class="tiggie-p">
                            {{ bookReviewDetails.users[0]?.full_name }}
                        </div>
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
