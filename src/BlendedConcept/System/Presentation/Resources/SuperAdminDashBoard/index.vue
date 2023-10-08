<script setup>
import { defineProps } from "vue";
import RoleCard from "@mainRoot/components/RoleCard.vue";
import avatar1 from "@images/avatars/avatar-1.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar4 from "@images/avatars/avatar-4.png";
import LatestModifiedOrganisations from "./LatestModifiedOrganisations.vue";
import TotalUsers from "./TotalUsers.vue";

const avatars = [avatar1, avatar2, avatar3, avatar4];
let orgainzations_users = defineProps(["usercount"]);
</script>

<template>
    <VContainer fluid>
        <!-- role card section -->
        <section class="role-card-section">
            <VRow>
                <RoleCard
                    title="Organisations"
                    btnText="Manage"
                    :totalText="`Total ${usercount?.organisation_count} Organisations`"
                    :url="route('organisations.index')"
                />
                <RoleCard
                    title="Subscriptions"
                    btnText="Manage"
                    :totalText="`Total ${usercount?.b2csubscriper_count}  Users`"
                    :url="route('subscription_invoice')"
                />
                <RoleCard
                    title="Users"
                    :avatars="avatars"
                    btnText="Manage"
                    :totalText="`Total ${usercount?.user_count} Students`"
                    :url="route('users.index')"
                />
            </VRow>
        </section>
        <br />
        <br />
        <!-- latest modified organisation section -->
        <section class="latest-modified">
            <div class="header">
                <span class="tiggie-title">Recent Organisations</span>
                <br />
            </div>
            <br />
            <LatestModifiedOrganisations />
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
            <TotalUsers />
        </section>
    </VContainer>
</template>
