<script setup>
import TotalStudents from "./TotalStudents.vue";
</script>
<template>
    <v-expansion-panel>
        <v-expansion-panel-title>
            <h2 class="font-weight-bold text-h5">Step 1: Select Teachers <v-chip class="chip-count">3</v-chip></h2>
        </v-expansion-panel-title>
        <v-expansion-panel-text>
            <div class="d-flex justify-end align-center mb-4">
                <v-text-field
                    density="compact"
                    label="Search"
                    append-inner-icon="mdi-magnify"
                    single-line
                    rounded
                    hide-details
                    class="mr-4"
                ></v-text-field>
            </div>
            <v-row>
                <v-col cols="12">
                    <TotalStudents />
                </v-col>
            </v-row>
            <br />
            <div class="d-flex justify-center">
                <v-btn variant="outlined" color="primary">Load More</v-btn>
            </div>
        </v-expansion-panel-text>
    </v-expansion-panel>
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

.chip-count{
    background: var(--seaform, #D7F2F0) !important;
    gap: 10px !important;
    border-radius: 50px !important;
    color: #17CAB6 !important;
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
