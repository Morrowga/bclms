<script setup>
import { ref, defineProps, defineEmits } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import StudentProfile from "./components/StudentInfo.vue";
import { router } from "@inertiajs/core";

let props = defineProps(["students"]);

// console.log(props.students);
</script>
<template>
    <section>
        <div class="navbar">
            <div class="d-flex justify-space-between mx-15">
                <div class="mx-15">
                    <Link
                        href="/home"
                        v-if="!is_drawer"
                        class="d-none d-md-flex align-center"
                    >
                        <img
                            src="/images/logowhite.png"
                            width="200"
                            height="55"
                        />
                    </Link>
                </div>
                <div class="mx-15 mt-1">
                    <img
                        src="/images/Tiggie Face Blue.png"
                        width="80"
                        height="55"
                    />
                </div>
            </div>
        </div>
        <VContainer>
            <div class="d-flex justify-center mt-5">
                <img src="/images/logowhite.png">
            </div>
            <VCard class="mx-15 learning-card">
                <VCardText>
                    <div class="text-center">
                        <span class="head-text ruddy-bold whoislearning"
                            >Who is learning</span
                        >
                        <div class="students mx-15 my-10">
                            <VRow cols="12">
                                <VCol
                                    cols="4"
                                    class="pe-2"
                                    v-for="item in props.students"
                                    :key="item"
                                >
                                    <div class="studentprofile-card">
                                        <StudentProfile class="py-10"
                                            :studentInfo="{
                                                id: item.student_id,
                                                name: item.user.full_name,
                                                contact_number:
                                                    item.parent?.user
                                                        ?.contact_number,
                                                img: item.user.profile_pic == null ? 'https://ui-avatars.com/api/?size=128&name=' + item?.user?.full_name : item.user.profile_pic,
                                                user_id: item.user_id,
                                            }"
                                        />
                                    </div>
                                    <h4 class="studentprofile-fullname mt-5">{{  item.user.full_name }}</h4>
                                </VCol>
                            </VRow>
                        </div>
                    </div>
                </VCardText>
            </VCard>

            <div class="d-flex justify-center my-10">
                <VBtn
                    @click="() => router.get(route('dashboard'))"
                    class="settingbtn"
                >
                    <span class="ruddy-bold"> Enter Setting Page </span>
                </VBtn>
            </div>
        </VContainer>
    </section>
</template>
<style scoped>
section {
    background: url("/images/learningportal.png") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    height: 830px;
}

.learning-card {
    background: transparent;
    margin-top: 0%;
    box-shadow: none !important;
    /* border: 4px solid #fff; */
}

.settingbtn {
    border: 3px solid #fff;
    background: rgba(247, 255, 254, 0.31) !important;
    height: 50px;
    color: #000 !important;
    border: 0px solid #000;
    border-radius: 16px;
}

.head-text {
    font-size: 30px !important;
    color: #fff;
}

.navbar {
    background: #000;
    padding: 3px;
}

.studentprofile-card{
    /* border: 2px solid #000000; */
    background: rgba(0, 0, 0, 0.5); /* Adjust the last parameter for opacity (0 to 1) */
    border-radius: 20px;
    padding: 5px;
}

.whoislearning{
    margin-left: 13vh;
}

.studentprofile-fullname{
    color: #fff;
    font-size: 30px !important;
}
</style>
