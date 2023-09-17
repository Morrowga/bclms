<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import AddProfillingSurvey from "./components/AddProfillingSurvey.vue";
import { ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
let tab = ref(false);
let isSurveryAdd = ref(false);
let addSurveyForm = ref([]);
const checkUserRole = () => {
    return user_role.value == "BC Super Admin" || user_role.value == "BC Staff";
};
const openDialog = () => {
    isSurveryAdd.value = !isSurveryAdd.value;
};
const handleModelSubmit = () => {

    // SuccessDialog({ title: "You've successfully added question" });
};
</script>
<template>
    <AdminLayout>
        <VContainer :fluid="checkUserRole()">
            <v-row>
                <v-col
                    cols="12"
                    md="12"
                    class="d-flex justify-space-between align-center"
                >
                    <div>
                        <h1 class="tiggie-title mb-4">Profilling Survey</h1>
                        <span class="text-subtitle-1"
                            >Answer these questions to identify the best
                            educational pathway for the student's unique needs
                            and abilities.</span
                        >
                    </div>
                    <div>
                        <VBtn @click="openDialog">Add New</VBtn>
                    </div>
                </v-col>
                <v-col cols="12" md="12">
                    <div v-if="addSurveyForm.length > 0">
                        <Vcol cols="12" v-for="(item, i) in addSurveyForm" :key="i">
                            <VCard style="width:81vw" class="mt-4">
                                <VCardTitle class="tiggie-subtitle">
                                    <div class="d-flex justify-space-between">
                                        <div>
                                            Question {{ i + 1 }} . {{ item.question_type }}
                                        </div>
                                        <div>
                                            <v-menu>
                                                <template v-slot:activator="{ props }">
                                                    <div class="cursor-pointer"
                                                    v-bind="props"
                                                    >
                                                    ...
                                                    </div>
                                                </template>
                                                <v-list>
                                                    <v-list-item>
                                                        <v-list-item-title class="px-5 cursor-pointer" @click="openEditSurveyForm(item.id)">Edit</v-list-item-title>
                                                        <v-spacer></v-spacer>
                                                        <v-list-item-title class="px-5 mt-2 cursor-pointer" @click="deleteSurveyForm(item.id)">Delete</v-list-item-title>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>
                                        </div>
                                    </div>
                                </VCardTitle>
                                <VCardSubTitle class="pl-4 tiggie-p">
                                    {{item.question}}
                                </VCardSubTitle>
                                <VDivider />
                                <VCardText>
                                    <VRow no-gutters justify="start">
                                        <VCol cols="1">
                                            <h4 class="tiggie-subtitle">Options</h4>
                                        </VCol>
                                        <VCol cols="4" style="text-align: left;" class="mb-10">
                                            <VList>
                                                <VListItem v-for="(option, i) in item.options" :key="i">
                                                    <template #prepend>
                                                        <VIcon :icon="'mdi-circle-small'" />
                                                    </template>
                                                    <VListItemTitle class="tiggie-p">
                                                        {{ option }}
                                                    </VListItemTitle>
                                                </VListItem>
                                            </VList>
                                        </VCol>
                                    </VRow>
                                </VCardText>
                            </VCard>
                        </Vcol>
                    </div>
                </v-col>
                <!-- <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 2:</span
                    >
                    <span class="text-h6 t-black">
                        How would you rate the student's overall level of
                        independence in daily activities? (Choose one option)
                        *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly independent - The student can complete most activities with minimal assistance"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderately independent - The student requires some support but can handle many activities independently"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Partially independent - The student needs significant assistance in several activities"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Highly dependent - The student relies heavily on others for daily activities"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 3:</span
                    >
                    <span class="text-h6 t-black">
                        In the academic setting, what specific challenges does
                        the student face due to their special needs? (Please
                        select all that apply) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with reading or comprehension"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Challenges with writing or fine motor skills
"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Trouble with focus and attention"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Social interaction difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Sensory sensitivities or sensory processing issues"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Communication challenges"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Physical mobility limitations"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Emotional regulation or self-regulation difficulties"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-checkbox
                                label="Difficulty with organization and time management"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12" md="12">
                    <span class="text-h5 font-weight-bold t-black"
                        >Question 4:</span
                    >
                    <span class="text-h6 t-black">
                        How does the student respond to changes in their routine
                        or unexpected situations? (Choose one option) *</span
                    >
                    <br />
                    <br />

                    <v-row>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Adapts well - The student shows flexibility and copes effectively with changes"
                                value="1"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Moderate response - The student may experience some initial discomfort but can adjust with support"
                                value="2"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Difficulty adapting - The student struggles with changes and may need significant reassurance and guidance"
                                value="3"
                            ></v-radio>
                        </v-col>
                        <v-col cols="12" md="12">
                            <v-radio
                                label="Severe response - The student becomes highly distressed and requires intensive support to navigate changes"
                                value="4"
                            ></v-radio>
                        </v-col>
                    </v-row>
                </v-col>
                <br />
                <v-col cols="12"> </v-col> -->
            </v-row>
        </VContainer>
        <AddProfillingSurvey v-model:isDialogVisible="isSurveryAdd"
        @submit="handleModalSubmit" />
    </AdminLayout>
</template>
<style scoped></style>
