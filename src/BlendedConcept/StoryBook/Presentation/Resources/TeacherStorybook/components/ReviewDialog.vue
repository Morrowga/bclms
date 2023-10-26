<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";
const props = defineProps(["storybook_id"]);
let rating = ref(0);

const form = useForm({
    storybook_id: props.storybook_id,
    stars: rating.value,
    feedback: "",
});

let dialog = ref(false);
const submitReview = () => {
    form.post(route("bookreview"), {
        onSuccess: () => {
            dialog.value = false;
            SuccessDialog({
                title: "You have successfully created a review",
                color: "#17CAB6",
            });
        },
        onError: (error) => {
            console.log(error);
        },
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
                <VForm @submit.prevent="submitReview">
                    <VCard-subtitle>
                        <v-rating
                            hover
                            color="yellow"
                            v-model="form.stars"
                        ></v-rating>
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
                                    v-model="form.feedback"
                                >
                                </VTextarea>
                            </VCol>
                            <VCol
                                cols="12"
                                class="d-flex justify-center gap-10"
                            >
                                <SecondaryBtn
                                    title="Cancel"
                                    type="button"
                                    @click="dialog = false"
                                />
                                <v-btn
                                    variant="flat"
                                    rounded
                                    color="primary"
                                    width="200"
                                    type="submit"
                                >
                                    Submit
                                </v-btn>
                            </VCol>
                        </VRow>
                    </VCard-text>
                </VForm>
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
