<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { Swiper, SwiperSlide } from "swiper/vue";
import DraggableSticker from "./DraggableSticker.vue";
import { ref, defineProps } from "vue";
let props = defineProps(["flash", "auth", "stickers", "placed_stickers"]);
const xPos = ref(0); // Initial x position in pixels
const yPos = ref(0); // Initial y position in pixels

let isDragging = ref(false);
let offsetX = 0;
let offsetY = 0;

const startDragging = (event) => {
  isDragging.value = true;

  const clientX = event.type === 'touchstart' ? event.touches[0].clientX : event.clientX;
  const clientY = event.type === 'touchstart' ? event.touches[0].clientY : event.clientY;

  offsetX = clientX - xPos.value;
  offsetY = clientY - yPos.value;

  document.addEventListener('mousemove', dragImage);
  document.addEventListener('touchmove', dragImage);
  document.addEventListener('mouseup', stopDragging);
  document.addEventListener('touchend', stopDragging);
};

const dragImage = (event) => {
  if (!isDragging.value) return;

  const clientX = event.type === 'touchmove' ? event.touches[0].clientX : event.clientX;
  const clientY = event.type === 'touchmove' ? event.touches[0].clientY : event.clientY;

  xPos.value = clientX - offsetX;
  yPos.value = clientY - offsetY;
};

const stopDragging = () => {
  isDragging.value = false;

  document.removeEventListener('mousemove', dragImage);
  document.removeEventListener('touchmove', dragImage);
  document.removeEventListener('mouseup', stopDragging);
  document.removeEventListener('touchend', stopDragging);
};
</script>

<template>
    <StudentLayout class="section-bg">
        <div class="storereward">
            <img
                class="store-reward-img"
                src="/images/store.gif"
                @click="() => router.get(route('reward-store'))"
                alt=""
            />
        </div>
        <section>
            <div>
                <div
                class="draggable-element"
                :style="{ left: `${xPos}px`, top: `${yPos}px` }"
                @mousedown="startDragging"
                @touchstart="startDragging"
                >
                    <VImg src="/images/star.png" width="30" height="30"></VImg>
                </div>
            </div>
        </section>
    </StudentLayout>
</template>

<style lang="scss" scope>
.draggable-element {
  position: absolute;
  width: 100px; /* Adjust based on your content */
  height: 100px; /* Adjust based on your content */
  background-color: #3498db; /* Example background color */
  cursor: grab;
  user-select: none; /* Prevent text selection while dragging */
}

.draggable-element:active {
  cursor: grabbing;
}
</style>
