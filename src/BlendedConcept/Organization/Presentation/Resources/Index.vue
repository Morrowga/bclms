<template>
  <!-- for superadmin dashboard check -->
  <AdminLayout v-if="auth.data.roles[0].name == 'superadmin'"></AdminLayout>

  <!-- for teacher and parent roles check -->
  <TeacherOrParent v-if="auth.data.roles[0].name == 'teacher/parent'">
    <div class="flex flex-row mt-10 place-content-center">
      <div class="flex flex-col">
        <Image src="images/profile/profiletwo.png" />
        <div class="description pl-4">
          <h4 class="text-primary text-[20px] font-semibold leading-[150%]">
            Teacher One
          </h4>
          <p class="text-primary text-[18px] font-normal">Teacher/Parent</p>
        </div>
      </div>
    </div>
    <!-- student show  -->
    <div class="flex flex-row flex-wrap mt-10 gap-4 place-content-center">
      <div class="flex flex-col">
        <Image src="images/profile/profiletwo.png" />
        <div class="description pl-4">
          <h4 class="text-primary text-[20px] font-semibold leading-[150%]">
            Student One
          </h4>
          <p class="text-primary text-[18px] font-normal">Student</p>
        </div>
      </div>
      <div class="flex flex-col">
        <Image src="images/profile/profiletwo.png" />
        <div class="description pl-4">
          <h4 class="text-primary text-[20px] font-semibold leading-[150%]">
            Student Two
          </h4>
          <p class="text-primary text-[18px] font-normal">Student</p>
        </div>
        <div class="flex flex-col">
          <Image src="images/profile/profiletwo.png"/>
          <div class="description pl-4">
            <h4 class="text-primary text-[20px] font-semibold leading-[150%]">Student Two</h4>
            <p class="text-primary text-[18px] font-normal">Student</p>
          </div>
        </div>
      </div>
      <div class="flex flex-col mt-5">
        <Link href="addstudent">
          <Image src="images/icons/PlusCircle.svg" class="w-24 h-24" />
        </Link>
      </div>
    </div>
    <!-- end student view -->
  </TeacherOrParent>
  <!-- <TeacherOrParentDashboard /> -->
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; // optional
import Row from "primevue/row";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherOrParent from "@Layouts/Dashboard/TeacherOrParent.vue";
import TeacherOrParentDashboard from "@Layouts/Dashboard/TeacherOrParentDashboard.vue";

let auth = computed(() => usePage().props.auth);
</script>
