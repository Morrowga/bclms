<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
const props = defineProps(["surveyresponse"]);
const selectedValue = ref(null);
onMounted(() => {
    let ids = [];
    const data = props.surveyresponse.question.options.filter((option) => {
        props.surveyresponse.options.map((ans_option) => {
            if (ans_option.id == option.id) {
                ids.push(option.id);
            }
        });
    });
    if (
        props.surveyresponse.question.question_type == "MULTIPLE_RESPONSE" ||
        props.surveyresponse.question.question_type == "RATING"
    ) {
        selectedValue.value = ids;
    } else {
        selectedValue.value = props.surveyresponse.options?.[0]?.id;
    }
});
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex">
                <h1 class="tiggie-title mb-4">
                    {{ surveyresponse.survey.title }}
                </h1>
                <v-spacer></v-spacer>
                <span class="mt-2 survey_name font-weight-bold">{{
                    surveyresponse.user.full_name
                }}</span>
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
            </div>
            <v-row>
                <v-col cols="12" md="12">
                    <!-- {{ surveyresponse.question.question }} -->
                    <v-card
                        v-if="
                            surveyresponse.question.question_type ==
                            'SINGLE_CHOICE'
                        "
                    >
                        <v-card-title>
                            <span class="h3 font-weight-bold"
                                >Question {{ 1 }} .</span
                            >
                            <span>{{
                                surveyresponse.question.question_type
                            }}</span>
                        </v-card-title>
                        <v-card-subtitle class="pb-2">
                            {{ surveyresponse.question.question }}
                        </v-card-subtitle>
                        <v-divider class="border-opacity-100"></v-divider>
                        <v-card-text>
                            <div class="d-flex">
                                <span class="h4 font-weight-bold pt-2 pr-3"
                                    >Options:
                                </span>
                                <div>
                                    <v-radio-group v-model="selectedValue">
                                        <v-radio
                                            v-for="option in surveyresponse
                                                .question.options"
                                            :key="option.id"
                                            :label="option.content"
                                            :value="option.id"
                                        ></v-radio>
                                    </v-radio-group>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>

                    <v-card
                        v-if="
                            surveyresponse.question.question_type ==
                                'MULTIPLE_RESPONSE' ||
                            surveyresponse.question.question_type == 'RATING'
                        "
                    >
                        <v-card-title>
                            <span class="h3 font-weight-bold"
                                >Question {{ 1 }} .</span
                            >
                            <span>{{
                                surveyresponse.question.question_type
                            }}</span>
                        </v-card-title>
                        <v-card-subtitle class="pb-2">
                            {{ surveyresponse.question.question }}
                        </v-card-subtitle>
                        <v-divider class="border-opacity-100"></v-divider>
                        <v-card-text>
                            <div class="d-flex">
                                <span class="h4 font-weight-bold pt-2 pr-3"
                                    >Options:
                                </span>
                                <div>
                                    <v-checkbox
                                        class="custom-checkbox"
                                        v-for="option in surveyresponse.question
                                            .options"
                                        :key="option.id"
                                        :label="option.content"
                                        :value="option.id"
                                        v-model="selectedValue"
                                    ></v-checkbox>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>

                    <v-card
                        v-else-if="
                            surveyresponse.question.question_type ==
                            'SHORT_ANSWER'
                        "
                    >
                        <v-card-title>
                            <span class="h3 font-weight-bold"
                                >Question {{ 1 }} .</span
                            >
                            <span>{{
                                surveyresponse.question.question_type
                            }}</span>
                        </v-card-title>
                        <v-card-subtitle class="pb-2">
                            {{ surveyresponse.question.question }}
                        </v-card-subtitle>
                        <v-divider class="border-opacity-100"></v-divider>
                        <v-card-text>
                            <div class="d-flex">
                                <div>{{ surveyresponse.answer }}</div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.survey_name {
    font-size: 26px !important;
}
</style>
