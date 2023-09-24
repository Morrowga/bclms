<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
  isCustomization: false,
  isPresentation: false,
  isFullAccess: false,
  isConcurrentAccess: false,
  isWeeklyLearningReport: false,
  isDedicatedStudentReport: false,
});
const props = defineProps({
  plan: {
    type: Object,
    required: true,
  },
});
</script>
<template>
  <AdminLayout>
    <VContainer>
      <VRow justify="space-around" :gutter="5">
        <VCol cols="6">
          <span class="tiggie-show-title margin-buttom-18 pr-4">
            {{ props.plan?.name }}</span
          >
          <VChip color="teal">
            {{ props.plan?.status }}
          </VChip>
        </VCol>
        <VCol cols="6"></VCol>
        <VCol cols="6">
          <VRow>
            <VCol cols="8">
              <VLabel class="tiggie-label">Description</VLabel>
              <p class="tiggie-p">Allow access to basic features</p>
            </VCol>
            <VCol cols="8">
              <VLabel class="tiggie-label">Prices</VLabel>
              <p class="tiggie-p">${{ props.plan?.price }}</p>
            </VCol>
          </VRow>
        </VCol>
        <VCol cols="6">
          <VRow>
            <VCol cols="8">
              <VLabel class="tiggie-label">Number of Student Profile</VLabel>
              <p class="tiggie-p">
                {{ props.plan?.num_student_profiles }}
              </p>
            </VCol>
            <VCol cols="8">
              <VLabel class="tiggie-label">Storage space</VLabel>
              <p class="tiggie-p">{{ props.plan?.storage_limit }}GB</p>
            </VCol>
            <VCol cols="8">
              <VRow no-gutters>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Customization </VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.allow_customisation ? "Yes" : "No" }}
                  </p>
                </VCol>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Personalization</VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.allow_personalisation ? "Yes" : "No" }}
                  </p>
                </VCol>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Full Library Access </VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.full_library_access ? "Yes" : "No" }}
                  </p>
                </VCol>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Concurrent Access</VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.concurrent_access ? "Yes" : "No" }}
                  </p>
                </VCol>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Weekly Learning Report </VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.weekly_learning_report ? "Yes" : "No" }}
                  </p>
                </VCol>
                <VCol cols="6">
                  <VLabel class="tiggie-label">Dedicated Student Report</VLabel>
                  <p class="tiggie-p">
                    {{ props.plan?.dedicated_student_report ? "Yes" : "No" }}
                  </p>
                </VCol>
              </VRow>
            </VCol>
          </VRow>
        </VCol>

        <VCol cols="12" class="d-flex flex-wrap justify-center gap-10">
          <Link :href="route('plans.index')" class="text-black">
            <VBtn color="gray" height="50" class="" width="250"> Cancel </VBtn>
          </Link>
          <VBtn class="" height="50" width="250">
            <Link :href="route('plans.edit', props.plan.id)" class="text-white"> Edit </Link>
          </VBtn>
        </VCol>
      </VRow>
    </VContainer>
  </AdminLayout>
</template>
