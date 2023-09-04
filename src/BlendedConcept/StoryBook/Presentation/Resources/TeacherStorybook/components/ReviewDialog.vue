<script setup>
import { ref } from "vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";

let rating = ref(0);

let dialog = ref(false);
const submitReview = () => {
    dialog.value = false;
    SuccessDialog({
        title: "You have successfully created a review",
        color: "#17CAB6",
    });
};
</script>
<template>
    <div>
        <VBtn
            variant="flat"
            color="inactive-tab"
            class="inactive-border"
            rounded
            prepend-icon="mdi-draw-pen"
            @click="dialog = true"
            >Review</VBtn
        >
        <VDialog v-model="dialog" width="auto" min-width="800">
            <VCard>
                <VCard-title>
                    <div class="d-flex justify-space-between align-center">
                        <span class="header-create ruddy-bold"
                            >Rage Our Book!</span
                        >
                        <v-btn
                            variant="text"
                            icon="mdi-close"
                            @click="dialog = false"
                        ></v-btn>
                    </div>
                </VCard-title>
                <VCard-subtitle>
                    <v-rating v-model="rating" hover color="yellow"></v-rating>
                </VCard-subtitle>
                <VCard-text>
                    <VRow>
                        <VCol cols="12">
                            <VLabel
                                class="required feedback-title pppangram-medium"
                                >Feedback</VLabel
                            >
                            <VTextarea
                                placeholder="Enter Your Feedback Here"
                                rows="10"
                            >
                            </VTextarea>
                        </VCol>
                        <VCol
                            cols="12"
                            class="d-flex justify-center"
                            style="gap: 10px"
                        >
                            <SecondaryBtn title="Cancel" />
                            <PrimaryBtn
                                title="Submit"
                                :isLink="false"
                                @click="submitReview()"
                            />
                        </VCol>
                    </VRow>
                </VCard-text>
            </VCard>
        </VDialog>
    </div>
</template>
<style scoped>
.header-create {
    color: var(--graphite, #282828) !important;
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.inactive-border {
    border: 1px solid var(--line, #e5e5e5) !important;
}
.feedback-title {
    color: var(--graphite, #282828) !important;

    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 26px !important;
}
</style>
