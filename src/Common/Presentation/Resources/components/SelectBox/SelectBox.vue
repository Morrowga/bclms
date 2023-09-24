<template>
    <div class="custom-select">
        <VSelect
            :label="label"
            :menu-props="menu_props"
            :error-messages="error_messages"
            :item-title="item_title"
            :item-value="item_value"
            :density="density"
            :rules="rules"
            :items="datas"
            :modal-value="modelValue"
            variant="plain"
            :placeholder="placeholder"
            v-model="filters"
            class="custom-select select-box"
        ></VSelect>
    </div>
</template>
<script setup>
import { defineProps, defineEmits, watch, ref } from "vue";
let filters = ref(null);
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
        default: "compact",
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
// let updateValue = (event) => {
//     emit("update:modelValue", event.target.value);
// };
watch(filters, (newValue) => {
    emit("update:modelValue", newValue);
});
</script>
<style scoped>
.custom-select {
    width: 100%;
}
.custom-select .v-input--density-comfortable .v-field--variant-solo,
.custom-select .v-input--density-comfortable .v-field--variant-filled {
    border-radius: 100px;
    height: 100%;
}

.custom-select .v-input__control {
    height: auto !important;
    top: 0 !important;
}

.custom-select .v-input__control .v-label.v-field-label {
    top: 0 !important;
}
.select-box {
    border: 1px solid var(--line, #e5e5e5);
    padding: 8px 16px;
    border-radius: 100px;
}
:deep(.v-field__input) {
    padding: 0 !important;
}
:deep(.v-field__input input) {
    line-height: 38px !important;
    color: #000 !important;
}
</style>
