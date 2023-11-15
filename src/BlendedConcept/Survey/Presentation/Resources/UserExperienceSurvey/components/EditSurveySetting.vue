<script setup>
import { useForm } from "@inertiajs/vue3";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";
import MultiSelectBox from "@mainRoot/components/MultiSelectBox/MultiSelectBox.vue";

const props = defineProps({
    isDialogVisible: {
        type: Boolean,
        required: true,
    },
    setting: {
        type: Object,
    },
});

// console.log(props.setting);

const emit = defineEmits(["submit", "update:isDialogVisible"]);
const survey_settings_user_types = ref(props.setting.survey_settings);
let user_types = ref([]);

survey_settings_user_types.value.forEach((item) => {
    user_types.value.push(item.user_type);
});

let form = useForm({
    required: props.setting.required == 1 ? true : false,
    repeat: props.setting.repeat == 1 ? true : false,
    user_type: user_types.value,
    appear_on: props.setting.appear_on,
    start_date: props.setting.start_date,
    end_date: props.setting.end_date,
});

const onFormSubmit = () => {
    emit("submit", form);
};

const onFormReset = () => {
    emit("update:isDialogVisible", false);
};

const dialogVisibleUpdate = (val) => {
    emit("update:isDialogVisible", val);
};

const userTypes = ref([
    {
        name: "ORG Admin",
        id: "ORG_ADMIN",
    },
    {
        name: "Parent",
        id: "PARENT",
    },
    {
        name: "Student",
        id: "STUDENT",
    },
    {
        name: "Org Teacher",
        id: "ORG_TEACHER",
    },
    {
        name: "B2C User",
        id: "B2C_USER",
    },
]);

const appearOn = ref([
    {
        title: "Log In",
        value: "LOG_IN",
    },
    {
        title: "Log Out",
        value: "LOG_OUT",
    },
    {
        title: "Book End",
        value: "BOOK_END",
    },
    {
        title: "Game End",
        value: "GAME_END",
    },
]);
</script>

<template>
    <VDialog
        :width="$vuetify.display.smAndDown ? 'auto' : 600"
        :model-value="props.isDialogVisible"
        @update:model-value="dialogVisibleUpdate"
        persistent
    >
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
                                <VLabel class="tiggie-label"
                                    >Set User Type</VLabel
                                >
                                <MultiSelectBox
                                    :items="userTypes"
                                    v-model="form.user_type"
                                />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label"
                                    >Survery Start Date</VLabel
                                >
                                <AppDateTimePicker
                                    placeholder="Select Start Date"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.start_date"
                                    v-model="form.start_date"
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label">Appear On</VLabel>
                                <VSelect
                                    :items="appearOn"
                                    placeholder="Select Frequency"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.appear_on"
                                    v-model="form.appear_on"
                                    rounded="50%"
                                    density="compact"
                                />
                            </VCol>
                            <VCol cols="6" md="6">
                                <VLabel class="tiggie-label"
                                    >Survey End Date</VLabel
                                >
                                <AppDateTimePicker
                                    placeholder="Select End Date"
                                    v-model="form.end_date"
                                    :rules="[requiredValidator]"
                                    :error-messages="form?.errors?.end_date"
                                    density="compact"
                                />
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
                            <VCol
                                cols="12"
                                class="d-flex flex-wrap justify-space-between gap-10 pt-8"
                            >
                                <VBtn
                                    color="gray"
                                    text-color="white"
                                    height="58"
                                    class="pl-16 pr-16"
                                    @click="onFormReset"
                                >
                                    <span class="text-white">Cancel</span>
                                </VBtn>

                                <VBtn
                                    type="submit"
                                    height="58"
                                    class="pl-16 pr-16"
                                >
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

<style scoped>
.blue-outline-field {
    border: 1px solid var(--Primary, rgb(0, 0, 0, 0.2));
    border-radius: 5px;
    background: var(--White, #fff);
    padding: 3px 10px;
}

:deep(.blue-outline-field .v-field__input) {
    padding: 0 !important;
}

.select-search {
    padding: 10px !important;
}
.searchcard-icon {
    padding: 10px;
}

:deep(.blue-outline-field .v-field__input input) {
    line-height: 38px !important;
}
</style>
