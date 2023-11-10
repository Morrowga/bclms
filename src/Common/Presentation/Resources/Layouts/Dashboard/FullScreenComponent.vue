<script setup>
const dialog = ref(false);
const props = defineProps(["openDialog"]);
const emit = defineEmits();
const lockScreenOrientation = async () => {
    try {
        await document.documentElement.requestFullscreen();
        await screen.orientation.lock("landscape-primary");
        console.log("Orientation locked successfully");
    } catch (error) {
        console.error("Failed to lock orientation:", error);
    }
};
const clickRotate = () => {
    lockScreenOrientation();
    emit("close_orientation");
};
</script>
<template>
    <v-dialog
        v-model="props.openDialog"
        fullscreen
        persistent
        class="bg-color-full"
    >
        <v-card
            class="w-100 h-100 d-flex justify-center align-center"
            theme="dark"
        >
            <v-sheet
                @click="clickRotate()"
                elevation="10"
                style="width: 150px; height: 150px"
                class="d-flex justify-center align-center"
            >
                <v-img src="/images/orientation.gif"></v-img>
            </v-sheet>
        </v-card>
    </v-dialog>
</template>
<style scoped>
.bg-color-full {
    background: black !important;
}
</style>
