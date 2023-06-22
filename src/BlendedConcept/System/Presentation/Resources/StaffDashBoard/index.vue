<script setup>
import { defineProps } from "vue";

let props = defineProps(['orgainzations_users']);


const statisticsWithImages = [
    {
        title: 'Users',
        subtitle: 'Total Number Of Users',
        stats: 100,
        icon: 'mdi-account-multiple',
        imgWidth: 99,
        color: 'primary',
    },
    {
        title: 'Organizations',
        subtitle: 'Total Number Of Organization',
        stats: '10',
        icon: 'mdi-domain',
        imgWidth: 85,
        color: 'success',
    },
    {
        title: 'Revenue',
        subtitle: 'Total Revenue',
        stats: '70,000',
        icon: 'mdi-currency-usd',
        imgWidth: 85,
        color: 'success',
    }
]



</script>

<template>
    <section>
        <VRow class="match-height mb-5">
            <VCol v-for="statistics in statisticsWithImages" :key="statistics.title" cols="12" sm="6" md="4">
                <VCard>
                    <VCardText>
                        <VRow justify="space-between">
                            <VCol cols="12" sm="6" md="6">
                                <h6 class="text-base font-weight-semibold mb-2 text-primary">
                                    {{ statistics.title }}
                                </h6>
                                <VChip v-if="statistics.subtitle" size="x-small" color="statistics.color"
                                    class="mb-5 text-primary">
                                    {{ statistics.subtitle }}
                                </VChip>

                                <div class="d-flex align-center flex-wrap">
                                    <h5 class="text-h3 font-weight-bold me-2 text-primary">
                                        {{ statistics.stats }}
                                    </h5>
                                </div>

                            </VCol>
                            <VCol cols="12" sm="6" md="6">
                                <VIcon :icon="statistics.icon" color="primary" size="100" />
                            </VCol>
                        </VRow>
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
        <VRow>
            <VCol>
                <div class="header">
                    <span class="text-xl">Latest Modified Organization</span>
                    <br />
                    <span class="text-xs">Find all of your company's administrator accounts and their associate
                        roles.</span>
                    <br />
                </div>
                <br />

            </VCol>
            <VCol>
                <div class="header">
                    <span class="text-xl">Total users with their roles</span>
                    <br />
                    <span class="text-xs">Find all of your company’s administrator accounts and their associate
                        roles.</span>
                    <br />
                </div>
                <br />

            </VCol>
        </VRow>
    </section>
</template>

<style></style>
