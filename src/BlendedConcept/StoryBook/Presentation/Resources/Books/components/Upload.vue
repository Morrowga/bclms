<script setup>
import { defineProps, ref, defineEmits } from "vue";
import { useForm } from "@inertiajs/vue3";
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
        <v-btn
            @click="toggleDialog"
            icon="mdi-upload"
            size="x-small"
            color="secondary"
        ></v-btn>
        <v-dialog v-model="dialog" width="100%" max-width="550" persistent>
            <v-card>
                <v-card-title class="px-10 pt-10">
                    <span class="font-weight-bold text-primary"
                        >Upload Storybook Thumbnail</span
                    >
                </v-card-title>
                <v-card-text class="px-10 py-0 pb-5">
                    <div class="coming-soon">
                        <p>Drop And Drop</p>
                    </div>

                    <div class="d-flex justify-center aligns-center pt-10">
                        <div>
                            <VBtn
                                color="gray"
                                height="50"
                                class=""
                                width="200"
                                @click="dialog = false"
                            >
                                Cancel
                            </VBtn>

                            <VBtn
                                type="submit"
                                class="ml-10"
                                height="50"
                                width="200"
                            >
                                Add
                            </VBtn>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
.coming-soon {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
    height: 200px;
    border: 1px dashed black;
    border-radius: 10px;
}
.coming-soon p {
    margin-bottom: 0;
}
</style>
