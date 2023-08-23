<script setup></script>
<template>
    <VCard>
        <v-chip class="class-count"> 5 / 5 </v-chip>
        <v-img
            src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
            height="200px"
            cover
        ></v-img>
        <div class="d-flex justify-center">
            <span class="class-label"> 1A </span>
        </div>
    </VCard>
</template>
<style scoped>
.class-count {
    position: absolute;
    z-index: 1;
    right: 0;
    color: #000;
    margin: 1vh;
    background-color: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(2px);
}

.class-label {
    position: absolute;
    z-index: 1;
    bottom: 0;
    font-size: 24px;
    width: 100%;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 8px;
    border-radius: 4px;
    text-align: center;
}
</style>
