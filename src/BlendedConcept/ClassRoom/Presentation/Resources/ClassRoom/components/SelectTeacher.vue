<script setup>
import TotalTeachers from "./TotalTeachers.vue";
import {
    serverParams,
    searchItems,
    routeName,
} from "./useTeachersDatatable.js";
routeName.value = "classrooms.getTeacher";
const props = defineProps({
    form: {
        type: Object,
        default: {
            name: "",
            description: "",
            image: "",
            students: [],
            teachers: [],
        },
    },
});
</script>
<template>
    <v-expansion-panel>
        <v-expansion-panel-title>
            <h2 class="font-weight-bold ruddy-bold fs-25">
                Step 1: Select Teachers
                <v-chip class="chip-count">{{
                    props.form.teachers.length
                }}</v-chip>
            </h2>
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
                    @keyup.enter="searchItems"
                    v-model="serverParams.search"
                ></v-text-field>
            </div>
            <v-row>
                <v-col cols="12">
                    <TotalTeachers :form="props.form" />
                </v-col>
            </v-row>
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

.chip-count {
    background: var(--seaform, #d7f2f0) !important;
    gap: 10px !important;
    border-radius: 50px !important;
    color: #17cab6 !important;
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
