<template>
    <div class="card">
        <h5 class="pb-3">App Name</h5>
        <div class="grid grid-cols-12 gap-3">
            <div class="flex flex-col col-span-3 flex-wrap gap-2">
                <label for="app_name">App Name</label>
                <InputText
                    id="app_name"
                    v-model="value"
                    aria-describedby="username-help"
                />
            </div>
            <div class="col-span-9"></div>

            <div class="flex flex-col lg:col-span-4 col-span-12 pr-2 gap-2">
                <label for="app_name">Application Logo</label>
                <div class="card">
                    <Toast />
                    <FileUpload
                        name="photo"
                        @upload="onAdvancedUpload('applogo')"
                        accept="image/*"
                        multiple="false"
                        :maxFileSize="10000000"
                    >
                        <!-- custome buttton  -->
                        <template #header="{chooseCallback,clearCallback,files}">
                            <div class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2">
                                <div class="flex gap-2">
                                    <Button
                                        @click="chooseCallback()"
                                        icon="pi pi-images"
                                        rounded
                                        outlined
                                    ></Button>
                                    <Button
                                        @click="uploadEvent(files)"
                                        icon="pi pi-cloud-upload"
                                        rounded
                                        outlined
                                        severity="success"
                                        :disabled="!files || files.length === 0"
                                    ></Button>
                                    <Button
                                        @click="clearCallback()"
                                        icon="pi pi-times"
                                        rounded
                                        outlined
                                        severity="danger"
                                        :disabled="!files || files.length === 0"
                                    ></Button>
                                </div>
                            </div>
                        </template>
                        <!-- custom button end -->
                        <template #empty>
                            <p>Drag and drop files to here to upload.</p>
                        </template>
                    </FileUpload>
                </div>
            </div>
            <div class="flex flex-col col-span-3 gap-2">
                <label for="app_name">Upload Photo</label>
                <InputText
                    id="app_name"
                    v-model="value"
                    aria-describedby="username-help"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import InputText from "primevue/inputtext";
import FileUpload from "primevue/fileupload";
import Toast from "primevue/toast";
// setup up image upload
import { useToast } from "primevue/usetoast";
const toast = useToast();

// uplaode images
const uploadEvent = (files) => {
    console.log(files)
};

// upload error settings
const onAdvancedUpload = (value) => {
    // save site logo
    console.log(value);
    if (value == "applogo") {
        alert("Upload Site Image successfully");
    }
    toast.add({
        severity: "info",
        summary: "Success",
        detail: "File Uploaded",
        life: 3000,
    });
};
</script>
