<script setup>
import {Link} from "@inertiajs/inertia-vue3"
const props = defineProps({
    form: {
        type: Object
    },
    userData: {
        type: Object,
        required: false,
        default: () => ({
            name: "",
            email: "",
            contact_number: ""

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
    emit('submit',{title:"You have succesfully edited your profiled"});
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
        <VCard class="pa-sm-9 pa-5">
            <!-- 👉 dialog close btn -->
            <DialogCloseBtn variant="text" size="small" @click="onFormReset" />

            <VCardItem class="text-left pl-16">
                <VCardTitle class="te mb-2 tiggie-title">
                    Edit Profile
                </VCardTitle>
            </VCardItem>

            <VCardText>
                <!-- 👉 Form -->
                <VForm class="mt-6" @submit.prevent="onFormSubmit">
                    <VRow >
                        <!-- 👉 Contact -->
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">User Name</VLabel>
                            <VTextField
                            type="text"
                            class="tiggie-resize-input-text"
                            v-model="userData.name"
                            :error-messages="props?.form?.errors?.name"/>
                        </VCol>


                        <!-- 👉 Contact -->
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">User Email</VLabel>
                            <VTextField
                            type="email"
                            v-model="userData.email"
                            class="tiggie-resize-input-text"
                            :error-messages="props?.form?.errors?.email"/>
                        </VCol>
                        <VCol cols="12" md="12">
                            <VLabel class="tiggie-label">User Contact Number</VLabel>
                            <VTextField
                            type="text"
                            v-model="userData.contact_number"
                            class="tiggie-resize-input-text"
                            :error-messages="props?.form?.errors?.contact_number"/>
                        </VCol>

                        <!-- 👉 Submit and Cancel -->
                        <VCol cols="12" class="d-flex flex-wrap justify-center gap-10 pt-8">
                            <!-- <VBtn color="gray" text-color="white" height="58" @click="onFormReset">
                                <Link :href="route('userprofile')" class="pl-5 pr-5">
                                    Cancel
                                </Link>
                            </VBtn>
                            <VBtn type="submit" color="primary" height="58" class="">
                                <span class="pl-5 pr-5 text-white">
                                    Save
                                </span>
                            </VBtn> -->
                            <VBtn color="gray" text-color="white" height="58" class="pl-16 pr-16" @click="onFormReset">
                                Cancel
                            </VBtn>

                            <VBtn type="submit" height="58" class="pl-16 pr-16">
                                Submit
                             </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
