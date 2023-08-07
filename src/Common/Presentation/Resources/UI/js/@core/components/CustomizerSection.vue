<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  divider: {
    type: Boolean,
    required: false,
    default: true,
  },
})
</script>

<template>
  <div class="customizer-section">
    <p class="tiggie-text fw-700" style="text-transform: capitalize !important;">
      {{ props.title }}
    </p>

    <slot />
  </div>
</template>
