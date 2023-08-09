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
            updatedpassword: "",
            passwordConfirmation:""

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
const isUseAsBillingAddress = ref(false)

watch(props, () => {
    userData.value = structuredClone(toRaw(props.userData))
})

const onFormSubmit = () => {
    emit('submit', userData.value)
}

const onFormReset = () => {
    userData.value = structuredClone(toRaw(props.userData))
    emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
    emit('update:isDialogVisible', val)
}
</script>

<template>
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 600" :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate">
        <VCard class="">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Edit User Password
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Old Password</VLabel>
                                <VTextField type="password" v-model="userData.currentpassword"
                                    placeholder="Enter Current Password" class="tiggie-resize-input-text"
                                    :error-messages="props?.form?.errors?.currentpassword" />
                            </VCol>


                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Password</VLabel>
                                <VTextField type="password" placeholder="Enter new password"
                                    v-model="userData.updatedpassword" class="tiggie-resize-input-text"
                                    :error-messages="props?.form?.errors?.updatedpassword" />
                            </VCol>
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Confirm Password</VLabel>
                                <VTextField type="password" placeholder="Enter new password again"
                                    v-model="userData.passwordConfirmation" class="tiggie-resize-input-text"
                                    :error-messages="props?.form?.errors?.passwordConfirmation" />
                            </VCol>

                            <!-- 👉 Submit and Cancel -->
                            <VCol cols="12" class="d-flex flex-wrap justify-center gap-10 pt-8">
                                <VBtn color="gray" text-color="white" height="58" class="pl-16 pr-16" @click="onFormReset">
                                    <span class="text-white">Cancel</span>
                                </VBtn>

                                <VBtn type="submit" height="58" class="pl-16 pr-16">
                                    Save
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VContainer>

                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
