<script setup>
import { defineProps } from "vue";

const statistics = defineProps(['statistics']);

</script>
<template>
    <VCard>
        <VCardText>
            <VRow justify="space-between">
                <VCol cols="12" sm="6" md="6">
                    <h6 class="text-base font-weight-semibold mb-2 text-primary">
                        {{ statistics.title }}
                    </h6>
                    <VChip v-if="statistics.subtitle" size="x-small" color="statistics.color" class="mb-5 text-primary">
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
</template>
