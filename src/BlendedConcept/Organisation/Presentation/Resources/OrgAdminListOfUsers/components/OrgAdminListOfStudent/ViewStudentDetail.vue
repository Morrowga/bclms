<script setup>
import { useForm } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";

import { ref } from "vue";
let tab = ref(null);
const form = useForm({});
const props = defineProps(["organisations_student"]);
const deleteStudent = () => {
  isConfirmedDialog({
    title: "You won't be able to revert it!",
    denyButtonText: "Yes, delete it!",
    onConfirm: () => {
      form.delete(
        route(
          "organisations-student.destroy",
          props.organisations_student.student_id
        ),
        {
          onSuccess: () => {
            SuccessDialog({
              title: "You have successfully deleted student!",
              color: "#17CAB6",
            });
          },
          onError : () => {
            console.log(error)
          }
        }
      );
    },
  });
};
</script>
<template>
  <AdminLayout>
    <v-container class="width-80">
      <v-row>
        <v-col cols="12" md="6">
          <v-img :src="organisations_student.user.profile_pic" />
        </v-col>
        <v-col cols="12" md="6" class="pa-5">
          <div class="d-flex justify-space-between align-center">
            <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
            <div>
              <Link
                :href="
                  route(
                    'organisations-student.edit',
                    organisations_student.student_id
                  )
                "
              >
                <v-btn
                  variant="flat"
                  rounded
                  color="#17CAB6"
                  prepend-icon="mdi-pencil"
                  class="mr-4 text-white"
                  >Edit</v-btn
                >
              </Link>
              <v-btn
                variant="flat"
                rounded
                color="error"
                prepend-icon="mdi-trash"
                @click="deleteStudent"
                >Delete</v-btn
              >
            </div>
          </div>
          <v-row>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Fullname</p>
              <p class="text-h6 font-weight-bold mx-4">
                {{ organisations_student.user.full_name }}
              </p>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Gender</p>
              <p class="text-h6 font-weight-bold mx-4">
                {{ organisations_student.gender }}
              </p>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Date of birth</p>
              <p class="text-h6 font-weight-bold mx-4">
                {{ organisations_student.dob }}
              </p>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Education Level</p>
              <p class="text-h6 font-weight-bold mx-4">
                {{ organisations_student.education_level }}
              </p>
            </v-col>
          </v-row>
          <v-col cols="12">
            <p class="text-subtitle-1 mb-0">Contact Number</p>
            <p class="text-h6 font-weight-bold mx-4">
              {{ organisations_student.user.contact_number }}
            </p>
          </v-col>
          <v-col cols="12">
            <p class="text-subtitle-1 mb-0">Email Address</p>
            <p class="text-h6 font-weight-bold mx-4">
              {{ organisations_student.user.email }}
            </p>
          </v-col>
          <v-row>
            <v-col cols="12">
              <v-tabs v-model="tab">
                <v-tab value="learning">Learning Need</v-tab>
                <v-tab value="disability">Disability Types</v-tab>
              </v-tabs>

              <div>
                <v-window v-model="tab">
                  <v-window-item value="learning">
                    <ChipWithBlueDot
                      v-for="item in props.organisations_student.learningneeds"
                      :key="item.id"
                      :title="item.name"
                    />
                  </v-window-item>

                  <v-window-item value="disability">
                    <ChipWithBlueDot
                    v-for="item in props.organisations_student.disability_types"
                      :key="item.id"
                      :title="item.name"
                    />
                  </v-window-item>
                </v-window>
              </div>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row justify="center">
        <v-col cols="2">
          <Link :href="route('organisations-student.index')">
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
<style scoped></style>
