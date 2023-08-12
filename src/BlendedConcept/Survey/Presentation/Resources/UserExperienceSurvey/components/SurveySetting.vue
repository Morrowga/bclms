<script setup>
import { useForm } from "@inertiajs/vue3"
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
            passwordConfirmation: ""

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
let form = useForm({
    isRequired: false,
    isReport: false,

})

const onFormSubmit = () => {
    // emit('submit', userData.value)
    emit('submit', { title: "Password Changed Successfully" })
}

const onFormReset = () => {
    userData.value = structuredClone(toRaw(props.userData))
    emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
    emit('update:isDialogVisible', val)
}

const items = ref([
    {
        title: 'Edit',
        value: 'edit',
    },
    {
        title: 'Delete',
        value: 'delete',
    }
])
</script>

<template>
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 600" :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate">
        <VCard class="">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Survey setting
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">

                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Set Users Type</VLabel>
                                <VSelect :items="items" rounded="50%" density="compact" />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Survery Start Date</VLabel>
                                <AppDateTimePicker v-model="date" density="compact" />

                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Appear On</VLabel>
                                <VSelect :items="items" rounded="50%" density="compact" />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Survey End Date</VLabel>
                                <AppDateTimePicker v-model="date" density="compact" />
                            </VCol>
                            <!-- 👉 Contact -->
                            <VCol cols="3" md="3">
                                <VLabel class="tiggie-label">Required</VLabel>
                                <VSwitch v-model="form.isReport" inset />
                            </VCol>
                            <VCol cols="3" md="3">
                                <VLabel class="tiggie-label">Repeat</VLabel>
                                <VSwitch v-model="form.isRequired" inset />
                            </VCol>
                            <VCol cols="6"></VCol>

                            <!-- 👉 Submit and Cancel -->
                            <VCol cols="12" class="d-flex flex-wrap justify-space-between gap-10 pt-8">
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
