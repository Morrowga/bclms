<template>
  <!-- for superadmin dashboard check -->
  <AdminLayout v-if="auth.data.roles[0].name == 'superadmin'">
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
      <div class="flex flex-wrap gap-2 justify-between sm:px-2">
        <div
          v-for="(card, index) in cards"
          :key="index"
          class="w-full lg:w-80 md:w-80 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
        >
          <div class="flex flex-row items-end gap-3">
            <span class="material-symbols-outlined text-5xl">
              {{ card.icon }}
            </span>
            <span
              class="mb-2 font-semibold tracking-tight text-gray-900 dark:text-white"
            >
              {{ card.name }}
            </span>
          </div>

          <p class="text-xl font-semibold mt-4">{{ card.value }}</p>
        </div>
      </div>
      <header class="flex justify-between mt-5">
        <span>Last Organization record</span>
        <a class="font-bold mb-2"> view more &gt;&gt; </a>
      </header>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-4">ID</th>
              <th scope="col" class="px-6 py-4">Name</th>
              <th scope="col" class="px-6 py-4">Contact Person</th>
              <th scope="col" class="px-6 py-4">Contact Number</th>
              <th scope="col" class="px-6 py-4">Number of Users</th>
              <th scope="col" class="px-6 py-4"></th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
              v-for="(table1, tableIndex) in 4"
              :key="tableIndex"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                001
              </th>
              <td class="px-6 py-4">User 1</td>
              <td class="px-6 py-4">Kim</td>
              <td class="px-6 py-4">09941233422</td>
              <td class="px-6 py-4">
                <span>10/15</span>
              </td>
              <td class="px-6 py-4">
                <a
                  href="#"
                  class="font-medium text-dark-600 dark:text-dark-500 hover:underline"
                  ><span class="material-symbols-outlined"> more_vert </span></a
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <header class="flex justify-between mt-10">
        <span>Last User</span>
        <Link class="font-bold mb-2" href="/users"> view more &gt;&gt; </Link>
      </header>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-4">ID</th>
              <th scope="col" class="px-6 py-4">Name</th>
              <th scope="col" class="px-6 py-4">Email</th>
              <th scope="col" class="px-6 py-4">Contact Number</th>
              <th scope="col" class="px-6 py-4">User Role</th>
              <th scope="col" class="px-6 py-4"></th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="bg-white border-b dark:bg-gray-900 dark:border-gray-700"
              v-for="(user, tableIndex2) in users"
              :key="tableIndex2"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ user.name }}
              </th>
              <td class="px-6 py-4">Silver</td>
              <td class="px-6 py-4">Laptop</td>
              <td class="px-6 py-4">$2999</td>
              <td class="px-6 py-4">Admin</td>
              <td class="px-6 py-4">
                <a
                  href="#"
                  class="font-medium text-dark-600 dark:text-dark-500 hover:underline"
                  ><span class="material-symbols-outlined"> more_vert </span>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>

  <!-- for teacher and parent roles check -->
  <TeacherOrParent v-if="auth.data.roles[0].name == 'teacher/parent'">
    <div class="flex flex-row mt-10 place-content-center">
      <div class="flex flex-col">
        <Image src="images/profile/profiletwo.png" />
        <div class="description pl-4">
          <Link
            :href="route('teacherdashboard')"
            class="text-primary text-[20px] font-semibold leading-[150%]"
          >
            Teacher One
          </Link>
          <p class="text-primary text-[18px] font-normal">Teacher/Parent</p>
        </div>
      </div>
    </div>
    <!-- student show  -->
    <div class="flex flex-row flex-wrap mt-10 gap-4 place-content-center">
      <div class="flex flex-col">
        <Image src="images/profile/profiletwo.png" />
        <div class="description pl-4">
          <Link
            :href="route('studentdashboard')"
            class="text-primary text-[20px] font-semibold leading-[150%]"
          >
            Student One
          </Link>
          <p class="text-primary text-[18px] font-normal">Student</p>
        </div>
      </div>
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
      </div>
      <div class="flex flex-col mt-5">
        <Link href="addstudent">
          <Image src="images/icons/PlusCircle.svg" class="w-24 h-24" />
        </Link>
      </div>
    </div>
    <!-- end student view -->
  </TeacherOrParent>
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; // optional
import Row from "primevue/row";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import TeacherOrParent from "@Layouts/Dashboard/TeacherOrParent.vue";

let auth = computed(() => usePage().props.auth);

defineProps(["users"]);
let cards = [
  { name: "Total Number Of Users", icon: "group", value: "15,000" },
  { name: "Total Number Of Organization", icon: "domain", value: "15" },
  { name: "Revenue", icon: "monetization_on", value: "70,000" },
];
</script>
