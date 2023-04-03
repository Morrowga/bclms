<template>
   <Student>
        <div class="bg-no-repeat grid bg-cover" style="background-image:url('images/portalbanner.png')">
          <div class="p-5">
          <p class="text-[26px] pb-5 font-[700] text-primary w-96 "> Banner to highlight new books, popular books, promotion events.</p>
          <p class="text-primary pb-5">Describe exactly what the banner is advertising</p>
          <Button label="View Detail >>" class="w-[152px] text-[16px] whitespace-nowrap h-[48px] leading-[24px] bg-secondary hover:bg-yellow-900 text-primary font-bold"/>
          </div>
        </div>
        <!-- story books -->
        <h3 class="px-10 mt-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top">
            Felix's Storybooks
        </h3>
          <div
            class="flex flex-row gap-20 justify-between px-10">
            <div class="">
            <Image src="images/sample1.png" class="px-2" alt="Image" />
            <p class="text-primary text-body">Title</p>
            </div>
            <div class="">
            <Image src="images/sample1.png" class="px-2" alt="Image" />
            <p class="text-primary text-body">Title</p>
            </div>
            <div class="">
            <Image src="images/sample1.png" class="px-2" alt="Image" />
            <p class="text-primary text-body">Title</p>
            </div>
        </div>


         <!-- story books -->
        <h3 class="px-10 mt-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top">
            Felix’s Playlist
        </h3>
          <div
            class="flex mt-4 flex-row gap-3 justify-between px-10 mb-10">
            <Image src="images/sample1.png"  class="px-2 w-96" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96" alt="Image" />
        </div>

  </Student>
</template>

<script setup>
import Student from "@dashboard/Student.vue";

</script>
