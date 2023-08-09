<script setup>
const props = defineProps({
    form: {
        type: Object
    },
    userData: {
        type: Object,
        required: false,
        default: () => ({
            currentpassword: "",
            updatedpassword: ""

        }),
    },
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
})

const emit = defineEmits([
    'submit',
    'update:isDialogVisible',
])

const userData = ref(structuredClone(toRaw(props.userData)))

const onFormReset = () => {
    userData.value = structuredClone(toRaw(props.userData))
    emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
    emit('update:isDialogVisible', val)
}
</script>

<template>
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 540" :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate">
        <VCard class="pt-10">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />
            <VCardItem class="text-left pl-16">
                <VCardTitle class="mb-2 tiggie-title">
                    Technical Support
                </VCardTitle>
                <VLabel class="tiggie-label">Question</VLabel>
                <p class="tiggie-p">The computer is saying ‘press any key’ but I’m struggling to find it</p>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="11" md="11">
                                <VLabel class="tiggie-label">Answer</VLabel>
                                <VTextarea placeholder="Type here ...." v-model="description" auto-grow rows="5" />
                            </VCol>

                            <!-- 👉 Submit and Cancel -->
                            <VCol cols="11" class="d-flex flex-wrap justify-space-between gap-10">
                                <VBtn color="gray" text-color="white" height="58" class="pl-10"  @click="onFormReset">
                                    <span class="text-white">Cancel</span>
                                </VBtn>

                                <VBtn type="submit" height="58" class="">
                                    Send Answer
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VContainer>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
