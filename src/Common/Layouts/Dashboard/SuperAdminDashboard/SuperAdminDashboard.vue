<script setup>
import RoleCard from "@Composables/RoleCard.vue";
import avatar1 from "@images/avatars/avatar-1.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar4 from "@images/avatars/avatar-4.png";
import LatestModifiedOrganizations from "./LatestModifiedOrganizations.vue";
import TotalUsers from "./TotalUsers.vue";
const avatars = [avatar1, avatar2, avatar3, avatar4];
</script>

<template>
  <!-- role card section -->
  <section class="role-card-section">
    <VRow>
      <RoleCard
        title="Organizations"
        :avatars="avatars"
        btnText="Manage"
        totalText="Total 4 Organizations"
      />
      <RoleCard
        title="Users"
        :avatars="avatars"
        btnText="Manage"
        totalText="Total 300 Users"
      />
      <RoleCard
        title="Students"
        :avatars="avatars"
        btnText="Manage"
        totalText="Total 600 Students"
      />
    </VRow>
  </section>
  <br />
  <br />
  <!-- latest modified organization section -->
  <section class="latest-modified">
    <div class="header">
      <span class="text-xl">Latest Modified Organization</span>
      <br />
      <span class="text-xs"
        >Find all of your company's administrator accounts and their associate
        roles.</span
      >
      <br />
    </div>
    <br />
    <LatestModifiedOrganizations />
  </section>
  <br />
  <br />
  <!--Total Users With Their Role Section -->
  <section class="total-users">
    <div class="header">
      <span class="text-xl">Total users with their roles</span>
      <br />
      <span class="text-xs"
        >Find all of your company’s administrator accounts and their associate
        roles.</span
      >
      <br />
    </div>
    <br />
    <TotalUsers />
  </section>
</template>