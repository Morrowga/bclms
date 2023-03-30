<template>
    <div class="card">
        <h5 class="pb-3">App Name</h5>
        <div class="grid grid-cols-12">
        <div class="flex flex-column col-span-3 gap-2">
            <label for="app_name"></label>
            <InputText
                id="app_name"
                v-model="value"
                aria-describedby="username-help" />
        </div>
        <div class="flex flex-column col-span-3 gap-2">
            <label for="app_name">Application Name</label>
            <InputText
                id="app_name"
                v-model="value"
                aria-describedby="username-help" />
        </div>
        <div class="flex flex-column col-span-3 gap-2">
            <label for="app_name"></label>
            <InputText
                id="app_name"
                v-model="value"
                aria-describedby="username-help" />
        </div>
        </div>
    </div>
</template>

<script setup>
import InputText from "primevue/inputtext";
</script>

