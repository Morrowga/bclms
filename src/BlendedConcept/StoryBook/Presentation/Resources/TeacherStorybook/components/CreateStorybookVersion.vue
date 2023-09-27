<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryBtn from "@mainRoot/components/SecondaryBtn/SecondaryBtn.vue";
import PrimaryBtn from "@mainRoot/components/PrimaryBtn/PrimaryBtn.vue";
import { SuccessDialog } from "@actions/useSuccess";

let dialog = ref(false);
const submitReview = () => {
  dialog.value = false;
  SuccessDialog({
    title: "You have successfully created a version",
    color: "#17CAB6",
  });
};

const props = defineProps(["dataStoryBook"]);

const form = useForm({
  storybook_id: props.dataStoryBook.id,
  teacher_id: "",
  name: "",
  description: "",
});

const CreateStoryBookVersion = () => {
  form.post(route("storybooksversions.store"), {
    onSuccess: () => {
      SuccessDialog({ title: "You've successfully created organisation" });
      dialog.value = false;
    },
    onError: (error) => {
      console.log(error);
    },
  });
};
</script>
<template>
  <div>
    <v-btn
      prepend-icon="mdi-add"
      variant="flat"
      rounded
      color="primary"
      @click="dialog = true"
    >
      Add
    </v-btn>
    <v-dialog v-model="dialog" width="auto" min-width="800">
      <v-card>
        <v-card-title>
          <div class="d-flex justify-space-between align-center">
            <span class="header-create">Create a new storybook version</span>
            <v-btn
              variant="text"
              icon="mdi-close"
              @click="dialog = false"
            ></v-btn>
          </div>
        </v-card-title>
        <v-card-text>
          <v-form @submit.prevent="CreateStoryBookVersion">
            <v-row>
              <v-col cols="12">
                <v-label class="font-weight-bold t-black required"
                  >Name</v-label
                >
                <v-text-field
                  variant="outlined"
                  density="compact"
                  placeholder="Enter Name"
                  v-model="form.name"
                />
              </v-col>
              <v-col cols="12">
                <v-label class="font-weight-bold t-black required"
                  >Description</v-label
                >
                <v-text-field
                  variant="outlined"
                  density="compact"
                  placeholder="Enter Description"
                  v-model="form.description"
                />
              </v-col>
              <v-col cols="12">
                <div class="d-flex justify-center align-center gap-10">
                  <SecondaryBtn title="Cancel" @click="dialog = false" />

                  <v-btn
                    type="submit"
                    class="p"
                    color="primary"
                    width="200"
                    rounded
                  >
                    Save
                  </v-btn>
                </div>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<style scoped>
.header-create {
  color: var(--text, #161616);
  /* H3 Ruddy */

  font-size: 30px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
}
</style>
