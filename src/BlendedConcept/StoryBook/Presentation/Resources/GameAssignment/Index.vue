<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Filter from "./components/Filter.vue";
import { router } from "@inertiajs/core";
import {
    serverParams,
    onColumnFilter,
    searchItems,
    onPageChange,
    onPerPageChange,
    serverPage,
    serverPerPage,
} from "@Composables/useServerSideDatable.js";
import { checkPermission } from "@actions/useCheckPermission";

let props = defineProps(["disabilityTypes", "games", "devices"]);

</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <v-row justify="space-between">
                <v-col cols="4">
                    <div class="title-section">
                        <p class="heading ruddy-bold">Games</p>
                        <!-- <span class="subheading"
                            >Showing {{ props.games.data.length }} games</span
                        > -->
                    </div>
                </v-col>
                <v-col cols="6">
                    <div class="d-flex gap-5">
                        <v-text-field
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                            density="compact"
                            max-height="20px"
                            max-width="100px"
                        />
                        <Filter
                            :disabilityTypes="props.disabilityTypes.data"
                            :devices="props.devices.data"
                        />
                    </div>
                </v-col>
            </v-row>
            <VRow class="mt-5">
                <VCol
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="data in props.games.data"
                    :key="data.thumbnail"
                >
                    <VCard class="gamecard"
                    @click="
                        () =>
                            router.get(
                                route('gameassign.show', data.id)
                            )
                    "
                    >
                        <VCardText>
                            <div class="d-flex justify-center">
                                <img class="game-img" :src="data.thumbnail">
                            </div>
                            <div class="text-center mt-3">
                                <p class="pppangram-bold">{{ data.name  }}</p>
                            </div>
                        </VCardText>
                    </VCard>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.game-img{
    object-fit: cover !important;
    width: 100%;
    height: 170px;
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

.gamecard{
    background: #f6f6f6 !important;
    border: 1px solid rgb(0,0,0,0.1);
}

.head-button {
    align-self: flex-end;
}
.fit-img {
    width: 100%;
    height: 100%;
    max-height: 217px;
}
.item-frame {
    position: relative;
}
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.heading{
    color: #000 !important;
}

.v-card:not(.on-hover) {
    opacity: 1;
}
</style>
