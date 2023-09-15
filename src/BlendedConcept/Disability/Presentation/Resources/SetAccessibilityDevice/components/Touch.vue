<script setup>
import { ref } from "vue";
import ChipWithBlueDot from "@mainRoot/components/ChipWithBlueDot/ChipWithBlueDot.vue";
import GreenChip from "@mainRoot/components/GreenChip/GreenChip.vue";

let tab = ref(null);
</script>
<template>
    <div>
        <v-card class="mb-10">
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-img src="/images/device.png" />
                    </v-col>
                    <v-col cols="12" md="6" class="pa-10">
                        <h1 class="text-h4 font-weight-bold mb-4 t-black">
                            Touch
                        </h1>
                        <p class="text-subtitle-1">
                            Our Touch Accessibility Device offers intuitive
                            touch controls and customizable features, enabling
                            students to interact with digital content
                            effortlessly.
                        </p>
                        <br />
                        <div class="tab">
                            <v-tabs v-model="tab">
                                <v-tab value="disability"
                                    >Disability Types</v-tab
                                >
                            </v-tabs>

                            <div>
                                <v-window v-model="tab">
                                    <v-window-item value="disability">
                                        <ChipWithBlueDot
                                            v-for="item in 5"
                                            :key="item"
                                            title="Disability"
                                        />
                                    </v-window-item>
                                </v-window>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <div>
            <v-row>
                <v-col cols="12" md="6" offset-md="3" class="pa-10">
                    <v-card>
                        <v-card-title>
                            <v-img src="/images/deviceImg.png" />
                        </v-card-title>
                        <v-card-text class="text-center">
                            <p class="text-subtitle-1 font-weight-bold t-black">
                                A Walk On The Tundra
                            </p>
                            <div class="d-flex flex-wrap justify-center gap-10">
                                <GreenChip title="Switch" />
                                <GreenChip title="Eye-Gaze" />
                                <GreenChip title="Touch" />
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12">
                    <div class="d-flex justify-center">
                        <VBtn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            class="pl-16 pr-16 mr-4"
                        >
                            <span class="text-primary">Cancel</span>
                        </VBtn>
                        <VBtn
                            color="primary"
                            variant="flat"
                            rounded
                            class="pl-16 pr-16"
                        >
                            <span>Submit</span>
                        </VBtn>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
</template>
<style scoped>
.t-black {
    color: #000 !important;
}
</style>
