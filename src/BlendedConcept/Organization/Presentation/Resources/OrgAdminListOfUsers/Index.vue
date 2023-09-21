<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import StudentList from "./components/OrgAdminListOfStudent/StudentList.vue";
import TeacherList from "./components/OrgAdminListOfTeacher/TeacherList.vue";
import { ref } from "vue";
let tab = ref("student");
let props = defineProps(["teachers",'students']);

console.log(props)

const changeTab = (tabName) => {
  tab.value = tabName;
};
</script>
<template>
  <AdminLayout>
    <VContainer class="width-80">
      <div class="mb-10">
        <v-row>
          <VCol cols="12" md="6">
            <div class="d-flex align-center">
              <VBtn
                variant="flat"
                rounded
                :color="tab == 'teacher' ? 'primary' : '#f6f6f6'"
                :class="
                  tab == 'teacher' ? 'text-white' : 'text-black border-black'
                "
                @click="changeTab('teacher')"
              >
                Teacher
              </VBtn>
              <VBtn
                variant="flat"
                rounded
                :color="tab == 'student' ? 'primary' : '#f6f6f6'"
                :class="
                  tab == 'student' ? 'text-white' : 'text-black border-black'
                "
                @click="changeTab('student')"
              >
                Students
              </VBtn>
            </div>
          </VCol>
          <VCol cols="12" md="6" class="d-flex justify-end">
            <div v-if="tab == 'student'" class="d-flex justify-end gap-10">
              <Link :href="route('organizations-student.create')">
                <VBtn
                  variant="flat"
                  rounded
                  color="primary"
                  class="text-white"
                  prepend-icon="mdi-plus"
                >
                  Add
                </VBtn>
              </Link>

              <VBtn
                variant="flat"
                rounded
                color="primary"
                class="text-white"
                prepend-icon="mdi-upload"
              >
                Upload
              </VBtn>
            </div>
            <div v-if="tab == 'teacher'" class="d-flex justify-end gap-10">
              <Link :href="route('listoforgteacher')">
                <VBtn
                  variant="flat"
                  rounded
                  color="#17CAB6"
                  class="text-white"
                  prepend-icon="mdi-plus"
                >
                  Allocate Storage
                </VBtn>
              </Link>

              <Link :href="route('organizations-teacher.create')">
                <VBtn
                  variant="flat"
                  rounded
                  color="primary"
                  class="text-white"
                  prepend-icon="mdi-plus"
                >
                  Add
                </VBtn>
              </Link>

              <VBtn
                variant="flat"
                rounded
                color="primary"
                class="text-white"
                prepend-icon="mdi-upload"
              >
                Upload
              </VBtn>
            </div>
          </VCol>
        </v-row>
      </div>
      <div class="tab-list">
        <section v-if="tab == 'student'">
          <StudentList :students="props.students"/>
        </section>
        <section v-if="tab == 'teacher'">
          <TeacherList :data="props.teachers" />
        </section>
      </div>
    </VContainer>
  </AdminLayout>
</template>
<style scoped>
.border-black {
  border: 1px solid #e5e5e5 !important;
}
</style>
