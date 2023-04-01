<template>
  <div>
    <label
      for="email"
      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
      >{{ label }}</label
    >
    <input
      :title="title"
      :type="type"
      :value="modelValue"
      @input="updateValue"
      :required="required"
      :placeholder="placeholder"
      class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "
    />
    <p
      v-if="error"
      class="mt-1 text-sm text-red-500 dark:text-red-300"
      id="file_input_help"
    >
      {{ error }}
    </p>
  </div>
</template>
<script setup>
import { defineProps, defineEmits } from "vue";
let props = defineProps({
  modelValue: {
    type: [Number, String],
    default: "",
  },
  label: {
    type: String,
    default: "",
  },
  type: {
    type: String,
    default: "text",
  },
  placeholder: {
    type: String,
    default: "",
  },

  error: {
    type: String,
    default: "",
  },
  required: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: "",
  },
});
let emit = defineEmits(["update:modelValue"]);
let updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>