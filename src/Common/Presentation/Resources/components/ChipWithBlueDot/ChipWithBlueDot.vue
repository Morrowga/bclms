<script setup>
import { ref, defineProps } from "vue";
let props = defineProps({
    title: {
        type: String,
        default: "",
    },
});
</script>
<template>
    <div class="chip my-2 mr-2">
        <div class="chip-head"></div>
        <div class="chip-content">{{ props.title }}</div>
    </div>
</template>
<style scoped>
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 36px;
    outline: none;
    padding: 0;
    font-size: 14px;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    border: 1px solid #686868;
    /* justify-content: center; */
}
.chip-head {
    display: flex;
    position: relative;
    overflow: hidden;
    background-color: #32c5d2;
    font-size: 1.25rem;
    flex-shrink: 0;
    align-items: center;
    user-select: none;
    border-radius: 50%;
    justify-content: center;
    width: 10px;
    color: #fff;
    height: 10px;
    margin-right: -4px;
    margin-left: 10px;
}
.chip-content {
    cursor: inherit;
    display: flex;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
</style>
