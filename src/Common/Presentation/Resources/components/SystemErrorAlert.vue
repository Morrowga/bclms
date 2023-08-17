<script setup>
import { defineProps, ref } from "vue";

let props = defineProps(["sytemErrorMessage"]);



</script>

<template>
   <VAlert type="error">
      I'm a alert with a <strong>type</strong> of error
   </VAlert>
</template>

<style scoped>
.bg-success {
    background-color: #72E128 !important;
    color: #72E128  !important;
}

.bg-font {
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 21px;
    letter-spacing: 0.15px;

}
</style>

