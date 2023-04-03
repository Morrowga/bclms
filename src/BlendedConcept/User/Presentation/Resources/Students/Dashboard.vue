<template>
   <Student>
        <div class="bg-no-repeat grid bg-cover" style="background-image:url('images/portalbanner.png')">
          <div class="pl-5 pt-20">
          <p class="text-[50px] pb-5 font-[700] text-primary w-[50%]"> Banner to highlight new books, popular books, promotion events.</p>
          <p class="text-primary pb-5">Describe exactly what the banner is advertising</p>
          <Button label="View Detail >>" class="w-[152px] text-[16px] whitespace-nowrap h-[48px] leading-[24px] bg-secondary hover:bg-yellow-900 text-primary font-bold"/>
          </div>
        </div>
        <!-- story books -->
        <h3 class="px-10 mt-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top">
            Felix's Storybooks
        </h3>
          <div
            class="flex flex-row gap-10 justify-between px-10">
            <div class="">
            <Image src="images/sample1.png" class="px-2  animated_img" alt="Image" />
            <p class="text-primary text-h5 font-bold">Title</p>
            </div>
            <div class="">
            <Image src="images/sample1.png" class="px-2  animated_img" alt="Image" />
            <p class="text-primary text-h5 font-bold">Title</p>
            </div>
            <div class="">
            <Image src="images/sample1.png" class="px-2  animated_img" alt="Image" />
            <p class="text-primary text-h5 font-bold">Title</p>
            </div>
            <div class="">
            <Image src="images/sample1.png" class="px-2 animated_img" alt="Image" />
            <p class="text-primary text-h5 font-bold">Title</p>
            </div>
        </div>


         <!-- story books -->
        <h3 class="px-10 mt-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top">
            Felix’s Playlist
        </h3>
          <div
            class="flex mt-4 flex-row gap-3 justify-between px-10 mb-10">
            <Image src="images/sample1.png"  class="px-2 w-96 animated_img" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96 animated_img" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96 animated_img" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96 animated_img" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96 animated_img" alt="Image" />
            <Image src="images/sample1.png" class="px-2 w-96 animated_img" alt="Image" />
        </div>

  </Student>
</template>

<script setup>
import Student from "@dashboard/Student.vue";

</script>


<style>
.line {
  position: absolute;
  margin-top: 10%;
  margin-left: 1.2%;
  width: 1px;
  height: 100px;
  background-color: #001a8f;
}
.animated_img {
  scale: 1;
  transition: all 0.3s ease-in-out;
}
.animated_img_frame {
  transform: translateY(0px);
  transition: all 0.3s ease-in-out;
}
.animated_img_frame:hover {
  transform: translateY(20px);
  transition: all 0.3s ease-in-out;
}
.animated_img:hover {
  scale: 1.1;
  transform: translateY(-20px);
  transition: all 0.3s ease-in-out;
}
@media screen and (max-width: 460px) {
  .line {
    margin-top: 40%;
    margin-left: 4%;
  }
}
</style>

