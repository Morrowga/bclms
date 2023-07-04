<script setup>
import { defineProps } from "vue";

import TotalClassRooms from "./TotalClassRooms.vue";
import TotalStudents from "./TotalStudents.vue";

const statisticsWithImages = [
  {
    title: "My Classes",
    subtitle: "Total Number Of Classes",
    stats: 100,
    icon: "mdi-google-classroom",
    imgWidth: 99,
    color: "primary",
  },
  {
    title: "My Students",
    subtitle: "Total Number Of Students",
    stats: "10",
    icon: "mdi-account-multiple",
    imgWidth: 85,
    color: "success",
  },
];
</script>

<template>
  <section>
    <VRow class="match-height mb-5">
      <VCol
        v-for="statistics in statisticsWithImages"
        :key="statistics.title"
        cols="12"
        sm="12"
        md="6"
      >
        <VCard>
          <VCardText>
            <VRow justify="space-between">
              <VCol cols="12" sm="6" md="6">
                <h6 class="text-base font-weight-semibold mb-2 text-primary">
                  {{ statistics.title }}
                </h6>
                <VChip
                  v-if="statistics.subtitle"
                  size="x-small"
                  color="statistics.color"
                  class="mb-5 text-primary"
                >
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
      <VCol cols="12" sm="12" lg="12">
        <div class="header">
          <span class="text-xl">Total ClassRooms</span>
          <br />

          <!-- <TotalClassRooms  /> -->

          <br />
        </div>
        <br />
      </VCol>
      <VCol  cols="12" sm="12" lg="12">
        <div class="header">
          <span class="text-xl">Latest Students</span>
          <br />

          <!-- <TotalStudents  /> -->

          <br />
        </div>
        <br />
      </VCol>
    </VRow>
  </section>
</template>
