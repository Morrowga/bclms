<script setup>
import { ref } from "vue";
const props = defineProps({
    metadata: {
        type: Object,
        required: true,
    },
});

const meta = ref({
    current_page: 1, // Default to the first page
    last_page: 1, // Default to a single page
});

// console.log(meta.value)

const changePage = (page) => {
    // Handle page change here, e.g., emit a custom event
    emit("page-changed", page);
};

// Update the meta data when the component receives new data
watch(props.data, (newData) => {
    meta.value = newData.meta;
});
</script>
<template>
    <div class="text-center width-65">
        <v-container>
            <v-row justify="center">
                <v-col cols="8">
                    <v-container class="max-width">
                        <v-pagination
                            v-model="meta.current_page"
                            class="my-4"
                            :length="meta.last_page"
                        ></v-pagination>
                    </v-container>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
