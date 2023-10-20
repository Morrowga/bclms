<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { ref } from "vue";
// import ImageUpload from "@Composables/ImageUpload.vue";
import LargeDropFile from "@mainRoot/components/LargeDropFile/LargeDropFile.vue";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
const props = defineProps(["learningNeeds", "disabilityTypes"]);
let flash = computed(() => usePage().props.flash);
const form = useForm({
    first_name: "",
    last_name: "",
    gender: "",
    dob: "",
    contact_number: "",
    email: "",
    education_level: "",
    profile_pics: "",
    parent_first_name: "",
    parent_last_name: "",
    learning_needs: [],
    disability_types: [],
});

let refForm = ref();

const gender = ref(["Male", "Female"]);
let tab = ref(null);
const createStudent = () => {
    form.post(route("organisations-student.store"), {
        onSuccess: () => {
            if (flash.value.errorMessage) {
                SuccessDialog({
                    title: flash.value.errorMessage,
                    mainTitle: "Error!",
                    color: "#ff6262",
                    icon: "error",
                });
            } else {
                SuccessDialog({
                    title: flash.value.successMessage,
                    color: "#17CAB6",
                });
            }
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-form ref="refForm" @submit.prevent="createStudent">
                <v-row>
                    <v-col cols="12" md="6">
                        <LargeDropFile v-model="form.profile_pics" />
                    </v-col>
                    <v-col cols="12" md="6" class="pa-5">
                        <div class="d-flex justify-space-between align-center">
                            <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
                        </div>
                        <v-row>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    First Name
                                </p>
                                <v-text-field
                                    v-model="form.first_name"
                                    placeholder="e.g. Wren"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.first_name"
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Last Name
                                </p>
                                <v-text-field
                                    v-model="form.last_name"
                                    placeholder="e.g. Clark"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.last_name"
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Gender
                                </p>
                                <v-select
                                    placeholder="Select"
                                    v-model="form.gender"
                                    :items="gender"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.gender"
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">
                                    Date of birth
                                </p>
                                <AppDateTimePicker
                                    placeholder="Select End Date"
                                    v-model="form.dob"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.dob"
                                    density="compact"
                                />
                            </v-col>
                            <!-- <v-col cols="12">
                <p class="text-subtitle-1 mb-0 required">Date of birth</p>
                <v-text-field
                  v-model="form.dob"
                  placeholder="e.g January 24, 2010"
                  variant="outlined"
                  :rules="[requiredValidator]"
                  :error-messages="form?.errors?.dob"
                >
                </v-text-field>
              </v-col> -->
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Education Level
                                </p>
                                <v-text-field
                                    v-model="form.education_level"
                                    placeholder="e.g K1"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.education_level
                                    "
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Parent's Contact Number
                                </p>
                                <v-text-field
                                    type="number"
                                    v-model="form.contact_number"
                                    placeholder="e.g. 9180003"
                                    variant="outlined"
                                    :rules="[
                                        requiredValidator,
                                        integerValidator,
                                    ]"
                                    :error-messages="
                                        form?.errors?.contact_number
                                    "
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Parent's First Name
                                </p>
                                <v-text-field
                                    v-model="form.parent_first_name"
                                    placeholder="e.g. Mary"
                                    variant="outlined"
                                    :rules="[]"
                                    :error-messages="
                                        form?.errors?.parent_first_name
                                    "
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Parent's Last Name
                                </p>
                                <v-text-field
                                    v-model="form.parent_last_name"
                                    placeholder="e.g. Smith"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.parent_last_name
                                    "
                                />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Parent's Email Address
                                </p>
                                <v-text-field
                                    v-model="form.email"
                                    placeholder="e.g. @fransico@gmail.com"
                                    variant="outlined"
                                    :rules="[requiredValidator, emailValidator]"
                                    :error-messages="form?.errors?.email"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-tabs v-model="tab">
                                    <v-tab value="learning"
                                        >Learning Need</v-tab
                                    >
                                    <v-tab value="disability"
                                        >Disability Types</v-tab
                                    >
                                </v-tabs>
                                <div>
                                    <v-window v-model="tab">
                                        <v-window-item value="learning">
                                            <v-chip-group
                                                filter
                                                v-model="form.learning_needs"
                                                multiple
                                                column
                                            >
                                                <v-chip
                                                    v-for="item in learningNeeds"
                                                    variant="outlined"
                                                    :key="item.id"
                                                    :value="item.id"
                                                >
                                                    {{ item.name }}
                                                </v-chip>
                                            </v-chip-group>
                                        </v-window-item>

                                        <v-window-item value="disability">
                                            <v-chip-group
                                                filter
                                                v-model="form.disability_types"
                                                multiple
                                                column
                                            >
                                                <v-chip
                                                    v-for="item in props.disabilityTypes"
                                                    variant="outlined"
                                                    :key="item.id"
                                                    :value="item.id"
                                                >
                                                    {{ item.name }}
                                                </v-chip>
                                            </v-chip-group>
                                        </v-window-item>
                                    </v-window>
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12">
                        <div class="d-flex justify-center">
                            <Link :href="route('organisations-teacher.index')">
                                <v-btn
                                    variant="flat"
                                    rounded
                                    class="mr-4 text-primary"
                                    width="200"
                                    color="rgba(55, 73, 233, 0.10)"
                                    >Cancel</v-btn
                                >
                            </Link>
                            <v-btn
                                type="submit"
                                variant="flat"
                                rounded
                                width="200"
                                color="primary"
                                class="text-white"
                                >Save</v-btn
                            >
                        </div>
                    </v-col>
                </v-row>
            </v-form>
        </VContainer>
    </AdminLayout>
</template>
<style scoped></style>
