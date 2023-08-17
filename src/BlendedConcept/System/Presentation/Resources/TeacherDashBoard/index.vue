<script setup>
import SystemErrorAlert from "@mainRoot/components/SystemErrorAlert.vue";
import {defineProps} from "vue";

</script>

<template>
    <section>
        <SystemErrorAlert sytemErrorMessage="Something is wrong" v-if="true" />

        <VAlert type="error">
      I'm a alert with a <strong>type</strong> of error
        </VAlert>
    </section>

</template>

<style></style>
