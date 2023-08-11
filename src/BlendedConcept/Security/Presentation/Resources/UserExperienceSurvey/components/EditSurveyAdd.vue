<script setup>
import {ref} from "vue"
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

let description = ref("How do you usually provide feedback about the application? (Please select all that apply)")
</script>

<template>
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 600" :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate">
        <VCard class="">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />
            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VContainer>
                        <VRow justify="center">
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Question Type</VLabel>
                                <VSelect :items="items" rounded="50%" density="compact" />
                            </VCol>


                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Question</VLabel>
                                <VTextarea placeholder="Type here ...." v-model="description" auto-grow rows="5" />
                            </VCol>
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label">Options</VLabel>
                                <VSelect :items="items" rounded="50%" density="compact" />
                            </VCol>
                            <VCol cols="12" md="12">
                                <VSelect :items="items" rounded="50%" density="compact" />
                            </VCol>

                            <VCol cols="12" md="12">
                                <VBtn variant="outlined" style="border-radius: 5px;border: 1px dashed rgba(40, 40, 40, 0.50);" block>
                                  <span class="tiggie-p">  Type to add more options</span>
                                </VBtn>
                            </VCol>

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
