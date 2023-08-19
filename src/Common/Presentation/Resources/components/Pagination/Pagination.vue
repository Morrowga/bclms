<script setup>
import { ref } from "vue";
let page = ref(1);
</script>
<template>
    <div class="text-center" style="width: 65%">
        <v-container>
            <v-row justify="center">
                <v-col cols="8">
                    <v-container class="max-width">
                        <v-pagination
                            v-model="page"
                            class="my-4"
                            :length="15"
                        ></v-pagination>
                    </v-container>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
