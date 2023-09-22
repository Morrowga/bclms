<script setup>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { router } from "@inertiajs/core";
let props = defineProps(['teacher']);
const deleteTeacher = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete(id, {
                onSuccess: () => {},
            });
        },
    });
};
</script>
<template>
    <AdminLayout>
        <v-container>
            <v-row justify="center">
                <v-col cols="6">
                    <VImg :src="props.teacher.data.profile_pic" />
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
                                            'organizations-teacher.edit', props.teacher.data.id
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
                            <v-btn
                                variant="flat"
                                rounded
                                color="error"
                                @click="deleteTeacher(props.teacher.data.id)"
                            >
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
                            <p class="tiggie-p">{{  props.teacher.data.first_name + ' ' + props.teacher.data.last_name  }}</p>
                        </v-col>
                        <v-col cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Work Email</h6>
                            <p class="tiggie-p">{{  props.teacher.data.email }}</p>
                        </v-col>
                        <v-col cols="12" class="py-2">
                            <h6 class="tiggie-small-label">Contact Number</h6>
                            <p class="tiggie-p">{{ props.teacher.data.contact_number }}</p>
                        </v-col>
                    </v-row>
                    <!-- contact user plan -->
                </v-col>
            </v-row>
            <v-row justify="center">
                <v-col cols="2">
                    <Link :href="route('organizations-teacher.index')">
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
