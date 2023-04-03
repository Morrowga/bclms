<template>
  <FrontendLayout>
    <!-- slider -->
    <div
      class="bg-no-repeat grid bg-cover"
      style="background: url('images/teacherbanner.png') 100%; height: 60vh"
    >
      <div class="flex flex-col p-14 z-10" style="width: 700px">
        <p class="font-bold">
          <span class="text-primary text-[40px] tracking-[8.5%]">
            Banner to highlight new books, popular books, promotion events. </span
          ><br />
          <span class="text-primary">
            Describe exactly what the banner is advertising
          </span>
        </p>
        <br />
        <Button
          label="View Detail >>"
          class="w-[152px] text-[16px] whitespace-nowrap h-[48px] leading-[24px] bg-secondary hover:bg-yellow-900 text-primary font-bold"
        />
      </div>
    </div>
    <!-- story books  -->
    <h3 class="px-10 text-h3 leading-9 text-primary font-medium align-top">
      Recommended Books
    </h3>
    <div
      class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 justify-items-center py-4 px-8 gap-1 animated_img_frame"
    >
      <Image src="images/sample1.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
    </div>
    <Divider type="solid" />
    <h3
      class="px-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top"
    >
      Favourite Books
    </h3>
    <div
      class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 justify-items-center py-4 px-8 gap-1 animated_img_frame"
    >
      <Image src="images/sample1.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
      <Image src="images/sample2.png" class="px-2 animated_img" alt="Image" />
    </div>
  </FrontendLayout>
</template>

<script setup>
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import PackageIcon from "@Composables/icons/PackageIcon.vue";
// import portaBanner from "images/portalbanner.png";
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
