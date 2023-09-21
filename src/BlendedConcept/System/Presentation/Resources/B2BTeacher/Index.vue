<script setup>
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import UserExperienceSurvey from "./components/UserExperienceSurvey.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import ClassroomCard from "@mainRoot/components/ClassroomCard/ClassroomCard.vue";
</script>

<template>
    <section>
        <VContainer>
            <!-- <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            />
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            />
            <SystemErrorAlert
                sytemErrorMessage="Something is wrong"
                v-if="true"
            /> -->
            <VRow>
                <VCol cols="12" sm="12" lg="12">
                    <div class="header d-flex justify-space-between">
                        <h1 class="tiggie-title">Classrooms</h1>
                    </div>
                    <div class="mt-5">
                        <v-row>
                            <v-col
                                v-for="n in 8"
                                :key="n"
                                cols="12"
                                sm="6"
                                md="4"
                                lg="3"
                            >
                                <ClassroomCard
                                    :route="route('showCopy', n)"
                                    count="5 / 5"
                                    :label="`${n}A`"
                                />
                            </v-col>
                        </v-row>
                    </div>
                </VCol>
                <VCol cols="12" sm="12" lg="12" class="mt-10">
                    <div class="header">
                        <div class="d-flex justify-end mb-4">
                            <h1 class="tiggie-title">Student</h1>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>
                            <VTextField
                                placeholder="Search User ..."
                                density="compact"
                                class="mr-4"
                            />

                            <SelectBox
                                label="Sort By"
                                :datas="[]"
                                density="compact"
                            />
                        </div>
                        <VRow no-gutters>
                            <v-col v-for="n in 12" :key="n">
                                <StudentAvatar
                                    image="/images/student.png"
                                    title="Wren Clark"
                                    phone_number="9111 1112"
                                    route="#"
                                />
                            </v-col>
                        </VRow>
                        <VRow class="d-flex justify-center align-center">
                            <Pagination />
                        </VRow>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
        <UserExperienceSurvey />
    </section>
</template>

<style></style>
