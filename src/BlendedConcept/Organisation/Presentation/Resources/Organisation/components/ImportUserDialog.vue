<script setup>
import { ref, defineEmits } from "vue";
import ImageUpload from "@mainRoot/components/DropZone/Index.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import exportFromJSON from "export-from-json";
const isDialogVisible = ref(false);
let props = defineProps(["type", "organisation_id"]);
const emit = defineEmits();
const items = [
    "Blended Concepted",
    "Blended Center",
    "Bentlee School of Hope",
    "Korbbe Collibe Home",
];
const uploadedImages = ref([]);
const fileInput = ref(null);

let export_errors = computed(() => usePage().props.export_errors);

const form = useForm({
    organisation_id: props.organisation_id,
    file: "",
    type: props.type,
});

const handleDrop = (event) => {
    event.preventDefault();
    const files = event.dataTransfer.files;

    if (files.length > 0) {
        for (const file of files) {
            uploadedImages.value.push({
                file: file,
                src: URL.createObjectURL(file),
                name: file.name,
            });
        }
    }
};

const importUser = () => {
    form.post(route("teachers.import"), {
        onSuccess: (response) => {
            console.log(response);
            if (export_errors.value && export_errors.value?.length > 0) {
                const data = export_errors.value;
                const fileName = "FailToImportStudent";
                const exportType = exportFromJSON.types.csv;
                if (data) exportFromJSON({ data, fileName, exportType });
                isDialogVisible.value = false;
                emit("closeDialog");
                return;
            }
        },
        onError: (error) => {
            console.log(error, "not okay par");
        },
    });
};

const removeUploadedItem = (index) => {
    uploadedImages.value.splice(index, 1);
};

const handleImport = () => {
    alert("okay par");
};
onUpdated(() => {
    form.organisation_id = props.organisation_id;
    form.type = props.type;
});
</script>

<template>
    <VDialog v-model="isDialogVisible" width="500">
        <!-- Activator -->
        <template #activator="{ props }">
            <VBtn
                v-bind="props"
                color="tiggie-blue"
                variant="flat"
                width="164px"
                height="51px"
            >
                <span class="text-light">Next</span>
            </VBtn>
        </template>

        <!-- Dialog Content -->
        <VCard class="d-flex justify-center">
            <VCardTitle
                class="d-flex justify-space-between align-center ml-7 mr-7 gap-16"
            >
                <h4 class="tiggie-title">Upload {{ props.type }}</h4>
                <VIcon
                    icon="mdi-file-download"
                    class="ml-10"
                    color="tiggie-blue"
                    size="30px"
                />
            </VCardTitle>
            <ImageUpload data_type="user" v-model="form.file" />

            <VCardActions
                class="d-flex justify-space-between gap-5 ml-7 mr-7 mt-5"
            >
                <VBtn
                    color="gray"
                    variant="flat"
                    width="164px"
                    @click="isDialogVisible = false"
                    height="51px"
                >
                    <span class="text-light">Cancel</span>
                </VBtn>
                <VBtn
                    color="tiggie-blue"
                    variant="flat"
                    width="164px"
                    height="51px"
                    @click="importUser"
                >
                    <span class="text-light">Upload</span>
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<style scoped>
.import-file-img {
    width: 40px;
    height: 40px;
}

.import-card-text {
    cursor: pointer;
    border-radius: 10px;
    border: 2px dashed var(--gray, #bfc0c1);
    padding: 10px;
    border-spacing: 4px !important; /* Adjust the spacing between dashes */
    justify-content: center;
    align-items: center;
}

.image-container {
    background: #f6f6f6;
    border-radius: 15px;
    border: 1px solid var(--line, #e5e5e5);
    padding: 4px;
}

.import-fade-text {
    color: var(--secondary-2, rgba(86, 86, 96, 0.4));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important; /* 157.143% */
    text-transform: capitalize !important;
}
.importfile-title {
    color: var(--tiggie-blue, #4066e4);
    font-size: 25px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 42px; /* 140% */
    text-transform: capitalize;
}
</style>
