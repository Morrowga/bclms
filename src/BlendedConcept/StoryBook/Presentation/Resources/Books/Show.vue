<script setup>
import { defineProps, ref } from "vue";
import Edit from "./Edit.vue";
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
        <v-hover v-slot="{ isHovering, props }" open-delay="200">
            <v-card
                class="item-frame"
                v-bind="props"
                :class="{ 'on-hover': isHovering }"
            >
                <v-img
                    @click="toggleDialog"
                    :src="data.thumbnail_img"
                    alt="Your Image"
                    max-height="200"
                    cover
                ></v-img>
            </v-card>
        </v-hover>
        <v-dialog v-model="dialog" width="auto" max-width="800">
            <v-card>
                <v-card-title class="pa-0">
                    <div class="faded-image">
                        <img
                            :src="data.thumbnail_img"
                            class="img-header"
                            alt="Faded Image"
                        />
                        <div class="faded-overlay"></div>
                        <div class="book-title">
                            <span>{{data.name}}</span>
                        </div>
                        <div class="edit-icon">
                            <v-btn
                                icon="mdi-gift"
                                size="x-small"
                                color="secondary"
                            ></v-btn>
                            <Edit :datas="data" />
                            <v-btn
                                icon="mdi-upload"
                                size="x-small"
                                color="secondary"
                            ></v-btn>
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
                        {{data.description}}
                    </div>

                    <div class="learning pt-2">
                        <span class="font-weight-black text-black"
                            >Learning Needs</span
                        >
                        <v-chip-group>
                            <v-chip size="small"
                            v-for="(learningneed,index) in data.learingneeds"
                            :key="index">
                                {{learningneed.name}}
                            </v-chip>
                        </v-chip-group>
                    </div>

                    <div class="themes pt-2">
                        <span class="font-weight-black text-black">Themes</span>
                        <v-chip-group>
                            <v-chip size="small" v-for="theme in data.themes" :key="theme.id">
                                {{theme.name}}
                            </v-chip>
                        </v-chip-group>
                    </div>

                    <div class="disability pt-2">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        >
                        <v-chip-group>
                            <v-chip size="small" v-for="disability in data.disability_types" :key="disability.id">
                                {{disability.name}}
                            </v-chip>

                        </v-chip-group>
                    </div>

                    <div class="supported pt-2">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        >
                        <v-chip-group>
                            <v-chip size="small" v-for="device in data.devices" :key="device.id">
                                {{device.name}}
                                </v-chip>
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
.close-btn .v-btn--icon {
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
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.v-card:not(.on-hover) {
    opacity: 1;
}

.edit-icon {
    position: absolute;
    bottom: -5px;
    right: 40px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
</style>
