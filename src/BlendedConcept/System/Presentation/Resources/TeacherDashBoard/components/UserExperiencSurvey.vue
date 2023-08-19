<script setup>
const isDialogVisible = ref(true);
</script>

<template>
    <VDialog v-model="isDialogVisible" width="70%">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props"> UserExperiencSurvey </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="pa-16">
            <DialogCloseBtn
                variant="text"
                size="small"
                @click="isDialogVisible = false"
            />

            <VCardTitle class="">
                <h1 class="tiggie-label" style="font-size: 40px !important">
                    User Experience Survey
                </h1>
            </VCardTitle>

            <VCardText>
                <h4
                    class="tiggie-label mt-16 mb-10"
                    style="font-size: 24px !important"
                >
                    How would you rate your overall satisfaction with TiggieKids
                    on a scale of 1 to 5? <span class="text-candy-red">*</span>
                </h4>

                <VRow class="mt-10" align="center">
                    <VCol cols="3">
                        <VLabel
                            class="tiggie-label-custome"
                            style="font-size: 20px !important"
                            >Not satisfied at all
                        </VLabel>
                    </VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >1</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >2</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >3</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >4</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >5</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="2">
                        <VLabel
                            class="tiggie-label-custome"
                            style="font-size: 20px !important"
                            >Extremely Satisfied
                        </VLabel>
                    </VCol>
                </VRow>
            </VCardText>

            <VCardText>
                <h4
                    class="tiggie-label mt-16 mb-10"
                    style="font-size: 24px !important"
                >
                    What is the main reason for your score?
                    <span class="text-candy-red">*</span>
                </h4>
                <VTextarea
                    placeholder="Please Type here ...."
                    auto-grow
                    rows="5"
                />
            </VCardText>

            <VCardText>
                <h4
                    class="tiggie-label mt-16 mb-5"
                    style="font-size: 24px !important"
                >
                    What is the main reason for your score?
                    <span class="text-candy-red">*</span>
                </h4>
                <VRow justify="center" class="mb-5">
                    <VCol cols="3" class="ms-3">
                        <div class="d-flex">
                            <VLabel>Yes</VLabel>
                            <VRadio value="1" size="20" />
                        </div>
                    </VCol>
                    <VCol cols="3">
                        <div class="d-flex">
                            <VLabel>No</VLabel>
                            <VRadio value="1" size="20" />
                        </div>
                    </VCol>
                </VRow>
                <VTextarea
                    placeholder="Please Type here ...."
                    auto-grow
                    rows="5"
                />
            </VCardText>

            <VCardText>
                <h4
                    class="tiggie-label mt-16"
                    style="font-size: 24px !important"
                >
                    How likely are you to recommend TiggieKids to a friend or
                    colleague? <span class="text-candy-red">*</span>
                </h4>

                <VRow class="mt-10" align="center">
                    <VCol cols="3">
                        <VLabel
                            class="tiggie-label-custome"
                            style="font-size: 20px !important"
                        >
                            Not likely at all
                        </VLabel>
                    </VCol>
                    <VCol cols="6">
                        <VRow>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >1</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >2</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >3</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >4</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                            <VCol cols="2">
                                <div class="d-flex flex-column justify-center">
                                    <VLabel
                                        class="tiggie-label-custome"
                                        style="font-size: 20px !important"
                                        >5</VLabel
                                    >
                                    <VRadio value="1" size="20" />
                                </div>
                            </VCol>
                        </VRow>
                    </VCol>
                    <VCol cols="2">
                        <VLabel
                            class="tiggie-label-custome"
                            style="font-size: 20px !important"
                        >
                            Extremely Likely
                        </VLabel>
                    </VCol>
                </VRow>
            </VCardText>

            <VCardText>
                <h4
                    class="tiggie-label mt-16 mb-10"
                    style="font-size: 24px !important"
                >
                    What is the main reason for your score?
                    <span class="text-candy-red">*</span>
                </h4>
                <VTextarea
                    placeholder="Please Type here ...."
                    auto-grow
                    rows="5"
                />
            </VCardText>

            <VCardActions>
                <VRow justify="center">
                    <VCol cols="3">
                        <VBtn
                            color="cancle"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            Cancel
                        </VBtn>
                    </VCol>
                    <VCol cols="3">
                        <VBtn
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            Submit
                        </VBtn>
                    </VCol>
                </VRow>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<style scoped>
::v-deep .tiggie-label-custome {
    color: #282828 !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 20px !important;
}

::v-deep .v-radio {
    font-size: 16px;
    /* Adjust the font size as needed */
    width: 32px;
    /* Adjust the width as needed */
    height: 32px;
    /* Adjust the height as needed */
}
</style>
