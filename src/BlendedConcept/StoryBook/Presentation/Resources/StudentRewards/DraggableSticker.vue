<template>
    <div
        class="draggable-image"
        :style="{
            position: 'absolute',
            top: `${positionY}px`,
            left: `${positionX}px`,
        }"
        @mousedown="startDragging"
    >
        <img :src="imageSrc" alt="Draggable Image" />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, defineEmits, defineProps } from "vue";

const isDragging = ref(false);
const props = defineProps({
    imageSrc: {
        type: String,
        default: "",
    },
    pox: {
        type: Number,
        default: 0,
    },
    poy: {
        type: Number,
        default: 0,
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
    offsetX = event.clientX - positionX.value;
    offsetY = event.clientY - positionY.value;

    // Attach event listeners to the document
    document.addEventListener("mousemove", dragImage);
    document.addEventListener("mouseup", stopDragging);

    // Prevent the default browser behavior for dragging
    event.preventDefault();
};

const dragImage = (event) => {
    if (isDragging.value) {
        positionX.value = event.clientX - offsetX;
        positionY.value = event.clientY - offsetY;
    }
};

const stopDragging = () => {
    isDragging.value = false;
    emit("isDragging", false);
    // Remove event listeners from the document
    document.removeEventListener("mousemove", dragImage);
    document.removeEventListener("mouseup", stopDragging);
};

// Clean up event listeners when the component is unmounted
onUnmounted(() => {
    document.removeEventListener("mousemove", dragImage);
    document.removeEventListener("mouseup", stopDragging);
});
</script>

<style scoped>
.draggable-image {
    position: fixed;
    cursor: grab;
    user-select: none; /* Prevent text selection while dragging */
}

.draggable-image img {
    pointer-events: none; /* Prevent the image from intercepting pointer events */
    height: 60px;
}

.draggable-image:active {
    cursor: grabbing; /* Change cursor when actively dragging */
}
</style>
