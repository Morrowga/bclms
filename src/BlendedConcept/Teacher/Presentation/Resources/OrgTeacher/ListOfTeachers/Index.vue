<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherStorageField from "./components/TeacherStorageField.vue";

const props = defineProps([
    "organisation",
    "org_used_storage",
    "teacher_used_storage",
    "teachers",
]);

const getOrgStorageLimit = () => {
    if (props.organisation?.subscription?.b2b_subscription) {
        return props.organisation?.subscription?.b2b_subscription
            ?.storage_limit;
    } else {
        return 0;
    }
};

const calculatePercent = (specific) => {
    let total = getOrgStorageLimit();
    if (total === 0) {
        return 0; // To avoid division by zero error
    }

    return (specific / total) * 100;
};

const allTeacherLeftStorage = () => {
    let array = props.teachers.map((teacher) => teacher.left_storage);
    let totalStorage = array.reduce(
        (accumulator, currentValue) => accumulator + currentValue,
        0
    );
    return totalStorage;
};
const getTotalUsed = () => {
    return (
        props.org_used_storage +
        props.teacher_used_storage +
        allTeacherLeftStorage()
    );
};

const getAvaliableStorage = () => {
    let totalStorage = getOrgStorageLimit();
    let usedStorage = getTotalUsed();
    return totalStorage - usedStorage;
};
</script>

<template>
    <AdminLayout>
        <VContainer>
            <div class="fixed-progressbar">
                <div class="d-flex justify-space-between align-center pt-10">
                    <h1 class="tiggie-teacher-title">
                        Allocate Teacher’s Storage
                    </h1>
                    <Link :href="route('organisations-teacher.index')">
                        <VBtn
                            class="text-primary"
                            color="#e8e9ed"
                            width="200px"
                            variant="flat"
                            rounded
                        >
                            Back
                        </VBtn>
                    </Link>
                </div>
                <div
                    class="d-flex justify-space-between align-center mt-3 pt-3"
                >
                    <h1 class="tiggie-teacher-subtitle fs-30">
                        Total Storage Usage
                    </h1>
                    <div class="tiggie-subtitle">
                        {{ getTotalUsed() }} MB of {{ getOrgStorageLimit() }} MB
                        allocated to teachers,{{ getAvaliableStorage() }} MB
                        available
                    </div>
                </div>
                <div class="d-flex justify-space-between align-center">
                    <v-sheet
                        width="100%"
                        height="42px"
                        color="#BFC0C1"
                        class="d-flex my-4 rounded overflow-hidden"
                    >
                        <v-sheet
                            color="primary"
                            height="100%"
                            :width="`${
                                (calculatePercent(props.org_used_storage) /
                                    100) *
                                100
                            }%`"
                        >
                            <v-tooltip activator="parent" location="top"
                                >{{ props.org_used_storage }} MB</v-tooltip
                            >
                        </v-sheet>
                        <v-sheet
                            v-if="10"
                            color="teal"
                            height="100%"
                            :width="`${
                                (calculatePercent(props.teacher_used_storage) /
                                    100) *
                                100
                            }%`"
                        >
                            <v-tooltip activator="parent" location="top"
                                >{{ props.teacher_used_storage }} MB</v-tooltip
                            >
                        </v-sheet>
                        <v-sheet
                            v-if="10"
                            color="sun-yellow"
                            height="100%"
                            :width="`${
                                (calculatePercent(allTeacherLeftStorage()) /
                                    100) *
                                100
                            }%`"
                        >
                            <v-tooltip activator="parent" location="top"
                                >{{ allTeacherLeftStorage() }} MB</v-tooltip
                            >
                        </v-sheet>
                    </v-sheet>
                </div>
                <VRow>
                    <VCol cols="3">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="primary"
                                class="mr-2"
                            />
                            <span class="t-black">Organisation Resources</span>
                        </div>
                    </VCol>
                    <VCol cols="3">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="teal"
                                class="mr-2"
                            />
                            <span class="t-black">Teacher Resources</span>
                        </div>
                    </VCol>
                    <VCol cols="4">
                        <div class="tiggie-teacher-label">
                            <VIcon
                                icon="mdi-circle"
                                color="sun-yellow"
                                class="mr-2"
                            />
                            <span class="t-black"
                                >Allocated to teachers but not in use</span
                            >
                        </div>
                    </VCol>
                </VRow>
            </div>
            <div class="padding-block"></div>

            <VRow>
                <VCol
                    cols="6"
                    v-for="(teacher, index) in props.teachers"
                    :key="index"
                >
                    <TeacherStorageField
                        :key="index"
                        :data="teacher"
                        :left_storage="getAvaliableStorage()"
                    />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.fixed-progressbar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 100%;
    background-color: #fff; /* You can change the background color as needed */
    z-index: 1000; /* Adjust the z-index as necessary */
    padding: 10px; /* Add padding to the header if desired */
    padding-right: 165px;
    padding-left: 165px;
}
.padding-block {
    height: 250px;
}
</style>
