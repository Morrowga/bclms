<script setup>
import { ref } from "vue";
const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
});

let is_description = ref(false);
let is_chip = ref(true);
</script>
<template>
    <v-card min-width="275">
        <v-card-title class="ps-relative">
            <v-img src="/images/image4.png" />
            <div class="chip-page" v-if="is_chip">
                <div class="chip-content">{{ props.data.storybooks.length}} storybooks</div>
            </div>
        </v-card-title>
        <v-card-text>
            <h1 class="font-weight-bold text-h6 text-center pb-4">
                Playlist {{ props.data.name }}
            </h1>
            <!-- <p v-if="is_description">
                When Woody is kidnapped by a greedy toy collector and is nowhere
                to be found, Buzz and his friends set out to rescue him.
            </p> -->
        </v-card-text>
    </v-card>
</template>
<style scoped>
.chip {
    display: inline-flex;
    flex-direction: row;
    background-color: #e5e5e5;
    border: none;
    cursor: default;
    height: 30px;
    outline: none;
    padding: 0;
    color: #333333;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
    border: 1px solid #17cab6;
}

.chip-content {
    cursor: inherit;
    display: flex;
    font-size: 12px !important;
    align-items: center;
    user-select: none;
    white-space: nowrap;
    padding-left: 12px;
    padding-right: 12px;
}
.chip-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.green {
    color: #17cab6;
}

.chip-page {
    display: inline-flex;
    flex-direction: row;
    background-color: #282828;
    border: none;
    cursor: default;
    height: 30px;
    outline: none;
    padding: 0;
    color: #fff;
    font-family: "Open Sans", sans-serif;
    white-space: nowrap;
    align-items: center;
    border-radius: 16px;
    vertical-align: middle;
    text-decoration: none;
    justify-content: center;
    position: absolute;
    right: 27px;
    bottom: 17px;
}
</style>
