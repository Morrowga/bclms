<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { onMounted, ref } from "vue";
import LargeDropFile from "@mainRoot/components/LargeDropFile/LargeDropFile.vue";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import { FlashMessage } from "@actions/useFlashMessage";

const props = defineProps([
    "learningNeeds",
    "disability_types",
    "organisations_student",
]);
let flash = computed(() => usePage().props.flash);

const form = useForm({
    student_id: props.organisations_student.student_id,
    user_id: "",
    parent_id: "",
    first_name: "",
    last_name: "",
    gender: "",
    dob: "",
    contact_number: "",
    num_gold_coins: props.organisations_student.num_gold_coins,
    num_silver_coins: props.organisations_student.num_silver_coins,
    email: "",
    education_level: "",
    profile_pics: "",
    learning_needs: [],
    disability_types: [],
    parent_first_name: "",
    parent_last_name: "",
    login_username: "",
    _method: "PUT",
});

let refForm = ref();

const gender = ref(["Male", "Female"]);
let tab = ref(null);
const createStudent = () => {
    console.log(form);
    form.post(
        route(
            "organisations-student.update",
            props.organisations_student.student_id
        ),
        {
            onSuccess: () => {
                FlashMessage({ flash });
            },
            onError: (error) => {
                console.log(error);
            },
        }
    );
};

onMounted(() => {
    form.email = props.organisations_student.user.email;
    form.user_id = props.organisations_student.user_id;
    form.parent_id = props.organisations_student.parent_id;
    form.email = props.organisations_student?.parent?.user?.email;
    form.contact_number =
        props.organisations_student.parent?.user?.contact_number;
    form.first_name = props.organisations_student.user.first_name;
    form.last_name = props.organisations_student.user.last_name;
    form.gender = props.organisations_student.gender;
    form.dob = props.organisations_student.dob;
    form.education_level = props.organisations_student.education_level;
    form.education_level = props.organisations_student.education_level;
    form.education_level = props.organisations_student.education_level;
    form.login_username = props.organisations_student.user.username;
    form.learning_needs = props.organisations_student?.learningneeds.map(
        (learn) => learn.id
    );
    form.disability_types = props.organisations_student?.disability_types.map(
        (dis) => dis.id
    );
    form.parent_first_name =
        props.organisations_student?.parent?.user?.first_name;
    form.parent_last_name =
        props.organisations_student?.parent?.user?.last_name;
});
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-form ref="refForm" @submit.prevent="createStudent">
                <v-row>
                    <v-col cols="12" md="6">
                        <LargeDropFile
                            v-model="form.profile_pics"
                            :old_photo="organisations_student.user?.profile_pic"
                        />
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
                                <p class="text-subtitle-1 mb-0 required">
                                    Date of birth
                                </p>
                                <v-text-field
                                    v-model="form.dob"
                                    placeholder="e.g January 24, 2010"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.dob"
                                >
                                </v-text-field>
                            </v-col>
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
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0 required">
                                    Login Username
                                </p>
                                <v-text-field
                                    v-model="form.login_username"
                                    placeholder="e.g wren_clerk_1"
                                    variant="outlined"
                                    :rules="[requiredValidator]"
                                    :error-messages="
                                        form?.errors?.login_username
                                    "
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
                                                    v-for="item in disability_types"
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
