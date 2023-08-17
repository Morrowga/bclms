<script setup>
import { defineProps } from "vue";

let orgainzations_users = defineProps(["orgainzations_users"]);
import LatestModifiedOrganizations from "./LatestModifiedOrganizations.vue";
import TotalUserSurveys from "./TotalUserSurveys.vue";
import RoleCard from "@mainRoot/components/RoleCard.vue";
import Slider from "./components/Slider.vue";

const bookResources = [
    {
        id: 1,
        image: "/images/image1.png",
    },
    {
        id: 2,
        image: "/images/image2.png",
    },
    {
        id: 3,
        image: "/images/image3.png",
    },
    {
        id: 4,
        image: "/images/image4.png",
    },
    {
        id: 5,
        image: "/images/image5.png",
    },
];

const gameResources = [
    {
        image: "/images/image6.png",
    },
    {
        image: "/images/image7.png",
    },
    {
        image: "/images/image8.png",
    },
    {
        image: "/images/image9.png",
    },
    {
        image: "/images/image10.png",
    },
];
</script>

<template>
    <section>
        <VRow class="match-height mb-5">
            <RoleCard
                title="Organizations"
                btnText="Manage"
                totalText="Total 19 Organizations"
            />
            <RoleCard
                title="Subscriptions"
                btnText="Manage"
                totalText="Total 87 Users"
            />
            <RoleCard
                title="Users"
                :avatars="avatars"
                btnText="Manage"
                totalText="Total 253 Students"
                :url="route('users.index')"
            />
        </VRow>
        <div class="slider-stction">
            <Slider
                title="Books"
                subtitle="Show 8 of 18 books"
                btnText="Manage Books"
                :url="route('books.index')"
                :datas="bookResources"
                type="books"
            /><br />
            <Slider
                title="Games"
                subtitle="Show 8 of 18 games"
                btnText="Manage Games"
                :url="route('games.index')"
                :datas="gameResources"
                type="games"
            /><br />
        </div>
        <VRow>
            <VCol>
                <div class="header">
                    <div class="head-section">
                        <div class="title-section">
                            <p class="heading">User Surveys</p>
                        </div>
                    </div>
                    <TotalUserSurveys
                        :organization="
                            orgainzations_users.orgainzations_users[1]
                        "
                    />
                    <br />
                </div>
                <br />
            </VCol>
        </VRow>
    </section>
</template>

<style>
.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    align-self: flex-end;
}
</style>
