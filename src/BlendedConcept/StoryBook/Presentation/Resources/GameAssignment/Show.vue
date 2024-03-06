<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import { router } from "@inertiajs/core";
import { ref } from "vue";
import AssignStudentsTable from "./components/AssignStudentsTable.vue";

const props = defineProps(["game", "students"]);
// console.log(props.game);

let tab = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row>
                <v-col cols="12" md="6">
                    <div class="ps-relative">
                        <v-img
                            :src="props.game.thumbnail"
                            class="main-pic"
                            cover
                            aspect-ratio="16/9"
                        />
                        <div class="vector-background">
                            <img src="/images/bg.png" />
                        </div>
                    </div>
                </v-col>
                <v-col cols="12" md="6">
                    <VRow>
                        <VCol cols="12" md="6">
                            <h1 class="tiggie-sub-subtitle ml-10 fs-40">
                                {{ props.game.name }}
                            </h1>
                        </VCol>
                        <VCol cols="12" md="6" class="text-end"> </VCol>
                    </VRow>
                    <span v-html="props.game.description" class="text-subtitle-1 mt-10 mx-10">
                    </span>
                    <br />
                    <div class="learning-tabs mt-10 mx-10">
                        <v-tabs v-model="tab">
                            <v-tab value="disability">Disability Type</v-tab>
                        </v-tabs>

                        <div>
                            <v-window v-model="tab">
                                <v-window-item value="disability">
                                    <ChipWithBlueDot
                                        v-for="item in props.game
                                            .disability_types"
                                        :key="item.id"
                                        :title="item.name"
                                    />
                                </v-window-item>
                            </v-window>
                        </div>
                    </div>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <AssignStudentsTable
                        :game="props.game"
                        :students="props.students"
                        :assignments="props.game.game_assignments"
                    />
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.main-pic {
    z-index: 2;
}
.vector-background {
    position: absolute;
    top: -52%;
    left: -36%;
    z-index: 1;
}
.vector-background img {
    width: 900px;
    max-height: 600px;
}
</style>
