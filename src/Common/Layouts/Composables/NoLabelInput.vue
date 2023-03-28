<template>
  <div>
    <input
      :type="type"
      :value="modelValue"
      @input="updateValue"
      :required="required"
      class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      :placeholder="placeholder"
    />
    <p
      id="filled_error_help"
      class="mt-2 text-xs text-red-600 dark:text-red-400"
      v-if="error"
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
});
let emit = defineEmits(["update:modelValue"]);
let updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>