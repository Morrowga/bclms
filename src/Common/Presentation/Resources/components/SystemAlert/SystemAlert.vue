<script setup>
import { defineProps } from "vue";

let props = defineProps(["icon", "text", 'id']);
const emit = defineEmits(["submit"]);

const onFormSubmit = () => {
    emit("submit", props.id);
};
</script>
<template>
    <VForm
        class="mt-6"
        ref="refForm"
        @submit.prevent="onFormSubmit"
    >
        <div class="message-list">
            <div class="message-list-item">
                <div class="d-flex align-center gap-10">
                    <v-icon
                        :icon="props.icon"
                        color="#fff"
                        class="message-icon"
                    ></v-icon>
                    <span class="message-text pppangram-medium">{{
                        props.text
                    }}</span>
                </div>
                <div class="close-btn">
                    <v-btn
                        type="submit"
                        size="small"
                        icon="mdi-close"
                        variant="text"
                        color="#fff"
                    ></v-btn>
                </div>
            </div>
        </div>
    </VForm>
</template>
<style scoped>
.message-list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    padding: 5px;
    border-radius: 200px;
    border: 3px solid var(--graphite, #282828);
    background: var(--tiggie-blue, #4066e4);
}
.message-icon {
    font-size: 25px !important;
    padding: 0 20px !important;
}

.message-text {
    color: #fff;
    /* Body Style Large */
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 38px !important;
}
</style>
