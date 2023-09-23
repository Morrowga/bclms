<script setup>
import TeacherStorybookCard from "./TeacherStorybookCard.vue";
import CreateStorybookVersion from "./CreateStorybookVersion.vue";
import { ref } from "vue";
let model = ref(false);
const props = defineProps(['storybooks'])
</script>
<template>
  <div>
    <div class="header-sec d-flex justify-center align-center">
      <span> Recommended Books </span>
    </div>
    <div class="body-sec">
      <div
        class="d-flex justify-start justify-md-center align-center gap-10 f-wrap">
        <v-slide-group v-model="model" center-active show-arrows mandatory>
          <v-slide-group-item v-for="item in storybooks.data" :key="item">
            <TeacherStorybookCard :item="item" :isDisabled="true" class="margin-card" />
          </v-slide-group-item>
        </v-slide-group>
      </div>
    </div>
  </div>
</template>
<style scoped>
.margin-card {
  margin-right: 20px !important;
}
.header-sec {
  width: 100%;
  gap: 20px;
}
.header-sec span {
  color: var(--text, #161616);
  /* H3 Ruddy */

  font-size: 40px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
}
.body-sec {
  padding-top: 40px;
}
</style>
