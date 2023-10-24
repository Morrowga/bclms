<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";
import { requiredValidator } from "@validators";
const props = defineProps(["disability_type"]);
const form = useForm({
    name: "",
    description: "",
    sub_learnings: [],
    delete_sub_learnings: [],
    _method: "PUT",
});
const isDialogVisible = ref(false);
const isFormValid = ref(false);
const enterSubLearning = ref("");
let refForm = ref();
let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(
                route("learning_need.update", props.disability_type?.id),
                {
                    onSuccess: ({props}) => {
                        let success = props.flash?.successMessage;
                        if(success !== null)
                        {
                            SuccessDialog({ title: success });
                        }else{
                            SuccessDialog({
                                title: props.flash?.errorMessage,
                                mainTitle: "Error!",
                                color: "#ff6262",
                                icon: "error",
                            });
                        }
                        isDialogVisible.value = false;
                    },
                    onError: (error) => {},
                }
            );
        }
    });
};

const onFormReset = () => {
    isDialogVisible.value = false;
};

const dialogVisibleUpdate = (val) => {};
const addToSublearningArray = (e) => {
    if (enterSubLearning.value) {
        form.sub_learnings.push({
            name: enterSubLearning.value,
            id: null,
        });
        enterSubLearning.value = "";
    }
};
const removeFromArray = (index, id) => {
    if (id) {
        form.delete_sub_learnings.push(id);
    }
    form.sub_learnings = form.sub_learnings.filter(
        (sublearning, i) => i != index
    );
};
onUpdated(() => {
    form.name = props.disability_type.name;
    form.description = props.disability_type?.description;
    form.sub_learnings = props.disability_type?.sub_learnings;
});
</script>

<template>
    <div>
        <VDialog v-model="isDialogVisible" max-width="600">
            <template #activator="{ props }">
                <VListItem v-bind="props" @click="() => {}">
                    <VListItemTitle>Edit</VListItemTitle>
                </VListItem>
            </template>
            <VCard class="pa-sm-9 pa-5">
                <!-- 👉 dialog close btn -->
                <DialogCloseBtn
                    variant="text"
                    size="small"
                    @click="onFormReset"
                />

                <VCardItem class="text-left">
                    <VCardTitle class="te mb-2 tiggie-title">
                        Edit Learning Need
                    </VCardTitle>
                </VCardItem>

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm
                        class="mt-6"
                        ref="refForm"
                        v-model="isFormValid"
                        @submit.prevent="handleSubmit"
                    >
                        <VRow>
                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Learning Needs Type</VLabel
                                >
                                <VTextField
                                    type="text"
                                    class="tiggie-resize-input-text"
                                    v-model="form.name"
                                    :rules="[requiredValidator]"
                                />
                            </VCol>
                            <VCol cols="12" md="12" class="sub-learning-add">
                                <VLabel class="tiggie-label"
                                    >Sub Learning Type</VLabel
                                >
                                <div
                                    class="d-flex my-4"
                                    v-if="form.sub_learnings.length > 0"
                                >
                                    <div
                                        class="ps-relative"
                                        v-for="(
                                            sub_learning, index
                                        ) in form.sub_learnings"
                                        :key="index"
                                    >
                                        <v-chip size="small" color="primary">{{
                                            sub_learning.name
                                        }}</v-chip>
                                        <div
                                            class="delete-chip"
                                            @click="
                                                removeFromArray(
                                                    index,
                                                    sub_learning.id
                                                )
                                            "
                                        >
                                            <span>-</span>
                                        </div>
                                    </div>
                                </div>
                                <VTextField
                                    v-model="enterSubLearning"
                                    append-inner-icon="mdi-add-circle"
                                    @click:append-inner="addToSublearningArray"
                                >
                                </VTextField>
                            </VCol>

                            <!-- 👉 Contact -->
                            <VCol cols="12" md="12">
                                <VLabel class="tiggie-label"
                                    >Description</VLabel
                                >
                                <VTextarea
                                    placeholder="Type here ...."
                                    v-model="form.description"
                                    auto-grow
                                    rows="5"
                                />
                            </VCol>

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
                                    Cancel
                                </VBtn>

                                <VBtn
                                    type="submit"
                                    height="58"
                                    class="pl-16 pr-16"
                                >
                                    Submit
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
<style scoped>
:deep(.sub-learning-add .v-field__append-inner svg) {
    width: 30px;
    height: 30px;
}
.delete-chip {
    background: rgb(109, 120, 141);
    border-radius: 50%;
    width: 15px;
    height: 15px;
    color: #fff;
    text-align: center;
    position: absolute;
    right: -4px;
    top: -5px;
    cursor: pointer;
}
.delete-chip span {
    position: absolute;
    top: -6px;
    left: 0;
    bottom: 0;
    right: 0;
    color: #fff;
}
</style>
