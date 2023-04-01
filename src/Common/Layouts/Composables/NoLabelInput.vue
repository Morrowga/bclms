<template>
  <div>

    <InputText :type="type"
      :value="modelValue"
      @input="updateValue"
      :required="required"
      :placeholder="placeholder"
      class="p-inputtext-sm w-full " />
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
