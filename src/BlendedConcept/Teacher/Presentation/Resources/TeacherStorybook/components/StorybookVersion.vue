<script setup>
import StorybookVersionCard from "./StorybookVersionCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";
</script>
<template>
    <div>
        <div class="header-sec d-flex justify-center align-center">
            <span> Storybook Versions </span>
            <CreateStorybookVersion />
        </div>
        <div class="body-sec">
            <v-row>
                <v-col
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="item in 4"
                    :key="item"
                >
                    <StorybookVersionCard />
                </v-col>
            </v-row>
        </div>
    </div>
</template>
<style scoped>
.header-sec {
    width: 100%;
    gap: 20px;
}
.header-sec span {
    color: var(--text, #161616);
    /* H3 Ruddy */

    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}
.body-sec {
    padding-top: 40px;
}
</style>
