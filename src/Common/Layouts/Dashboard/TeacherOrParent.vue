<template>
  <div class="hight-full flex flex-col  bg-cover bg-no-repeat" style="background:url('images/teacherprofile.svg')  100%">
    <Header />
    <main class="grow">
      <div class="flex flex-row mt-10 place-content-center">
        <div class="flex flex-col">
          <Image src="images/profile/profiletwo.png"/>
          <div class="description pl-4">
            <h4 class="text-primary text-[20px] font-semibold leading-[150%]">Teacher One</h4>
            <p class="text-primary text-[18px] font-normal">Teacher/Parent</p>
          </div>
        </div>
      </div>
      <!-- student show  -->
      <div class="flex flex-row flex-wrap mt-10 gap-4 place-content-center">
        <div class="flex flex-col">
          <Image src="images/profile/profiletwo.png"/>
          <div class="description pl-4">
            <h4 class="text-primary text-[20px] font-semibold leading-[150%]">Student One</h4>
            <p class="text-primary text-[18px] font-normal">Student</p>
          </div>
        </div>
        <div class="flex flex-col">
          <Image src="images/profile/profiletwo.png"/>
          <div class="description pl-4">
            <h4 class="text-primary text-[20px] font-semibold leading-[150%]">Student Two</h4>
            <p class="text-primary text-[18px] font-normal">Student</p>
          </div>
        </div>
        <div class="flex flex-col" v-for="i in 10" :key="i">
          <Image src="images/profile/profiletwo.png"/>
          <div class="description pl-4">
            <h4 class="text-primary text-[20px] font-semibold leading-[150%]">Student three</h4>
            <p class="text-primary text-[18px] font-normal">Student</p>
          </div>
        </div>
        <div class="flex flex-col mt-5">
        <Link href="addstudent">
          <Image src="images/icons/PlusCircle.svg" class="w-24 h-24" />
        </Link>
        </div>
      </div>
      <!-- end student view -->
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
