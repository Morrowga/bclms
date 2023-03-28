<template>
  <div class="hight-full flex flex-col">
    <Header :auth="auth" :route_data="route" />
    <main class="grow">
      <slot />
    </main>
    <hr />
    <Footer />
  </div>
</template>

<script setup>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
defineProps(["route"]);
</script>
<style>
.hight-full {
  height: 100vh;
}
</style>
