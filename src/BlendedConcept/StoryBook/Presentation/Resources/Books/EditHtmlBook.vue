<script setup>
import { defineProps, ref } from "vue";
import { SuccessDialog } from "@actions/useSuccess";
import { FlashMessage } from "@actions/useFlashMessage";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
import ImageDropFile from "@mainRoot/components/DropFile/ImageDropFile.vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import {
    emailValidator,
    requiredValidator,
    integerValidator,
} from "@validators";

const props = defineProps(["storybook", "story_book_versions"]);
let dialog = ref(false);
const toggleDialog = () => {
    dialog.value = !dialog.value;
};
let refForm = ref();
const isFormValid = ref(false);
const page = usePage();
let flash = computed(() => page?.props?.flash);

const form = useForm({
    name: "",
    description: "",
    num_gold_coins: 0,
    num_silver_coins: 0,
    html_files: [],
    existing_files: [],
    delete_ids: [],
    type: "",
    is_free: false,
    _method: "PUT",
});
const items = ref([]);

const addRow = () => {
    items.value.push({ name: "", file: null, param: "" });
};
const removeRow = (index) => {
    items.value.splice(index, 1);
};
const removeExistingRow = (index, id) => {
    form.existing_files.splice(index, 1);
    form.delete_ids.push(id);
};
let onFormSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        form.html_files = items.value;
        form.post(route("books.update", props.storybook.id), {
            onSuccess: () => {
                FlashMessage({ flash });
            },
            onError: (error) => {
                SuccessDialog({
                    title: error.h5p_id,
                    mainTitle: "Error!",
                    color: "#ff6262",
                    icon: "error",
                });
            },
        });
    });
};

const backHome = () => {
    router.get(route("books.index"));
};

onMounted(() => {
    form.name = props.storybook.name;
    form.description = props.storybook.description;
    form.num_gold_coins = props.storybook.num_gold_coins;
    form.num_silver_coins = props.storybook.num_silver_coins;
    form.is_free = props.storybook.is_free ? true : false;
    form.type = props.storybook.type;
    form.existing_files = props.story_book_versions.map((book_version) => {
        return {
            id: book_version.id,
            name: book_version.name,
            param: book_version.param,
            file: null,
        };
    });
});
</script>
<template>
    <AdminLayout>
        <VContainer class="book-create-container">
            <p class="heading">Edit Book</p>
            <VForm
                class="mt-6"
                ref="refForm"
                v-model="isFormValid"
                @submit.prevent="onFormSubmit"
            >
                <div>
                    <div
                        v-for="(item, index) in form.existing_files"
                        :key="index"
                    >
                        <VRow>
                            <VCol cols="12" md="6">
                                <VLabel class="tiggie-label required"
                                    >Version Name</VLabel
                                >
                                <VTextField
                                    v-model="item.name"
                                    :rules="[requiredValidator]"
                                />

                                <VLabel class="tiggie-label"
                                    >Extra Param</VLabel
                                >
                                <VTextField
                                    v-model="item.param"
                                />

                                <VBtn
                                    class="mt-4"
                                    v-if="index > 0"
                                    @click="removeExistingRow(index, item.id)"
                                    color="candy-red"
                                    >Remove Version</VBtn
                                >
                            </VCol>
                            <VCol cols="12" md="6">
                                <VLabel class="tiggie-label required"
                                    >Storybook File</VLabel
                                >
                                <ImageDropFile
                                    memeType="zip"
                                    :id="`existing${index}`"
                                    v-model="item.file"
                                    :old_filename="`${item.name}.zip`"
                                />
                            </VCol>
                        </VRow>
                    </div>
                    <div v-for="(item, index) in items" :key="index">
                        <VRow>
                            <VCol cols="12" md="6">
                                <VLabel class="tiggie-label required"
                                    >Version Name</VLabel
                                >
                                <VTextField
                                    v-model="item.name"
                                    :rules="[requiredValidator]"
                                />

                                <VLabel class="tiggie-label"
                                    >Extra Param</VLabel
                                >
                                <VTextField
                                    v-model="item.param"
                                />

                                <VBtn
                                    class="mt-4"
                                    @click="removeRow(index)"
                                    color="candy-red"
                                    >Remove Version</VBtn
                                >
                            </VCol>
                            <VCol cols="12" md="6">
                                <VLabel class="tiggie-label required"
                                >Storybook File</VLabel
                                >
                                <ImageDropFile
                                    memeType="zip"
                                    :id="`html5${index}`"
                                    v-model="item.file"
                                />
                            </VCol>
                        </VRow>
                    </div>
                    <div class="d-flex justify-center my-6">
                        <VBtn
                            @click="addRow"
                            width="300"
                            color="teal"
                            class="text-white"
                            >Add Version</VBtn
                        >
                    </div>
                </div>
                <VRow>
                    <VCol cols="12" md="12">
                        <div class="d-flex justify-center aligns-center w-100">
                            <div>
                                <VBtn
                                    color="gray"
                                    height="50"
                                    class=""
                                    width="200"
                                    @click="backHome()"
                                >
                                    Cancel
                                </VBtn>

                                <VBtn
                                    type="submit"
                                    class="ml-10"
                                    height="50"
                                    width="200"
                                >
                                    Add
                                </VBtn>
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VForm>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}
.book-create-container {
    width: 75%;
}
.h5p-width {
    width: 100%;
    height: 1500px;
}
.faded-image {
    position: relative;
    display: inline-block;
    width: 100%;
}

.faded-image img {
    display: block;
    height: 270px;
    width: 100%;
    object-fit: fill;
    position: relative;
}

.faded-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%; /* Adjust this value to control the height of the fading effect */
    background: linear-gradient(
        to bottom,
        transparent,
        white
    ); /* Adjust the colors as needed */
}

.book-title {
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 40px;
}
.book-title span {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
}

.close-btn {
    position: absolute;
    top: 0;

    right: 0;
}
.v-btn--icon {
    border-radius: 10px;
    scale: 0.7;
}
.chip-1 {
    background: rgba(255, 166, 0, 0.464);
    color: #fff !important;
}
.chip-2 {
    background: rgba(217, 23, 13, 0.464);
    color: #fff !important;
}
.chip-3 {
    background: rgba(72, 255, 0, 0.464);
    color: #fff !important;
}
.coming-soon {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
    height: 200px;
    border: 1px dashed black;
    border-radius: 10px;
}
.coming-soon p {
    margin-bottom: 0;
}

:deep(.game-tag-add .v-field__append-inner svg) {
    width: 30px;
    height: 30px;
}

:deep(.game-name-input .v-input__details) {
    margin-top: 10px !important;
}

:deep(.disability-type-input .v-input__details) {
    margin-top: 10px !important;
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
