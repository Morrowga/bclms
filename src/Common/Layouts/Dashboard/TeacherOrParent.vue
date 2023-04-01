<template>
  <div class="hight-full flex flex-col  bg-cover bg-no-repeat" style="background:url('images/teacherprofile.svg')  100%">
    <Header />
    <main class="grow">
      <slot/>
    </main>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
</script>
<style>
.hight-full {
  height: 100vh;
}
Image {
    width: 141px;
    height: 141px;
}
</style>
