<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";
let props = defineProps(["flash", "auth", "classroom"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const deleteClassroom = (id) => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            router.delete(route("classrooms.destroy", id), {
                onSuccess: () => {
                    SuccessDialog({ title: flash?.successMessage });
                },
            });
        },
    });
};
const showCount = (classroom) => {
    return classroom?.students_count + "/" + classroom?.teachers_count;
};
let srcImage = computed(
    () =>
        props.classroom.classroom_photo ??
        "https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
);
const userImage = (user) => user.image_url ?? "/images/profile/profilefive.png";
</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
                <VRow>
                    <VCol cols="12" sm="6" md="6">
                        <div class="classroom">
                            <v-img src="/images/bg.png" cover></v-img>
                            <div class="overlay-container">
                                <v-img
                                    :src="srcImage"
                                    class="classroom-img"
                                ></v-img>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="6" class="marginadjust">
                        <div class="text-left">
                            <span class="font-weight-black classname">
                                {{ props.classroom?.name }}
                            </span>
                            <v-chip class="ml-5 spacing">
                                <span class="text-center pppangram-bold">
                                    {{ showCount(props.classroom) }}</span
                                >
                            </v-chip>
                        </div>
                        <br />
                        <br />
                        <br />

                        <span class="description pppangram-bold">{{
                            props.classroom?.description
                        }}</span>
                        <br />
                        <br />
                        <br />
                        <div>
                            <v-btn
                                prepend-icon="mdi-pencil"
                                varient="flat"
                                @click="
                                    () =>
                                        router.get(
                                            route(
                                                'editCopy',
                                                props.classroom.id
                                            )
                                        )
                                "
                                color="#16cab6"
                                class="textcolor pppangram-bold"
                                rounded
                            >
                                Edit
                            </v-btn>
                            <v-btn
                                @click="deleteClassroom(props.classroom.id)"
                                prepend-icon="mdi-trash-can-outline"
                                color="#ff6262"
                                class="ml-2 textcolor pppangram-bold"
                                varient="flat"
                                rounded
                            >
                                Delete
                            </v-btn>
                        </div>
                    </VCol>
                </VRow>
                <div class="mt-10">
                    <span class="span-text ruddy-bold">Teachers</span>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                            v-for="teacher in props.classroom.teachers"
                            :key="teacher.id"
                        >
                            <div>
                                <v-img
                                    :src="userImage(teacher)"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span
                                        class="label-text pppangram-bold nowrap"
                                        >{{ teacher.full_name }}</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        {{ teacher?.contact_number }}</span
                                    >
                                </div>
                                <!-- {{ teacher }} -->
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-15">
                    <VRow>
                        <VCol cols="6">
                            <span class="span-text ruddy-bold">Groups</span>
                        </VCol></VRow
                    >
                </div>
                <div v-for="group in props.classroom.groups" :key="group.index">
                    <div class="mt-5">
                        <VRow>
                            <VCol cols="6">
                                <span class="semi-label ruddy-bold">{{
                                    group.name
                                }}</span>
                            </VCol>
                        </VRow>
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                            v-for="student in group.students"
                            :key="student.id"
                        >
                            <div>
                                <v-img
                                    :src="userImage(student)"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold">{{
                                        student?.user?.full_name
                                    }}</span>
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        {{
                                            student?.user?.contact_number
                                        }}</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-15">
                    <div class="mt-5">
                        <span class="semi-label ruddy-bold"
                            >Student Without A Group</span
                        >
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                            v-for="student in props.classroom.students"
                            :key="student.student_id"
                        >
                            <div>
                                <v-img
                                    :src="userImage(student)"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold">{{
                                        student?.user?.full_name
                                    }}</span>
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        {{
                                            student?.user?.contact_number
                                        }}</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
            </VContainer>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.marginadjust {
    margin-top: 11%;
}

.classroom {
    position: relative;
}

.classroom-img {
    height: 300px !important;
    flex-shrink: 0 !important;
}

.overlay-container {
    //   z-index: 1;
    position: absolute;
    top: 8%;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.label-text {
    color: var(--graphite, #282828) !important;
    /* Body Style Large */
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 38px !important; /* 158.333% */
}

.label-text-two {
    color: #ff6262 !important;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.span-text {
    color: #000 !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.description {
    font-weight: bold !important;
    color: #000;
}

.profile-img {
    width: 180px;
    height: 180px;
    border-radius: 180px;
}

.spacing {
    color: #000;
    letter-spacing: 8px;
    height: 35px;
    border-radius: 100px;
    border: 1px solid #000 !important;
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(2px) !important;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.textcolor {
    color: #fff;
}

.classname {
    color: #000;
    font-size: 36px;
    font-style: normal;
    font-weight: bold;
    text-transform: capitalize;
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
