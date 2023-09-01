<script setup>
import { ref, defineProps } from "vue";
let props = defineProps({
    title: {
        type: String,
        default: "",
    },
    icon : {
        type : Boolean,
        default : false
    }
});
</script>
<template>
    <div class="chip green">
        <div class="chip-content d-flex gap-4 ">
            <VIcon v-if="props.icon" icon="mdi-circle" color="primary"/>
           <span>{{ props.title }}</span>
        </div>
    </div>
</template>
<style scoped>
.chip {
    display: inline-flex;
    flex-direction: row;
    /* background-color: #e5e5e5; */
    border: none;
    cursor: default;
    height: 30px;
    outline: none;
    padding: 0;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
    border: 1px solid #17cab6;
}

.chip-content {
    cursor: inherit;
    display: flex;
    font-size: 12px !important;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}

.green {
    color: #17cab6;
}
</style>
