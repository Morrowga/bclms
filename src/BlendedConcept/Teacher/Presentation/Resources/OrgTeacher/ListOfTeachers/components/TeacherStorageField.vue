<script setup>
import { ref } from "vue";
import EditTeacherStorage from "./EditTeacherStorage.vue";

const storage = ref(200);
const props = defineProps(["data", "left_storage"]);

const setImage = () => {
    return props.data?.user?.profile_pic == "" || !props.data?.user?.profile_pic
        ? "/images/teacherimg.png"
        : props.data?.user?.profile_pic;
};
const calculatePercent = (specific, total) => {
    if (total === 0) {
        return 0; // To avoid division by zero error
    }

    return (specific / total) * 100;
};
</script>
<template>
    <VCard>
        <VRow justify="space-between" class="pa-5">
            <VCol cols="4" class="teacher-profile">
                <img :src="setImage()" class="tggie-student-img storage-img" />
            </VCol>
            <VCol cols="8" class="allocated-storage">
                <div class="d-flex align-center justify-space-between">
                    <p class="tiggie-teacher-label fs-24 t-black">
                        Allocated Storage:
                        {{ props.data.allocated_storage_limit ?? 0 }} MB
                    </p>
                    <!-- <div class="d-flex">
                        <VLabel class="tiggie-teacher-label">200 MB</VLabel>
                    </div> -->
                </div>
                <div class="d-flex">
                    <v-sheet
                        width="100%"
                        height="42px"
                        color="#BFC0C1"
                        class="d-flex my-4 rounded overflow-hidden"
                    >
                        <v-sheet
                            class="pt-3"
                            color="teal"
                            height="100%"
                            :width="`${
                                (calculatePercent(
                                    props.data.used_storage,
                                    props.data.allocated_storage_limit
                                ) /
                                    100) *
                                100
                            }%`"
                        />
                    </v-sheet>
                </div>
                <div class="d-flex gap-3 align-center">
                    <div>
                        <VIcon icon="mdi-circle" color="teal" class="mr-3" />
                        <span>Used</span>
                    </div>
                    <div>
                        <VIcon icon="mdi-circle" class="mr-3" />
                        <span>Available</span>
                    </div>
                </div>
            </VCol>
            <VCol cols="6">
                <p class="tiggie-subtitle">
                    {{ props.data?.user?.full_name }}
                </p>
            </VCol>
            <VCol cols="6" class="text-end pr-3">
                <EditTeacherStorage
                    :data="props.data"
                    :left_storage="props.left_storage"
                />
            </VCol>
        </VRow>
    </VCard>
</template>
<style scoped>
.storage-img {
    width: 150px;
    height: 150px;
}
</style>
