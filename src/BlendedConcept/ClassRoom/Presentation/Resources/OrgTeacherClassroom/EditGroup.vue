<script setup>
import TotalStudents from "./components/TotalStudents.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";

import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm, usePage } from "@inertiajs/vue3";

const addGroup = () => {
    SuccessDialog({
        title: "You have successfully added a group!",
        color: "#17CAB6",
    });
};
const props = defineProps(["students", "classroom_group"]);
let flash = computed(() => usePage().props.flash);
const isFormValid = ref(false);
let refForm = ref();
const form = useForm({
    name: "",
    classroom_id: "",
    students: [],
    _method: "PUT",
});
const handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(
                route("org-teacher-classroom.update-group", {
                    classroom_group: props.classroom_group.id,
                }),
                {
                    onSuccess: () => {
                        SuccessDialog({ title: flash?.successMessage });
                    },
                    onError: (error) => {},
                }
            );
        }
    });
};

onMounted(() => {
    form.classroom_id = props.classroom_group.classroom_id;
    form.name = props.classroom_group.name;
    form.students = props.classroom_group.students.map(
        (student) => student.student_id
    );
});
</script>
<template>
    <AdminLayout>
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
            @keydown.enter="$event.preventDefault()"
        >
            <VContainer>
                <div>
                    <span class="semi-label-head ruddy-bold"
                        >Update A Group</span
                    >
                    <p class="text-subtitle-1">
                        Each student in a classroom is limited to being part of
                        just one group.
                    </p>
                </div>
                <VLabel class="semi-label ruddy-bold required mb-2"
                    >Group Name</VLabel
                >
                <div class="d-flex justify-end align-center mb-4">
                    <v-text-field
                        density="compact"
                        label="Search"
                        append-inner-icon="mdi-magnify"
                        single-line
                        rounded
                        hide-details
                        v-model="form.name"
                        class="mr-4"
                    ></v-text-field>
                </div>
                <VLabel class="semi-label ruddy-bold required mb-2"
                    >Select Students</VLabel
                >
                <div class="d-flex justify-end align-center mb-4">
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
                <v-row>
                    <v-col cols="12">
                        <TotalStudents
                            :students="props.students"
                            :form="form"
                        />
                    </v-col>
                </v-row>
                <br />
                <div class="d-flex justify-center gap-10">
                    <SecondaryBtn
                        title="Cancel"
                        :route="
                            route(
                                'org-teacher-classroom.show',
                                props.classroom_group.classroom_id
                            )
                        "
                    />
                    <PrimaryBtn title="Save" :isLink="false" type="submit" />
                </div>
            </VContainer>
        </VForm>
    </AdminLayout>
</template>
<style scoped>
.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}
.semi-label-head {
    color: var(--graphite, #282828) !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}
</style>
