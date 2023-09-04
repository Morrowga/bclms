<script setup>
import { defineProps } from "vue";
import RoleCard from "@mainRoot/components/RoleCard.vue";
import avatar1 from "@images/avatars/avatar-1.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar4 from "@images/avatars/avatar-4.png";
import LatestModifiedOrganizations from "./LatestModifiedOrganizations.vue";
import TotalUsers from "./TotalUsers.vue";

const avatars = [avatar1, avatar2, avatar3, avatar4];
let orgainzations_users = defineProps(["orgainzations_users"]);
</script>

<template>
    <VContainer fluid>
        <!-- role card section -->
        <section class="role-card-section">
            <VRow>
                <RoleCard
                    title="Organizations"
                    btnText="Manage"
                    totalText="Total 19 Organizations"
                    :url="route('organizations.index')"
                />
                <RoleCard
                    title="Subscriptions"
                    btnText="Manage"
                    totalText="Total 87 Users"
                    :url="route('subscription_invoice')"
                />
                <RoleCard
                    title="Users"
                    :avatars="avatars"
                    btnText="Manage"
                    totalText="Total 253 Students"
                    :url="route('users.index')"
                />
            </VRow>
        </section>
        <br />
        <br />
        <!-- latest modified organization section -->
        <section class="latest-modified">
            <div class="header">
                <span class="tiggie-title">Recent Organizations</span>
                <br />
            </div>
            <br />
            <LatestModifiedOrganizations
                :organization="orgainzations_users.orgainzations_users[1]"
            />
        </section>
        <br />
        <br />
        <!--Total Users With Their Role Section -->
        <section class="total-users">
            <div class="header">
                <span class="tiggie-title">Recent Users</span>

                <br />
            </div>
            <br />
            <TotalUsers :users="orgainzations_users.orgainzations_users[0]" />
        </section>
    </VContainer>
</template>
