<script setup>
import { defineProps, ref } from "vue";
const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});
let dialog = ref(false);
const toggleDialog = () => {
    dialog.value = !dialog.value;
};
</script>
<template>
    <div>
        <v-card class="ma-4" height="150" width="250" @click="toggleDialog">
            <div class="d-flex fill-height align-center justify-center">
                <img class="bg-white fit-img" :src="data.image" />
            </div>
        </v-card>
        <v-dialog v-model="dialog" width="auto" max-width="800">
            <v-card>
                <v-card-title class="pa-0">
                    <div class="faded-image">
                        <img
                            :src="'/images/teacherbanner.png'"
                            class="img-header"
                            alt="Faded Image"
                        />
                        <div class="faded-overlay"></div>
                        <div class="book-title">
                            <span>Boj Giggly Park Adventure</span>
                        </div>
                        <div class="close-btn">
                            <v-btn
                                @click="dialog = false"
                                color="default"
                                variant="elevated"
                                icon="$close"
                                :rounded="false"
                            >
                            </v-btn>
                        </div>
                    </div>
                </v-card-title>
                <v-card-text class="px-10 py-0 pb-5">
                    <div class="paragraph">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </div>

                    <div class="disability pt-2">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        >
                        <v-chip-group>
                            <v-chip size="small">Dyspraxia</v-chip>

                            <v-chip size="small">Hyperactive Disorder</v-chip>
                        </v-chip-group>
                    </div>

                    <div class="supported pt-2">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        >
                        <v-chip-group>
                            <v-chip size="small">Mouse/Keyboard</v-chip>

                            <v-chip size="small">Switch-Single</v-chip>

                            <v-chip size="small">Switch-Double</v-chip>

                            <v-chip size="small">Touch</v-chip>
                        </v-chip-group>
                    </div>
                </v-card-text>
                <v-card-actions class="d-flex justify-end">
                    <span class="text-caption"
                        >Last updated on 14 Aug 2023 1:04Am</span
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
/* .img-header {
   
} */
.faded-image {
    position: relative;
    display: inline-block;
    width: 100%;
}

.faded-image img {
    display: block;
    height: 270px;
    width: 100%;
    object-fit: fill;
    position: relative;
}

.faded-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%; /* Adjust this value to control the height of the fading effect */
    background: linear-gradient(
        to bottom,
        transparent,
        white
    ); /* Adjust the colors as needed */
}

.book-title {
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 40px;
}
.book-title span {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
}

.close-btn {
    position: absolute;
    top: 0;

    right: 0;
}
.v-btn--icon {
    border-radius: 10px;
    scale: 0.7;
}
.chip-1 {
    background: rgba(255, 166, 0, 0.464);
    color: #fff !important;
}
.chip-2 {
    background: rgba(217, 23, 13, 0.464);
    color: #fff !important;
}
.chip-3 {
    background: rgba(72, 255, 0, 0.464);
    color: #fff !important;
}
</style>
