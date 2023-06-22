<script setup>
import {defineProps} from "vue";

import TotalStudent from "./TotalStudent.vue"

let props = defineProps(['students']);

const statisticsWithImages = [
    {
        title: 'Students',
        subtitle: 'Total Students',
        stats: props?.students?.length,
        icon: 'mdi-account-multiple',
        imgWidth: 99,
        color: 'primary',
    },
    {
        title: 'Storage',
        subtitle: 'Current Usage',
        stats: '50%',
        icon: 'mdi-circle-slice-6',
        imgWidth: 85,
        color: 'success',
    },
]



</script>

<template>
    <section>
        <VRow class="match-height mb-5">
            <VCol v-for="statistics in statisticsWithImages" :key="statistics.title" cols="12" sm="6" md="6">
                <VCard>
                    <VCardText>
                        <VRow justify="space-between">
                            <VCol cols="12" sm="6" md="6">
                                <h6 class="text-base font-weight-semibold mb-2">
                                    {{ statistics.title }}
                                </h6>
                                <VChip v-if="statistics.subtitle" size="x-small" color="statistics.color" class="mb-5">
                                    {{ statistics.subtitle }}
                                </VChip>

                                <div class="d-flex align-center flex-wrap">
                                    <h5 class="text-h3 font-weight-bold me-2">
                                        {{ statistics.stats }}
                                    </h5>
                                </div>

                            </VCol>
                            <VCol cols="12" sm="6" md="6">
                                <VIcon :icon="statistics.icon" size="100" />
                            </VCol>
                        </VRow>
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
        <VRow>
          <VCol cols="12" sm="12" md="12">
            <TotalStudent :students="students"/>
          </VCol>
        </VRow>
    </section>

</template>

<style></style>
