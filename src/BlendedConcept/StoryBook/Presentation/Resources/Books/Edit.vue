<script setup>
import { defineProps, ref, defineEmits } from "vue";
import { useForm } from "@inertiajs/vue3";
import Upload from "./components/Upload.vue";
const props = defineProps({
    data: {
        type: Object,
        default: null,
    },
});
let emit = defineEmits();
let dialog = ref(false);
const toggleDialog = () => {
    dialog.value = !dialog.value;
};
const form = useForm({
    title: "Boj Giggly Park Adventure",
    description:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempo incididunt ut labore et doloremagna aliqua. Lorem ipsum dolor sit amet, consecteturadipiscing elit, sed do eiusmod tempor incididunt utlabore et dolore magna aliqua.",
    types: [],
    devices: [],
});
</script>
<template>
    <div>
        <v-btn
            @click="toggleDialog"
            icon="mdi-edit"
            size="x-small"
            color="secondary"
        ></v-btn>
        <v-dialog v-model="dialog" width="100%" max-width="800" persistent>
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
                            <!-- <span>Boj Giggly Park Adventure</span> -->
                            <v-text-field v-model="form.title"></v-text-field>
                        </div>
                        <div class="edit-icon">
                            <v-btn
                                icon="mdi-image-area"
                                size="x-small"
                                color="secondary"
                            ></v-btn>
                            <v-btn
                                icon="mdi-content-save"
                                size="x-small"
                                color="secondary"
                            ></v-btn>
                            <!-- <v-btn
                                icon="mdi-upload"
                                size="x-small"
                                color="secondary"
                            ></v-btn> -->
                            <Upload />
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
                        <v-textarea
                            style="max-width: 650px"
                            variant="outlined"
                            v-model="form.description"
                        ></v-textarea>
                        <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Lorem ipsum dolor sit amet, consectetur
                        adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. -->
                    </div>
                    <div class="learning pt-2">
                        <span class="font-weight-black text-black"
                            >Learning Needs</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div style="position: relative">
                                    <v-chip size="small"
                                        >Social Awareness</v-chip
                                    >
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small">Self Awareness</v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small"
                                        >Responsible Decision Making</v-chip
                                    >
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small">Mobility</v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                            </v-chip-group>
                            <v-btn
                                class="ml-10"
                                size="x-small"
                                icon="mdi-plus"
                                color="secondary"
                            ></v-btn>
                        </div>
                    </div>
                    <div class="themes pt-2">
                        <span class="font-weight-black text-black">Themes</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div style="position: relative">
                                    <v-chip size="small">
                                        Social Skills
                                    </v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small"> Life Skills </v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                            </v-chip-group>
                            <v-btn
                                class="ml-10"
                                size="x-small"
                                icon="mdi-plus"
                                color="secondary"
                            ></v-btn>
                        </div>
                    </div>

                    <div class="disability pt-2">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div style="position: relative">
                                    <v-chip size="small"> Dyspraxia </v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small">
                                        Hyperactive Disorder
                                    </v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                            </v-chip-group>
                            <v-btn
                                class="ml-10"
                                size="x-small"
                                icon="mdi-plus"
                                color="secondary"
                            ></v-btn>
                        </div>
                    </div>

                    <div class="supported pt-2">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div style="position: relative">
                                    <v-chip size="small">Mouse/Keyboard</v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small">Switch-Single</v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                                <div style="position: relative">
                                    <v-chip size="small">Switch-Double</v-chip>
                                    <div class="delete-chip">
                                        <span>-</span>
                                    </div>
                                </div>
                            </v-chip-group>
                            <v-btn
                                class="ml-10"
                                size="x-small"
                                icon="mdi-plus"
                                color="secondary"
                            ></v-btn>
                        </div>
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
    max-width: 650px;
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
.edit-icon {
    position: absolute;
    bottom: -5px;
    right: 40px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.v-input__control {
    height: auto !important;
}


:deep(.v-text-field input) {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
    padding-top: 0;
    padding-bottom: 0;
}

.delete-chip {
    background: rgb(109, 120, 141);
    border-radius: 50%;
    width: 15px;
    height: 15px;
    color: #fff;
    text-align: center;
    position: absolute;
    right: 0;
    top: 0;
}
.delete-chip span {
    position: absolute;
    top: -6px;
    left: 0;
    bottom: 0;
    right: 0;
    color: #fff;
}
</style>
