<script setup>
import { useForm, Link, usePage } from "@inertiajs/vue3";
import { ref, defineProps, computed } from "vue";
import { emailValidator, requiredValidator } from "@validators";
import ImageUpload from "@Composables/ImageUpload.vue";
import { toastAlert } from "@Composables/useToastAlert";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";

const isFormValid = ref(false);
const isDialogVisible = ref(false);
let refForm = ref();

let flash = computed(() => usePage().props.flash);

const props = defineProps(["reward"]);

let form = useForm({
    name: props.reward.name ?? "",
    description: props?.reward?.description ?? "",
    file_src: props?.reward?.file_src ?? "",
    gold_coins_needed: props?.reward?.gold_coins_needed,
    silver_coins_needed: props?.reward?.silver_coins_needed,
    rarity: props?.reward?.rarity ?? "",
    image: props?.reward.image_url,
    _method: "PUT",
});

const ratity = ref([
    "SELECT",
    "COMMON",
    "RARE",
    "SUPERRARE",
    "EPIC",
    "LEGENDARY",
]);

// submit create form
let handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("rewards.update", props.reward.id), {
                onSuccess: () => {
                    FlashMessage({ flash });
                    isDialogVisible.value = false;
                },
                onError: (error) => {},
            });
        }
    });
};
</script>

<template>
    <AdminLayout>
        <div>
            <VForm
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="handleSubmit"
            >
                <VContainer>
                    <VRow>
                        <VCol cols="6">
                            <span class="text-xl tiggie-title"
                                >Reward Particulars</span
                            >
                            <VRow class="pt-5">
                                <VCol cols="8">
                                    <VLabel class="tiggie-label">Name</VLabel>
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.name"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="form?.errors?.name"
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label"
                                        >Description</VLabel
                                    >
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.description"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="
                                            form?.errors?.description
                                        "
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label"
                                        >Gold Coins Required</VLabel
                                    >
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.gold_coins_needed"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="
                                            form?.errors?.gold_coins
                                        "
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label"
                                        >Silver Coins Required</VLabel
                                    >
                                    <VTextField
                                        density="compact"
                                        placeholder="Type here ..."
                                        v-model="form.silver_coins_needed"
                                        class="w-100"
                                        :rules="[requiredValidator]"
                                        :error-messages="
                                            form?.errors?.silver_coins
                                        "
                                    />
                                </VCol>
                                <VCol cols="8">
                                    <VLabel class="tiggie-label">Rarity</VLabel>
                                    <VSelect
                                        :items="ratity"
                                        rounded="50%"
                                        density="compact"
                                        :error-messages="forms?.errors?.rarity"
                                        v-model="form.rarity"
                                    />
                                </VCol>
                            </VRow>
                        </VCol>
                        <VCol cols="6" class="pt-5">
                            <span class="tiggie-title">Sticker</span>
                            <br />

                            <ImageUpload
                                v-model="form.image"
                                :old_img="form.image"
                            />
                        </VCol>
                        <VCol
                            cols="12"
                            class="d-flex flex-wrap justify-center gap-10"
                        >
                            <Link
                                :href="route('rewards.index')"
                                class="text-black"
                            >
                                <VBtn
                                    color="gray"
                                    height="50"
                                    class=""
                                    width="300"
                                >
                                    Cancel
                                </VBtn>
                            </Link>
                            <VBtn
                                type="submit"
                                class=""
                                height="50"
                                width="300"
                            >
                                Finish
                            </VBtn>
                        </VCol>
                    </VRow>
                </VContainer>
            </VForm>
        </div>
    </AdminLayout>
</template>

<style scoped>
.logo-position {
    /* position: absolute;
    top: 180px; */
}

.padding-left-40px {
    padding-left: 40px;
}
</style>
