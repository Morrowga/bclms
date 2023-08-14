<template>
    <div class="custom-select">
        <VAutocomplete
            clearable
            :label="label"
            :menu-props="menu_props"
            :error-messages="error_message"
            :item-title="item_title"
            :item-value="item_value"
            :density="density"
            :rules="rules"
            :items="datas"
            :modal-value="modelValue"
            @change="updateValue"
            :variant="variant"
            :placeholder="placeholder"
            style="width: 100%"
        ></VAutocomplete>
    </div>
</template>
<script setup>
import { defineProps, defineEmits } from "vue";
let props = defineProps({
    modelValue: {
        type: [Number, String],
        default: "",
    },
    datas: {
        type: Array,
    },
    label: {
        type: String,
        default: "",
    },
    menu_props: {
        type: Object,
        default: null,
    },
    error_messages: {
        type: String,
        default: "",
    },
    item_title: {
        type: String,
        default: "",
    },
    item_value: {
        type: [Number, String],
        default: "",
    },
    density: {
        type: String,
        default: "solo",
    },
    rules: {
        type: Array,
        default: [],
    },
    variant: {
        type: String,
        default: "outlined",
    },
    placeholder: {
        type: String,
        default: "",
    },
});
let emit = defineEmits(["update:modelValue"]);
let updateValue = (event) => {
    emit("update:modelValue", event.target.value);
};
</script>
<style>
.custom-select {
    width: 100%;
}
.custom-select .v-input--density-comfortable .v-field--variant-solo,
.custom-select .v-input--density-comfortable .v-field--variant-filled {
    border-radius: 100px;
    height: 100%;
}
</style>
