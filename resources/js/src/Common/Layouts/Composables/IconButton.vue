<template>
  <button :type="type" :class="dynamic_color" @click="clicked">
    <slot></slot>
  </button>
</template>
<script setup>
import { defineProps, computed } from "vue";
let props = defineProps({
  type: {
    type: String,
    default: "button",
  },
  buttonColor: {
    type: String,
    default: "default",
  },
});
let dynamic_color = computed(() => {
  switch (props.buttonColor) {
    case "green":
      return "mb-2 text-white bg-green-400 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2";
      break;
    case "blue":
      return "mb-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800";
      break;
    case "yellow":
      return "mb-2 text-white bg-yellow-400 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2";
      break;
    case "red":
      return "mb-2 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2";
      break;
    default:
      return "mb-2 text-white bg-white hover:bg-gray-100 text-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2";
      break;
  }
});
let emit = defineEmits(["click:runFunction"]);
let clicked = () => {
  emit("click:runFunction");
};
</script>