<template>
  <div class="hight-full flex flex-col">
    <Header :auth="auth" />
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
</script>
<style>
.hight-full {
  height: 100vh;
}
</style>
