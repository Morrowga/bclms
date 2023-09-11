<script setup>
const isDialogVisible = ref(false)
import {  useForm } from "@inertiajs/vue3";

const form = useForm({
    user_id : "",
    question : "",
    response : ""
});


const handleSubmit = () => {
    form.post(route('techsupports'),function(){

    })
}

</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn color="primary" variant="flat" rounded v-bind="props">
                <VIcon icon="mdi-plus" class="text-white"></VIcon>
                <span class="text-white">Ask</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard>
            <DialogCloseBtn variant="text" size="small" @click="isDialogVisible = false" />

            <VCardText>
                <h4 class="tiggie-subtitle">Describe your issue to our Technical Support Team</h4>
                <VTextarea placeholder="Enter question" />
            </VCardText>
            <VCardActions>
                <VRow class="text-center">
                    <VCol cols="6" class="text-end">
                        <VBtn color="teal" variant="tonal" class="px-10">
                            Send
                        </VBtn>
                    </VCol>
                    <VCol cols="6" class="text-start">
                        <VBtn color="graphic" variant="tonal" class="px-10">
                            Cancel
                        </VBtn>
                    </VCol>
                </VRow>
            </VCardActions>
        </VCard>
    </VDialog>
</template>
