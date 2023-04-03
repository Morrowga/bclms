<template>
  <div class="hight-full flex flex-col bg-cover bg-no-repeat">
    <Header />
    <main class="grow">
      <slot>
        <div class="container mx-auto px-16 py-10">
          <section id="top-seaction">
            <div class="grid grid-cols-2 gap-4">
              <div class="box">01</div>
              <div class="box">09</div>
            </div>
          </section>
          <br />
          <section id="content-section">
            <DataTable :value="datas" tableStyle="min-width: 50rem">
              <template #header>
                <div
                  class="flex flex-wrap align-items-center justify-content-between gap-2"
                >
                  <span class="text-xl text-900 font-bold">My Classes</span>
                </div>
              </template>
              <Column field="id" header="Id"></Column>
              <Column field="name" header="Name"></Column>
              <Column field="teacher" header="Teacher"></Column>
              <Column field="contact_number" header="Contact Number"></Column>
              <Column field="no_of_students" header="Number Of Students">
                <template #body="slotProps">
                  <!-- <Rating :modelValue="slotProps.data.no_of_students" readonly :cancel="false" /> -->
                  <span>{{ slotProps.data.no_of_students.count }}</span
                  ><br />
                  <span>See Details</span>
                </template>
              </Column>
              <Column header="">
                <template #body="slotProps">
                  <Button icon="pi pi-check" text rounded aria-label="Filter" />
                </template>
              </Column>
            </DataTable>
            <div class="flex justify-end my-4">
              <a href="#">{{ "View More>>" }}</a>
            </div>
          </section>
          <br />
          <section id="end-section">
            <DataTable :value="students" tableStyle="min-width: 50rem">
              <template #header>
                <div
                  class="flex flex-wrap align-items-center justify-content-between gap-2"
                >
                  <span class="text-xl text-900 font-bold">Students </span>
                </div>
              </template>
              <Column field="id" header="Id"></Column>
              <Column field="name" header="Name"></Column>
              <Column field="email" header="Email"></Column>
              <Column field="contact_number" header="Contact Number"></Column>
              <Column field="user_role" header="User Role"> </Column>
            </DataTable>
            <div class="flex justify-end my-4">
              <a href="#">{{ "View More>>" }}</a>
            </div>
          </section>
        </div>
      </slot>
    </main>
    <Footer />
  </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
let datas = [
  {
    id: "1",
    name: "Amg",
    teacher: "U AMG",
    contact_number: "09324234",
    no_of_students: {
      count: "10/15",
      id: "1",
    },
  },
];
let students = [
  {
    id: "1",
    name: "Amg",
    email: "amg@mail.com",
    contact_number: "09324234",
    user_role: "Teacher",
  },
];
</script>
<style scoped>
.box {
  width: 100%;
  min-height: 200px;
  border: 1px solid blue;
  padding: 20px;
}
</style>