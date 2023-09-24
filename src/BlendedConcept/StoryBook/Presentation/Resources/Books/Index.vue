<script setup>
import { defineProps } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Show from "./Show.vue";
import Create from "./Create.vue";
import { useForm } from "@inertiajs/vue3";


const props = defineProps([
  "learningneeds",
  "themes",
  "disability_types",
  "devices",
  "storybooks"
]);

</script>
<template>
  <AdminLayout>
    <VContainer fluid>
      <div class="head-section">
        <div class="title-section">
          <p class="heading">Manage Books</p>
          <span class="subheading">Showing 18 books</span>
        </div>
        <div class="head-button">
          <Create
            :learningneed="props.learningneeds"
            :themes="props.themes"
            :disability_types="props.disability_types"
            :devices="props.devices"
          />
        </div>
      </div>

      <VRow class="mt-5">
        <VCol
          cols="12"
          sm="6"
          md="4"
          lg="3"
          v-for="data in storybooks.data"
          :key="data.image"
        >
          <Show :data="data" />
        </VCol>
      </VRow>
    </VContainer>
  </AdminLayout>
</template>
<style scoped>
.head-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.heading {
  margin: 0;
  font-size: 40px !important;
  font-style: normal !important;
  font-weight: 700 !important;
  line-height: 52px !important; /* 130% */
  text-transform: capitalize !important;
  color: var(--tiggie-blue, #4066e4);
}

.head-button {
  align-self: flex-end;
}
.fit-img {
  width: 100%;
  height: 100%;
  max-height: 217px;
}
.item-frame {
  position: relative;
}
.v-card {
  transition: opacity 0.4s ease-in-out;
  opacity: 0.8;
}

.v-card:not(.on-hover) {
  opacity: 1;
}
</style>
