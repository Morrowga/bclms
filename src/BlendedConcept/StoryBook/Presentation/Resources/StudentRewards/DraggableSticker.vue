<script setup>
import { ref, onMounted, onUnmounted, defineEmits, defineProps } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
let flash = computed(() => usePage().props.flash);

const isDragging = ref(false);
const form = useForm({
    sticker_id: null,
    x_axis_position: 0,
    y_axis_position: 0,
    _method: "PUT",
});
const props = defineProps({
    imageSrc: {
        type: String,
        default: "",
    },
    pox: {
        default: 0,
    },
    poy: {
        default: 0,
    },
    index: {
        default: 0,
    },
    data: {
        type: Object,
        default: null,
    },
});
const positionX = ref(props.pox);
const positionY = ref(props.poy);
let offsetX = 0;
let offsetY = 0;
let emit = defineEmits();
const startDragging = (event) => {
    isDragging.value = true;
    emit("isDragging", true);
    const clientX =
        event.type === "touchstart" ? event.touches[0].clientX : event.clientX;
    const clientY =
        event.type === "touchstart" ? event.touches[0].clientY : event.clientY;

    offsetX = clientX - positionX.value;
    offsetY = clientY - positionY.value;

    // Attach event listeners to the document

    document.addEventListener("mousemove", dragImage);
    document.addEventListener("touchmove", dragImage);
    document.addEventListener("mouseup", stopDragging);
    document.addEventListener("touchend", stopDragging);

    // Prevent the default browser behavior for dragging
    event.preventDefault();
};

const dragImage = (event) => {
    if (isDragging.value) {
        const clientX =
            event.type === "touchmove"
                ? event.touches[0].clientX
                : event.clientX;
        const clientY =
            event.type === "touchmove"
                ? event.touches[0].clientY
                : event.clientY;

        positionX.value = clientX - offsetX;
        positionY.value = clientY - offsetY;
    }
};

const stopDragging = (event) => {
    if (positionX.value > 110) {
        isDragging.value = false;
        emit("isDragging", false);

        form.x_axis_position = positionX.value;
        form.y_axis_position = positionY.value;
        form.sticker_id = props.data.pivot.id;
        form.post(route("drop-sticker", { reward: props.data.id }), {
            preserveScroll: true,
            onSuccess: (e) => {
                // FlashMessage({ flash })
            },
        });
        // Remove event listeners from the document
    } else {
        isDragging.value = false;
        emit("isDragging", false);
        positionX.value = 0;
        positionY.value = props.index * 80;
        form.x_axis_position = 0;
        form.y_axis_position = 0;
        form.sticker_id = props.data.pivot.id;
        form.post(route("drop-sticker", { reward: props.data.id }), {
            preserveScroll: true,
            onSuccess: (e) => {
                // FlashMessage({ flash })
            },
        });
    }
    document.removeEventListener("mousemove", dragImage);
    document.removeEventListener("touchmove", dragImage);
    document.removeEventListener("mouseup", stopDragging);
    document.removeEventListener("touchend", stopDragging);
};

// Clean up event listeners when the component is unmounted
onUnmounted(() => {
    document.removeEventListener("mousemove", dragImage);
    document.removeEventListener("touchmove", dragImage);
    document.removeEventListener("mouseup", stopDragging);
    document.removeEventListener("touchend", stopDragging);
});

onMounted(() => {
    positionX.value = positionX.value;
    positionY.value = positionY.value;
});
</script>
<template>
    <div
        class="draggable-image"
        :style="{
            position: 'absolute',
            top: `${positionY}px`,
            left: `${positionX}px`,
        }"
        @mousedown="startDragging"
        @touchstart="startDragging"
    >
        <img :src="imageSrc" alt="Draggable Image" />
    </div>
</template>

<style scoped>
.draggable-image {
    position: fixed;
    cursor: grab;
    user-select: none; /* Prevent text selection while dragging */
    z-index: 1;
}

.draggable-image img {
    pointer-events: none; /* Prevent the image from intercepting pointer events */
    height: 60px;
}

.draggable-image:active {
    cursor: grabbing; /* Change cursor when actively dragging */
}
</style>
