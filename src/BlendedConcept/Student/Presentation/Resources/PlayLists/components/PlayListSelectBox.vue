<script setup>
import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";

const stateList = [
    'Alabama',
    'Alaska',
    'Arizona',
    'Arkansas',
    'California',
    'Colorado',
    'Connecticut',
    'Delaware',
    'Florida',
    'Georgia',
    'Hawaii',
]

const radios = ref('home')
const deliveryOption = ref('standard')
const paymentMethod = ref('credit-debit-card')
const panel = ref(0)

const paymentMethods = [
    {
        radioValue: 'credit-debit-card',
        radioLabel: 'Credit/Debit/ATM Card',
        icon: 'mdi-credit-card-outline',
    },
    {
        radioValue: 'cash-on-delivery',
        radioLabel: 'Cash On Delivery',
        icon: 'mdi-help-circle-outline',
    },
]
</script>

<template>
    <VExpansionPanels v-model="panel">
        <VExpansionPanel>
            <VExpansionPanelTitle class="tiggie-teacher-title">Step 1: Select Student</VExpansionPanelTitle>

            <VExpansionPanelText>
                <VForm @submit.prevent="() => { }">
                    <VRow justify="center">
                        <VCol cols="12">
                            <VTextField placeholder="Search ..." append-inner-icon="" density="compact" rounded>
                                <template #append-inner>
                                    <VIcon v-bind="props" icon="mdi-magnify" size="30" />
                                </template>
                            </VTextField>
                        </VCol>
                    </VRow>
                    <VRow class="bg-line  rounded pa-1 mb-5" align="center">
                        <VCol cols="4" class="ml-4">
                            <VLabel class="tiggie-label">Name</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="2">
                            <VLabel class="tiggie-label">Education Level</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>

                        <VCol cols="1">
                            <VLabel class="tiggie-label">Age</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                        <VCol cols="4">
                            <VLabel class="tiggie-label">Disability Type</VLabel>
                            <VIcon icon="mdi-menu-down"></VIcon>
                        </VCol>
                    </VRow>
                    <VRow class="bg-line rounded pa-5 mb-2" align="center" v-for="item in 6" :key="item">
                        <VCol cols="3">
                            <div class="d-flex align-center gap-1">
                                <VRadio />
                                <VImg src="/teacherdashboard/student1.png" width="56px" height="56px" />
                                <span class="tiggie-teacher-label" style="color:#282828 !important">Madge Dennis</span>
                            </div>
                        </VCol>
                        <VCol cols="2">
                            <span class="tiggie-teacher-label" style="color:#282828 !important">K2</span>
                        </VCol>
                        <VCol cols="1">
                            <span class="tiggie-teacher-label" style="color:#282828 !important">6</span>
                        </VCol>
                        <VCol cols="4">
                            <div class="d-flex flex-column gap-2">
                                <GreenChip title="Down Syndrome" :icon="true" class="ma-1"/>
                                <GreenChip title="Down Syndrome" :icon="true" class="ma-1"/>
                            </div>
                        </VCol>
                    </VRow>
                    <VRow justify="center" align="center">
                        <VPagination v-model="currentPage" variant="outlined" :length="5" />
                    </VRow>
                </VForm>
            </VExpansionPanelText>
        </VExpansionPanel>
        <VExpansionPanel>
            <VExpansionPanelTitle class="tiggie-teacher-title">Step 2: Select Storybooks</VExpansionPanelTitle>
            <VExpansionPanelText>
                <VRow justify="end">
                    <VCol cols="2">
                        <VTextField placeholder="Search ..." density="compact" rounded>
                            <template #append-inner>
                                <VIcon v-bind="props" icon="mdi-magnify" size="30" />
                            </template>
                        </VTextField>
                    </VCol>

                    <VCol cols="2">
                        <SelectBox placeholder="Sort By" density="compact" rounded>
                        </SelectBox>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="3" v-for="item in 12" :key="item">
                        <VCard>
                            <VImg src="/teacherdashboard/student1.png" height="282px" cover />

                            <VCardItem>
                                <VCardTitle class="text-center tiggie-teacher-p"
                                    style="color:#282828 !important;font-weight:700 !important">Influencing The Influencer
                                </VCardTitle>
                            </VCardItem>
                            <VCardActions>
                                <div class="d-flex">
                                    <GreenChip title="Switch" class="ma-1"/>
                                    <GreenChip title="Eye-Gaze" class="ma-1"/>
                                    <GreenChip title="Touch" class="ma-1"/>
                                </div>

                            </VCardActions>
                        </VCard>
                    </VCol>
                </VRow>
                <VRow justify="center">
                    <VCol cols="2">
                      <VBtn variant="flat" color="pale-blue" class="text-tiggie-blue"  rounded>
                        Load more
                      </VBtn>
                    </VCol>
                 </VRow>
            </VExpansionPanelText>
        </VExpansionPanel>
    </VExpansionPanels>
</template>

<style lang="scss">
.delivery-options {
    .v-selection-control-group {
        inline-size: 100%;
    }
}

.delivery-option {
    padding: 1rem;
    border: 1px solid rgba(var(--v-border-color), var(--v-border-opacity));

    &.active {
        border-color: rgb(var(--v-theme-primary));
    }
}
</style>
