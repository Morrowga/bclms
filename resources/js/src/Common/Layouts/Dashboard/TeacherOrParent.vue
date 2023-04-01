<template>
  <div class="hight-full flex flex-col bg-cover bg-no-repeat" style="background:url('images/teacherprofile.svg')  100%">
    <Header />
    <main class="grow">
      <div class="container grid grid-rows-4 items-center justify-items-center h-100">
        <div>item   </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
</script>
<style>
.hight-full {
  height: 100vh;
}
</style>
