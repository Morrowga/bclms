<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";

let form = useForm({
  isCustomization: false,
  isPresentation: false,
  isFullAccess: false,
  isConcurrentAccess: false,
  isWeeklyLearningReport: false,
  isDedicatedStudentReport: false,
});
const setInactive = () => {
  isConfirmedDialog({
    title: "Are you sure?",
    denyButtonText: "Set Inactive",
    onConfirm: () => {},
  });
};

defineProps(["user"]);
</script>
<template>
  <AdminLayout>
    <VContainer>
      <VRow justify="center">
        <VCol cols="12" md="4">
          <VRow>
            <VCol cols="12">
              <h4 class="tiggie-show-title pr-10 margin-buttom-18">
                User Particulars
              </h4>
            </VCol>
            <VCol cols="12">
              <img src="/images/defaults/avator.png" />
            </VCol>

            <VCol cols="12">
              <VLabel class="tiggie-label">Name</VLabel>
              <p class="tiggie-p ml-4">{{ user?.full_name }}</p>
            </VCol>
            <VCol cols="12">
              <VLabel class="tiggie-label">User Email</VLabel>
              <p class="tiggie-p ml-4">
                {{ user?.email }}
              </p>
            </VCol>
            <VCol cols="12">
              <VLabel class="tiggie-label">User Contact Number</VLabel>
              <p class="tiggie-p ml-4">
                {{ user.contact_number }}
              </p>
            </VCol>
            <VCol cols="12" class="vs-hidden" v-if="user.organisation_id">
              <Link
                :href="route('organisations.show', user.organisation_id)"
                class="cu-pointer"
              >
                <VLabel class="tiggie-label">Organisation Name</VLabel>
                <p class="tiggie-p ml-4 underline">
                  {{ user?.b2b_user }}
                </p>
              </Link>
            </VCol>

            <VCol cols="12">
              <Link :href="route('users.index')" class="text-center">
                <VBtn
                  color="gray"
                  text-color="white"
                  height="50"
                  class="finish-btn pl-5 pr-5"
                >
                  Back
                </VBtn>
              </Link>
            </VCol>
          </VRow>
        </VCol>
        <VCol cols="12" md="4">
          <VRow>
            <VCol cols="12" class="mb-16"> </VCol>
            <VCol cols="12">
              <VLabel class="tiggie-label">User Role</VLabel>
              <p class="tiggie-p ml-4">Organisation Admin</p>
            </VCol>

            <VCol cols="12">
              <VLabel class="tiggie-label">Login Email</VLabel>
              <p class="tiggie-p ml-4">estelle.Bailey10@gmail.com</p>
            </VCol>

            <VCol cols="12">
              <VLabel class="tiggie-label">Login Password</VLabel>
              <p class="tiggie-p ml-4">*********</p>
            </VCol>
            <VCol cols="12">
              <VLabel class="tiggie-label">Current User Status</VLabel>
              <p class="tiggie-p text-teal ml-4">ACTIVE</p>
            </VCol>
            <VCol cols="12" class="mt-16">
              <VBtn
                type="submit"
                color="candy-red"
                class="finish-btn pl-5 pr-5"
                height="50"
                @click="setInactive()"
              >
                Set Inactive
              </VBtn>
            </VCol>
          </VRow>
        </VCol>
      </VRow>
    </VContainer>
  </AdminLayout>
</template>
<style scoped>
.underline {
  text-decoration: underline;
}
</style>
