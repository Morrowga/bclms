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
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 800" :model-value="props.isDialogVisible"
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
                    <VRow justify="center">
                        <!-- 👉 Contact -->
                        <VCol cols="10" md="10">
                            <VTextField type="text" v-model="userData.name" :error-messages="props?.form?.errors?.name"
                                label="User Name" />
                        </VCol>


                        <!-- 👉 Contact -->
                        <VCol cols="10" md="10">
                            <VTextField type="email" v-model="userData.email" :error-messages="props?.form?.errors?.email"
                                label="User Email" />
                        </VCol>
                        <VCol cols="10" md="10">
                            <VTextField type="text" v-model="userData.contact_number"
                                :error-messages="props?.form?.errors?.contact_number" label="User Contact Number" />
                        </VCol>

                        <!-- 👉 Submit and Cancel -->
                        <VCol cols="10" class="d-flex flex-wrap justify-space-between gap-10">
                            <VBtn color="gray" text-color="white" @click="onFormReset">
                                <Link :href="route('userprofile')" class="pl-5 pr-5">
                                    Cancel
                                </Link>
                            </VBtn>
                            <VBtn type="submit" color="primary" class="">
                                <span class="pl-5 pr-5 text-white">
                                    Submit
                                </span>
                            </VBtn>

                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
        </VCard>
    </VDialog>
</template>
