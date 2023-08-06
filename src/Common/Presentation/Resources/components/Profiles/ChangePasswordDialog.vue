<script setup>
const props = defineProps({
  form :{
    type : Object
  },
  userData: {
    type: Object,
    required: false,
    default: () => ({
      currentpassword:"",
      updatedpassword:""

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
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 800"
    :model-value="props.isDialogVisible"
    @update:model-value="dialogVisibleUpdate"
  >
    <VCard class="pa-sm-9 pa-5">
      <!-- 👉 dialog close btn -->
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="onFormReset"
      />

      <VCardItem class="text-left pl-16">
        <VCardTitle class="te mb-2 tiggie-title">
          Edit User Password
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <!-- 👉 Form -->
        <VForm
          class="mt-6"
          @submit.prevent="onFormSubmit"
        >
          <VRow justify="center">
            <!-- 👉 Contact -->
            <VCol
              cols="10"
              md="10"
            >
              <VTextField
                type="password"
                v-model="userData.currentpassword"
                :error-messages="props?.form?.errors?.currentpassword"
                label="Old Password"
              />
            </VCol>


            <!-- 👉 Contact -->
            <VCol
              cols="10"
              md="10"
            >
              <VTextField
                type="password"
                v-model="userData.updatedpassword"
                :error-messages="props?.form?.errors?.updatedpassword"
                label="Password"
              />
            </VCol>
            <VCol
              cols="10"
              md="10"
            >
              <VTextField
                type="password"
                v-model="userData.updatedpassword"
                :error-messages="props?.form?.errors?.updatedpassword"
                label="Comfirm Password"
              />
            </VCol>

            <!-- 👉 Submit and Cancel -->
            <VCol
              cols="10"
              class="d-flex flex-wrap justify-space-between gap-10"
            >
            <VBtn
                color="gray"
                class="pl-16 pr-16"
                text-color="white"
                @click="onFormReset"
              >
                Cancel
              </VBtn>
              <VBtn
               type="submit"
               class="pl-16 pr-16">
                Submit
              </VBtn>


            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
