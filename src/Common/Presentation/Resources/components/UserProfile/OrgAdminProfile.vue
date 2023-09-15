<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
</script>
<template>
    <AdminLayout>
        <v-container>
            <v-row justify="center">
                <v-col cols="6">
                    <VImg src="/images/teacherimg.png" />
                </v-col>
                <v-col cols="6">
                    <v-text class="teacherprofile-title">Profile</v-text>
                    <div class="d-flex justify-space-between mt-10">
                        <h1 class="tiggie-label fs-20">Personal Details</h1>
                        <div class="d-flex align-center gap-10">
                            <v-btn variant="flat" rounded color="teal">
                                <Link
                                    :href="
                                        route(
                                            'org_view_teacher_student.teacher.edit'
                                        )
                                    "
                                >
                                    <VIcon
                                        icon="mdi-pencil-outline"
                                        class="text-white mr-2"
                                    ></VIcon>
                                    <span class="text-white">Edit</span>
                                </Link>
                            </v-btn>
                            <v-btn variant="flat" rounded color="error">
                                <VIcon
                                    icon="mdi-trash-outline"
                                    class="text-white mr-2"
                                ></VIcon>
                                <span class="text-white">Delete</span>
                            </v-btn>
                        </div>
                    </div>
                    <v-row>
                        <v-col cols="12" class="py-2">
                            <h6 class="tiggie-small-label">FullName</h6>
                            <p class="tiggie-p">Tyler Covington</p>
                        </v-col>
                        <v-col cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Work Email</h6>
                            <p class="tiggie-p">tyler.covington@work.sg</p>
                        </v-col>
                        <v-col cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Contact Number</h6>
                            <p class="tiggie-p">9123 4567</p>
                        </v-col>
                    </v-row>
                    <!-- contact user plan -->
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="2">
                    <Link :href="route('org_view_teacher_student.index')">
                        <v-btn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-primary">Back</span>
                        </v-btn>
                    </Link>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>

<style scoped>
.teacherprofile-title {
    color: var(--text, #161616);
    /* H3 Ruddy */
    font-family: Ruddy;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    text-transform: capitalize !important;
}
</style>
