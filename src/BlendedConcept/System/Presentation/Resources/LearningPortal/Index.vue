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
            <VCard class="mx-15 learning-card">
                <VCardText>
                    <div class="text-center">
                        <span class="head-text ruddy-bold"
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
                                    <StudentProfile
                                        :studentInfo="{
                                            id: item.student_id,
                                            name: item.user.full_name,
                                            contact_number:
                                                item.parent?.user
                                                    ?.contact_number,
                                            img: item.user.profile_pic,
                                            user_id: item.user_id,
                                        }"
                                    />
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
    background: url("/images/artbg.png") no-repeat !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
    height: 830px;
}

.learning-card {
    background: #4066e4;
    margin-top: 8%;
    border: 4px solid #fff;
}

.settingbtn {
    border: 3px solid #fff;
    background: #4066e4;
    height: 50px;
}

.head-text {
    font-size: 30px !important;
    color: #fff;
}

.navbar {
    background: #000;
    padding: 3px;
}
</style>
