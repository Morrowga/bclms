<script setup>
import StudentProfile from "./components/StudentInfo.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StoryBookSlider from "./components/StoryBookSlider.vue";
import PlaylistSlider from "./components/PlaylistSlider.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { ref } from "vue";
import { format } from "date-fns";
import { checkPermission } from "@actions/useCheckPermission";

let tab = ref(null);
let props = defineProps(["student"]);
const form = useForm({});

const deleteStudent = () => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            form.delete(
                route(
                    "organisations-student.destroy",
                    props.student.data.student_id
                ),
                {
                    onSuccess: () => {
                        SuccessDialog({
                            title: "You have successfully deleted student!",
                            color: "#17CAB6",
                        });
                    },
                    onError: () => {
                        console.log(error);
                    },
                }
            );
        },
    });
};

const formatDate = (dateString) => {
    // Parse the date string into a Date object
    const date = new Date(dateString);

    // Format the date using date-fns with the custom format
    return format(date, "MMMM d, yyyy"); // "MMMM" for full month name, "d" for day, "yyyy" for year
};

// function checkURL(input) {
//     if (input.includes("https://") && input.includes("http://")) {
//         return input;
//     } else if (input.includes("https://") || input.includes("http://")) {
//         return input;
//     } else {
//         return "/" + input;
//     }
// }
</script>
<template>
    <AdminLayout>
        <VContainer class="width-80">
            <v-row>
                <v-col cols="12" md="6">
                    <v-img
                        :src="
                            props.student.data.user.profile_pic == ''
                                ? '/images/teacherimg.png'
                                : props.student.data.user.profile_pic
                        "
                    />

                    <div class="d-flex justify-center my-4">
                        <Link
                            :href="
                                route(
                                    'teacher_students.kidmode',
                                    props.student.data.user_id
                                )
                            "
                        >
                            <v-btn
                                variant="flat"
                                rounded
                                color="#FF8015"
                                class="text-white"
                                >Enter Kids Mode</v-btn
                            >
                        </Link>
                    </div>
                </v-col>
                <v-col cols="12" md="6" class="pa-5">
                    <div class="d-flex justify-space-between align-center">
                        <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
                        <div>
                            <Link
                                :href="
                                    route(
                                        'teacher_students.edit',
                                        props.student.data.student_id
                                    )
                                "
                            >
                                <v-btn
                                    v-if="
                                        checkPermission('edit_teacherStudent')
                                    "
                                    variant="flat"
                                    rounded
                                    color="#17CAB6"
                                    prepend-icon="mdi-pencil"
                                    class="mr-4 text-white"
                                    >Edit</v-btn
                                >
                            </Link>
                            <v-btn
                                v-if="checkPermission('delete_teacherStudent')"
                                variant="flat"
                                rounded
                                color="error"
                                prepend-icon="mdi-trash"
                                @click="deleteStudent()"
                                >Delete</v-btn
                            >
                        </div>
                    </div>
                    <v-row>
                        <v-col cols="12" class="mt-10">
                            <p class="text-h5 font-weight-bold mb-0">
                                Student Details
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Fullname</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{ props.student.data.user.full_name }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Gender</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{ props.student.data.gender }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Date of birth</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{ formatDate(props.student.data.dob) }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Education Level</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{ props.student.data.education_level }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Parent's First Name
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{
                                    props.student.data?.parent?.user?.first_name
                                }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Parent's Last Name
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{
                                    props.student.data?.parent?.user?.last_name
                                }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Parent's Contact Number
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{
                                    props.student.data?.parent?.user
                                        ?.contact_number
                                }}
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Parent's Email Address
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">
                                {{ props.student.data?.parent?.user?.email }}
                            </p>
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
                            <p class="text-h6 font-weight-bold mx-4">
                                Francisco Maia
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">
                                Relationship To Child
                            </p>
                            <p class="text-h6 font-weight-bold mx-4">Mother</p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Contact Number</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                9872333243
                            </p>
                        </v-col>
                        <v-col cols="12">
                            <p class="text-subtitle-1 mb-0">Email Address</p>
                            <p class="text-h6 font-weight-bold mx-4">
                                francisco@gmail.com
                            </p>
                        </v-col>
                    </v-row> -->
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
                                            v-for="item in props.student.data
                                                .learningneeds"
                                            :key="item"
                                            :title="item.name"
                                        />
                                    </v-window-item>

                                    <v-window-item value="disability">
                                        <ChipWithBlueDot
                                            v-for="item in props.student.data
                                                .disability_types"
                                            :key="item"
                                            :title="item.name"
                                        />
                                    </v-window-item>
                                </v-window>
                            </div>
                        </v-col>

                        <v-col cols="12">
                            <div>
                                <Link
                                    :href="
                                        route(
                                            'teacher_students.profiling_surveys',
                                            props.student.data.user.id
                                        )
                                    "
                                >
                                    <v-btn
                                        variant="flat"
                                        rounded
                                        color="#FF8015"
                                        class="mr-4 text-white"
                                        >Do/Redo Profiling Survey</v-btn
                                    >
                                </Link>
                                <Link
                                    :href="
                                        route(
                                            'set_accessibility_device.index',
                                            props.student.data.student_id
                                        )
                                    "
                                >
                                    <v-btn
                                        variant="flat"
                                        rounded
                                        color="#FF8015"
                                        class="text-white"
                                        >Set Accessibility Device</v-btn
                                    >
                                </Link>
                            </div>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </VContainer>
        <div class="storybooks-assign mb-4">
            <VContainer class="header width-80">
                <div class="d-flex justify-space-between align-center mb-4">
                    <h1 class="text-h4 font-weight-bold">
                        Storybooks Assigned to Student
                    </h1>
                    <v-spacer></v-spacer>

                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                    ></v-text-field>
                </div>
                <StoryBookSlider :datas="props.student.data.book_versions" />
            </VContainer>
            <div></div>
        </div>

        <div class="playlist">
            <VContainer class="header width-80">
                <div class="d-flex justify-space-between align-center mb-4">
                    <h1 class="text-h4 font-weight-bold">Playlists</h1>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        class="mr-4"
                    ></v-text-field>
                </div>
                <PlaylistSlider :datas="props.student.data.playlists" />
            </VContainer>
            <div></div>
        </div>
    </AdminLayout>
</template>
<style scoped></style>
