<script setup>
import { ref } from "vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";

let dialog = ref(false);
const submitReview = () => {
    dialog.value = false;
    SuccessDialog({
        title: "You have successfully created a version",
        color: "#17CAB6",
    });
};
</script>
<template>
    <div>
        <v-btn
            prepend-icon="mdi-add"
            variant="flat"
            rounded
            color="primary"
            @click="dialog = true"
        >
            Add
        </v-btn>
        <v-dialog v-model="dialog" width="auto" min-width="800">
            <v-card>
                <v-card-title>
                    <div class="d-flex justify-space-between align-center">
                        <span class="header-create"
                            >Create a new storybook version</span
                        >
                        <v-btn
                            variant="text"
                            icon="mdi-close"
                            @click="dialog = false"
                        ></v-btn>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col cols="12">
                                <v-label class="font-weight-bold t-black"
                                    >Name</v-label
                                >
                                <v-text-field
                                    variant="outlined"
                                    density="compact"
                                    placeholder="Enter Name"
                                />
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold t-black"
                                    >Description</v-label
                                >
                                <v-text-field
                                    variant="outlined"
                                    density="compact"
                                    placeholder="Enter Description"
                                />
                            </v-col>
                            <v-col cols="12">
                                <div
                                    class="d-flex justify-center align-center gap-10"
                                >
                                    <SecondaryBtn
                                        title="Cancel"
                                        @click="dialog = false"
                                    />
                                    <PrimaryBtn
                                        title="Save"
                                        :isLink="false"
                                        @click="submitReview()"
                                    />
                                </div>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<style scoped>
.header-create {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
</style>
