<script setup>
import { useForm } from "@inertiajs/vue3"
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

const props = defineProps({
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
})

const emit = defineEmits([
    'submit',
    'update:isDialogVisible',
])

let form = useForm({
    required: false,
    repeat: false,
    user_type: null,
    appear_on: null,
    start_date: null,
    end_date: null,
})

const onFormSubmit = () => {
    emit('submit', form)
}

const onFormReset = () => {
    emit('update:isDialogVisible', false)
}

const dialogVisibleUpdate = val => {
    emit('update:isDialogVisible', val)
}

const userTypes = ref([
    // {
    //     title: 'All',
    //     value: 'All',
    // },
    {
        title: 'BC Staff',
        value: 'BC_STAFF',
    },
    {
        title: 'Org Teacher',
        value: 'ORG_TEACHER',
    },
    {
        title: 'B2C User',
        value: 'B2C_USER',
    },
])

const appearOn = ref([
    {
        title: 'Log In',
        value: 'LOG_IN',
    },
    {
        title: 'Log Out',
        value: 'LOG_OUT',
    },
    {
        title: 'Book End',
        value: 'BOOK_END',
    },
    {
        title: 'Game End',
        value: 'GAME_END',
    },
])
</script>

<template>
    <VDialog :width="$vuetify.display.smAndDown ? 'auto' : 600" :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate" persistent>
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
                                <VLabel class="tiggie-label">Set User Type</VLabel>
                                <VSelect :items="userTypes" v-model="form.user_type" :rules="[requiredValidator]"  :error-messages="form?.errors?.user_type" placeholder="Select User Types" rounded="50%" density="compact" />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Survery Start Date</VLabel>
                                <AppDateTimePicker placeholder="Select Start Date" :rules="[requiredValidator]"  :error-messages="form?.errors?.start_date"  v-model="form.start_date" density="compact" />

                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Appear On</VLabel>
                                <VSelect :items="appearOn" placeholder="Select Frequency" :rules="[requiredValidator]"  :error-messages="form?.errors?.appear_on"  v-model="form.appear_on" rounded="50%" density="compact" />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Survey End Date</VLabel>
                            <AppDateTimePicker placeholder="Select End Date" v-model="form.end_date" :rules="[requiredValidator]"  :error-messages="form?.errors?.end_date"  density="compact" />
                            </VCol>
                            <!-- 👉 Contact -->
                            <VCol cols="3" md="3">
                                <VLabel class="tiggie-label">Required</VLabel>
                                <VSwitch v-model="form.required" inset />
                            </VCol>
                            <VCol cols="3" md="3">
                                <VLabel class="tiggie-label">Repeat</VLabel>
                                <VSwitch v-model="form.repeat" inset />
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
