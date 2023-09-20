<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { ref } from "vue";
let tab = ref(null);
const isPasswordVisible = ref(false);
const createStudent = () => {
  SuccessDialog({
    title: "You have successfully create a student!",
    color: "#17CAB6",
  });
};
</script>
<template>
  <AdminLayout>
    <VContainer class="width-80">
      <v-row>
        <v-col cols="12" md="6">
          <v-img src="/images/student_pf.png" />
        </v-col>
        <v-col cols="12" md="6" class="pa-5">
          <div class="d-flex justify-space-between align-center">
            <h1 class="tiggie-sub-subtitle fs-40">Students</h1>
          </div>
          <v-row>
            <v-col cols="12" class="mt-10">
              <p class="text-h5 font-weight-bold mb-0">Student Details</p>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Fullname</p>
              <v-text-field placeholder="e.g. Wren Clark" variant="outlined">
              </v-text-field>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Gender</p>
              <v-select placeholder="Select" variant="outlined"> </v-select>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Date of birth</p>
              <v-text-field placeholder="e.g January 24, 2010" variant="outlined">
              </v-text-field>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Education Level</p>
              <v-text-field placeholder="e.g K1" variant="outlined">
              </v-text-field>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Parent's Contact Number</p>
              <v-text-field placeholder="e.g. 9180003" variant="outlined">
              </v-text-field>
            </v-col>
            <v-col cols="12">
              <p class="text-subtitle-1 mb-0">Parent's Email Address</p>
              <v-text-field
                placeholder="e.g. @fransico@gmail.com"
                variant="outlined"
              >
              </v-text-field>
            </v-col>
          </v-row>
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
                      v-for="item in 5"
                      :key="item"
                      title="Dyslexia"
                    />
                  </v-window-item>

                  <v-window-item value="disability">
                    <ChipWithBlueDot
                      v-for="item in 5"
                      :key="item"
                      title="Disability"
                    />
                  </v-window-item>
                </v-window>
              </div>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12">
          <div class="d-flex justify-center">
            <Link :href="route('org_view_teacher_student.index')">
              <v-btn
                variant="flat"
                rounded
                class="mr-4 text-primary"
                width="200"
                color="rgba(55, 73, 233, 0.10)"
                >Cancel</v-btn
              >
            </Link>
            <v-btn
              variant="flat"
              rounded
              width="200"
              color="primary"
              class="text-white"
              @click="createStudent()"
              >Save</v-btn
            >
          </div>
        </v-col>
      </v-row>
    </VContainer>
  </AdminLayout>
</template>
<style scoped></style>
