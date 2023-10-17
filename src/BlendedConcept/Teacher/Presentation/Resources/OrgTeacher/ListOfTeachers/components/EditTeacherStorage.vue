<script setup>
import { useForm } from "@inertiajs/vue3";
import { SuccessDialog } from "@actions/useSuccess";

const isDialogVisible = ref(false);
const props = defineProps(["data"]);
const isFormValid = ref(false);
let flash = computed(() => usePage().props.flash);

let refForm = ref();
const form = useForm({
    teacher_id: props.data?.teacher_id,
    storage: props.data?.allocated_storage_limit,
    _method: "PUT",
});
const handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(
                route("listoforgteacher.update_storage", form.teacher_id),
                {
                    onSuccess: () => {
                        SuccessDialog({ title: flash?.successMessage });
                        isDialogVisible.value = false;
                    },
                    onError: (error) => {},
                }
            );
        }
    });
};
const setImage = () => {
    return props.data?.user?.profile_pic == "" || !props.data?.user?.profile_pic
        ? "/images/teacherimg.png"
        : props.data?.user?.profile_pic;
};

const calculatePercent = (specific, total) => {
    if (total === 0) {
        return 0; // To avoid division by zero error
    }

    return (specific / total) * 100;
};
</script>

<template>
    <VDialog v-model="isDialogVisible" width="600">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn v-bind="props" color="gray" class="text-dark" rounded>
                Edit
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
            @keydown.enter="$event.preventDefault()"
        >
            <VCard>
                <VRow justify="space-between" class="pa-2">
                    <VCol cols="4" class="teacher-profile">
                        <img :src="setImage()" class="tggie-student-img" />
                    </VCol>
                    <VCol cols="8" class="allocated-storage">
                        <div class="d-flex align-center justify-center">
                            <p class="tiggie-teacher-label fs-24">
                                Allocated Storage
                            </p>
                            <VTextField
                                placeholder="200"
                                height="38px"
                                width="58px"
                                v-model="form.storage"
                            />
                            <VLabel class="tiggie-teacher-label">MB</VLabel>
                        </div>
                        <div class="d-flex">
                            <v-sheet
                                width="100%"
                                height="42px"
                                color="#BFC0C1"
                                class="d-flex my-4 rounded overflow-hidden edit-percent"
                            >
                                <v-sheet
                                    class="pt-3"
                                    color="teal"
                                    height="100%"
                                    :width="`${
                                        (calculatePercent(
                                            props.data.used_storage,
                                            props.data.allocated_storage_limit
                                        ) /
                                            100) *
                                        100
                                    }%`"
                                >
                                </v-sheet>
                                <span class="mx-3 text-white storage-value"
                                    >{{ props.data.used_storage }} MB</span
                                >
                            </v-sheet>
                        </div>
                        <div class="d-flex gap-3 align-center">
                            <div>
                                <VIcon
                                    icon="mdi-circle"
                                    color="teal"
                                    class="mr-3"
                                />
                                <span>Used</span>
                            </div>
                            <div>
                                <VIcon icon="mdi-circle" class="mr-3" />
                                <span>Available</span>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="6">
                        <p class="tiggie-subtitle">
                            {{ props.data?.user?.full_name }}
                        </p>
                    </VCol>
                    <VCol cols="6" class="text-end pr-3">
                        <VBtn
                            color="gray"
                            class="text-dark"
                            rounded
                            type="submit"
                        >
                            Save
                        </VBtn>
                    </VCol>
                </VRow>
            </VCard>
        </VForm>
    </VDialog>
</template>
<style scoped>
.edit-percent {
    position: relative;
}
.storage-value {
    position: absolute;
    left: 0 !important;
    right: 0 !important;
    top: 10px !important;
}
</style>
