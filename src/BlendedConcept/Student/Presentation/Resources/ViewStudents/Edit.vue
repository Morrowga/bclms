<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StoryBookSlider from "./components/StoryBookSlider.vue";
import PlaylistSlider from "./components/PlaylistSlider.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";

import { Link, useForm } from "@inertiajs/vue3";

import { ref } from "vue";
import { SuccessDialog } from "@actions/useSuccess";

let props = defineProps(['student']);

const gender = [
    'Male',
    'Female'
]

let form = useForm({
    student_id: props.student.data.student_id,
    num_silver_coins: props.student.data.num_silver_coins,
    num_gold_coins: props.student.data.num_gold_coins,
    student_code: props.student.data.student_code,
    device_id: props.student.data.device_id,
    total_time_spent: props.student.data.total_time_spent,
    first_name: props.student.data.user.first_name,
    last_name: props.student.data.user.last_name,
    gender: props.student.data.gender,
    dob: props.student.data.dob,
    education_level: props.student.data.education_level,
    contact_number: props.student.data.user.contact_number,
    email: props.student.data.user.email,
    profile_pics: null,
    _method: 'PUT'
});
const isPasswordVisible = ref(false);

console.log(props.student.data.user.profile_pic);
const student = ref(props.student.data.user.profile_pic);
const dragging = ref(false);
const studentFile = ref(null);

const handleStudentChange = (event) => {
  const file = event.target.files[0];
  studentFile.value = file;
  student.value = URL.createObjectURL(file);
  console.log(profile.value);
};

const onDropStudent = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  student.value = URL.createObjectURL(files[0]);
  studentFile.value = files[0];
};

function checkURL(input) {
  if (input.includes('https://') && input.includes('http://')) {
    return input;
  } else if (input.includes('https://') || input.includes('http://')) {
    return input;
  } else {
    return '/' + input;
  }
}

const updateStudent = () => {
    form.profile_pics = studentFile.value
    form.post(route("teacher_students.update", props.student.data.student_id), {
        onSuccess: () => {
            SuccessDialog({ title: "You've successfully updated a student." });
        },
        onError: (error) => {
            form.setError("first_name", error?.first_name);
            form.setError("last_name", error?.last_name);
            form.setError("gender", error?.gender);
            form.setError("dob", error?.dob);
            form.setError("contact_number", error?.contact_number);
            form.setError("email", error?.email);
        },
    });
    // SuccessDialog({
    //     title: "You have successfully create a playlist!",
    //     color: "#17CAB6",
    // });
};


</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <VForm @submit.prevent="updateStudent">
                <v-row>
                    <VCol cols="6" class="pr-10">
                        <div
                            class="profile-drag"
                            :class="!student ? 'd-flex justify-center' : ''"
                            @dragover.prevent
                            @dragenter.prevent
                            @dragleave="dragging = false"
                            @drop.prevent="onDropStudent"
                        >
                            <div v-if="!student">
                                <div class="d-flex justify-center text-center">
                                    <v-img src="/images/Icons.png" width="80" height="80"></v-img>
                                </div>
                                <p class="pppangram-bold mt-5">
                                    Drag your item to upload
                                </p>
                                <p class="mt-2 blur-p">
                                    PNG, GIF, WebP, MP4 or MP3. Maximum file size 100 Mb.
                                </p>
                            </div>
                            <div v-else>
                                <v-img :src="checkURL(student)" class="profileimg" cover/>
                                <!-- <p>File Name: {{ gameFile.name }}</p> -->
                            <!-- <button @click="removeGameFile" class="remove-button">
                                Remove
                            </button> -->
                            </div>
                            <input
                            type="file"
                            style="display: none"
                            @change="handleStudentChange"
                            />
                        </div>
                    </VCol>
                    <!-- <v-col cols="12" md="6">
                        <v-img src="/images/student_pf.png" />
                    </v-col> -->
                    <v-col cols="12" md="6" class="pa-5">
                        <div class="d-flex justify-space-between align-center">
                            <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
                        </div>
                        <v-row>
                            <v-col cols="12" class="mt-10">
                                <p class="text-h5 font-weight-bold mb-0">
                                    Student Details
                                </p>
                            </v-col>
                            <v-col cols="6">
                                <p class="text-subtitle-1 mb-0">First Name</p>
                                <v-text-field
                                    v-model="form.first_name"
                                    placeholder="e.g. Wren Clark"
                                    variant="outlined"
                                    :rules="[requiredValidator]"  :error-messages="form?.errors?.first_name"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <p class="text-subtitle-1 mb-0">Last Name</p>
                                <v-text-field
                                    v-model="form.last_name"
                                    placeholder="e.g. Wren Clark"
                                    variant="outlined"
                                    :rules="[requiredValidator]"  :error-messages="form?.errors?.last_name"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Gender</p>
                                <v-select
                                    placeholder="Select"
                                    variant="outlined"
                                    :items="gender"
                                    v-model="form.gender"
                                    :rules="[requiredValidator]"  :error-messages="form?.errors?.gender"
                                >
                                </v-select>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Date of birth</p>
                                <AppDateTimePicker placeholder="Select End Date" v-model="form.dob" :rules="[requiredValidator]"  :error-messages="form?.errors?.dob"  density="compact" />
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Education Level</p>
                                <v-text-field
                                    v-model="form.education_level"
                                    placeholder="e.g K1"
                                    variant="outlined"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <!-- <v-row>
                            <v-col cols="12" class="mt-3">
                                <p class="text-h5 font-weight-bold mb-0">
                                    Parent Details
                                </p>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Fullname</p>
                                <v-text-field
                                    v-model="form.parent_fullname"
                                    placeholder="e.g. Fransico Maia"
                                    variant="outlined"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">
                                    Relationship To Child
                                </p>
                                <v-text-field
                                    v-model="form.relation_to_child"
                                    placeholder="e.g. Mother"
                                    variant="outlined"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Contact Number</p>
                                <v-text-field
                                    v-model="form.contact_number"
                                    placeholder="e.g. 9180003"
                                    variant="outlined"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Email Address</p>
                                <v-text-field
                                    v-model="form.login_email"
                                    placeholder="e.g. @fransico@gmail.com"
                                    variant="outlined"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <p class="text-subtitle-1 mb-0">Login Password</p>
                                <v-text-field
                                    v-model="form.login_password"
                                    variant="outlined"
                                    :type="isPasswordVisible ? 'text' : 'password'"
                                    :append-inner-icon="
                                        isPasswordVisible
                                            ? 'mdi-eye-off-outline'
                                            : 'mdi-eye-outline'
                                    "
                                    @click:append-inner="
                                        isPasswordVisible = !isPasswordVisible
                                    "
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-tabs v-model="tab">
                                    <v-tab value="learning">Learning Need</v-tab>
                                    <v-tab value="disability"
                                        >Disability Types</v-tab
                                    >
                                </v-tabs>

                                <div>
                                    <v-window v-model="tab">
                                        <v-window-item value="learning">
                                            <ChipWithBlueDot
                                                v-for="item in 5"
                                                :key="item"
                                                title="Dyslexia"
                                            />
                                        </v-window-item>

                                        <v-window-item value="disability">
                                            <ChipWithBlueDot
                                                v-for="item in 5"
                                                :key="item"
                                                title="Disability"
                                            />
                                        </v-window-item>
                                    </v-window>
                                </div>
                            </v-col>
                        </v-row> -->
                    </v-col>
                    <v-col cols="12">
                        <div class="d-flex justify-center">
                            <Link :href="route('teacher_students.show', props.student.data.student_id)">
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
                                >Update</v-btn
                            >
                        </div>
                    </v-col>
                </v-row>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>

.blur-p{
    color: var(--Secondary2, rgba(86, 86, 96, 0.40));
    text-align: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px; /* 157.143% */
    text-transform: capitalize;
}

.profile-drag {
  align-items: center;
  text-align: center;
  width: 100%;
  background: #f7f7f7;
  height: 440px;
  border: 1px solid rgb(182,182,186, 0.6);
  border-radius: 10px;
}
.profileimg{
    object-fit: cover !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
  margin-bottom: 0;
}
</style>
