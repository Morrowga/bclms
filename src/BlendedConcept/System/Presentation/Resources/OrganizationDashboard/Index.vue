<script setup>
import UserListCard from "@mainRoot/components/UserListCard.vue";
import TotalStudents from "./TotalStudents.vue";
import TotalTeachers from "./TotalTeachers.vue";

import ClassroomCard from "@mainRoot/components/ClassroomCard/ClassroomCard.vue";

import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";

const statisticsWithImages = [
    {
        title: "My Classes",
        subtitle: "Total Number Of Classes",
        stats: 100,
        icon: "mdi-google-classroom",
        imgWidth: 99,
        color: "primary",
    },
    {
        title: "My Students",
        subtitle: "Total Number Of Students",
        stats: "10",
        icon: "mdi-account-multiple",
        imgWidth: 85,
        color: "success",
    },
];

const props = defineProps(["classrooms"]);
const showCount = (classroom) => {
    return classroom?.students_count + "/" + classroom?.teachers_count;
};
onMounted(() => {
    console.log(props.classrooms);
});
</script>

<template>
    <v-container>
        <VRow>
            <VCol cols="12" sm="12" lg="12">
                <div class="header d-flex justify-space-between">
                    <h1 class="tiggie-title">Classrooms</h1>
                    <Link :href="route('classrooms.create')">
                        <VBtn color="primary" variant="flat" rounded>
                            <VIcon icon="mdi-plus"></VIcon>
                            <span class="text-white">Add</span>
                        </VBtn>
                    </Link>
                </div>
                <div class="mt-5">
                    <v-row>
                        <v-col
                            v-for="classroom in props.classrooms.data"
                            :key="classroom.id"
                            cols="12"
                            sm="6"
                            md="4"
                            lg="3"
                        >
                            <ClassroomCard
                                :route="route('showCopy', classroom.id)"
                                :count="showCount(classroom)"
                                :label="classroom.name"
                                :image="classroom.classroom_photo"
                            />
                        </v-col>
                    </v-row>
                </div>
            </VCol>
            <VCol cols="12" sm="12" lg="12" class="mt-10">
                <TotalStudents />
            </VCol>
            <VCol cols="12" sm="12" lg="12" class="mt-10">
                <TotalTeachers />
            </VCol>
        </VRow>
        <UserExperienceSurvey />
    </v-container>
</template>

<style lang="scss">
.phone-color {
    color: #ff6262;
}

.w-10 {
    width: 180px;
}

.h-10 {
    width: 180px;
}

.w-6 {
    width: 16px;
}

.h-6 {
    height: 16px;
}
</style>
