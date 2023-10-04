<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import AssignStudentsTable from "./components/AssignStudentsTable.vue";
import { router } from "@inertiajs/core";
import { ref } from "vue";
let tab = ref(false);
defineProps(["teacher_storybook", "version", "students"]);
const getImage = (item) => {
    return item.thumbnail_img == "" || !item.thumbnail_img
        ? "/images/image8.png"
        : item.thumbnail_img;
};
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row class="mb-10">
                <v-col cols="12" md="6">
                    <div class="ps-relative">
                        <v-img
                            :src="getImage(teacher_storybook)"
                            class="main-pic"
                        />
                        <div class="vector-background">
                            <img src="/images/vector.png" />
                        </div>
                    </div>
                </v-col>
                <v-col cols="12" md="6">
                    <h1 class="tiggie-sub-subtitle ml-10 fs-40">
                        {{ teacher_storybook.name }}
                    </h1>
                    <p class="text-subtitle-1">
                        {{ teacher_storybook.description }}
                    </p>
                    <br />
                    <div class="learning-chip-group">
                        <v-chip
                            variant="outlined"
                            v-for="item in teacher_storybook.devices"
                            :key="item.id"
                            color="success"
                            class="mr-4"
                            >{{ item.name }}</v-chip
                        >
                    </div>
                    <div class="learning-tabs mt-10">
                        <v-tabs v-model="tab">
                            <v-tab value="learning">Learning Needs</v-tab>
                            <v-tab value="themes">Themes</v-tab>
                            <v-tab value="disability"
                                >Learning Activities</v-tab
                            >
                        </v-tabs>

                        <div>
                            <v-window v-model="tab">
                                <v-window-item value="learning">
                                    <ChipWithBlueDot
                                        v-for="item in teacher_storybook.learningneeds"
                                        :key="item"
                                        :title="item.name"
                                    />
                                </v-window-item>
                                <v-window-item value="themes">
                                    <ChipWithBlueDot
                                        v-for="item in teacher_storybook.themes"
                                        :key="item"
                                        :title="item.name"
                                    />
                                </v-window-item>

                                <v-window-item value="disability">
                                    <ChipWithBlueDot
                                        v-for="item in teacher_storybook.disability_types"
                                        :key="item"
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
                        :storybook="teacher_storybook"
                        :students="students"
                        :version="version"
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
    top: -42%;
    left: -36%;
    z-index: 1;
}
.vector-background img {
    width: 900px;
    max-height: 600px;
}
</style>
