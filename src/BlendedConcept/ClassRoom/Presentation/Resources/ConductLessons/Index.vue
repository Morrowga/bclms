<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import PlayListSelectBox from "./components/PlayListSelectBox.vue";
import { SuccessDialog } from "@actions/useSuccess";
import SelectStudent from "./components/SelectStudent.vue";
import { useForm, router } from "@inertiajs/vue3";
import SelectStorybook from "./components/SelectStorybook.vue";
const form = useForm({
    name: "",
    image: null,
    student_id: "",
    storybooks: [],
    students: [],
});
</script>

<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around">
                <VCol cols="12">
                    <h4 class="tiggie-teacher-title">Conduct Lesson</h4>
                </VCol>
                <VCol cols="12">
                    <div class="mt-3">
                        <v-expansion-panels>
                            <SelectStorybook :form="form" />
                        </v-expansion-panels>
                    </div>
                    <div class="mt-15">
                        <v-expansion-panels>
                            <SelectStudent :form="form" />
                        </v-expansion-panels>
                    </div>

                    <!-- 👉 Collapsible Section -->
                    <!-- <PlayListSelectBox :datas="props.students.data" :storybooks="props.storybooks.data" /> -->
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4">
                    <div class="d-flex gap-3">
                        <VBtn color="gray" height="50" class="" width="200">
                            Cancel
                        </VBtn>

                        <VBtn
                            type="submit"
                            class="ml-10"
                            height="50"
                            width="200"
                            @click="
                                () => router.get(route('conduct_lessons.show'))
                            "
                        >
                            Start Lesson
                        </VBtn>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.playlist-border {
    border: 3px solid #565660 !important;
}

.blur-p {
    color: var(--Secondary2, rgba(86, 86, 96, 0.4));
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
    border: 1px solid rgb(182, 182, 186, 0.6);
    border-radius: 10px;
}
.profileimg {
    object-fit: cover !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
    margin-bottom: 0;
}
</style>
