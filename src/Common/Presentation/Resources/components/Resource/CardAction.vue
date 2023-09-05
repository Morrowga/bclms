<script setup>
import { router } from "@inertiajs/core";
import EditModal from "@mainRoot/components/Resource/EditModal.vue";
import { isConfirmedDialog } from "@actions/useConfirm";
import { SuccessDialog } from "@actions/useSuccess";
import { usePage } from "@inertiajs/vue3";

let props = defineProps(["route", "title", "type"]);
let page = usePage();
let user_role = computed(() => page.props.user_info.user_role.name);
const isEditDialogVisible = ref(false);
const selectedImage = ref(null);

const handleFileUpload = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        selectedImage.value = URL.createObjectURL(selectedFile);
    }
};

const fileInput = ref(null);

let onFormSubmit = () => {
    isConfirmedDialog({ title: "Are you sure want to delete it." });
};

const openFileInput = () => {
    fileInput.value.click();
};

const publish = () => {
    SuccessDialog({
        title: "You have successfully requested",
        color: "#17CAB6",
    });
};
const checkIsOrg = () => {
    return user_role.value == "Organization Admin" ? true : false;
};
</script>
<template #activator="{ props }">
    <div>
        <span class="resourcemenu">
            ...

            <v-menu activator="parent">
                <v-list>
                    <v-list-item @click="isEditDialogVisible = true">
                        <v-list-item-title>Edit</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="onFormSubmit">
                        <v-list-item-title>Delete</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="publish()" v-if="!checkIsOrg()">
                        <v-list-item-title
                            >Publish to Organization</v-list-item-title
                        >
                    </v-list-item>
                </v-list>
            </v-menu>
        </span>
        <VDialog v-model="isEditDialogVisible" width="1000">
            <!-- Activator -->
            <!-- Dialog Content -->
            <VCard class="rolling-card">
                <VCardText>
                    <div class="d-flex justify-space-between">
                        <div>
                            <span class="ruddy-bold resource-create-title"
                                >Edit File</span
                            >
                        </div>
                        <div class="mt-2">
                            <v-icon @click="isEditDialogVisible = false"
                                >mdi-close</v-icon
                            >
                        </div>
                    </div>
                    <div class="mt-5">
                        <div>
                            <span class="input-label-resource"
                                >Filename <span class="star">*</span></span
                            >
                            <VTextField class="textfield-round" />
                        </div>
                        <div class="mt-3">
                            <span class="input-label-resource"
                                >Uploaded File <span class="star">*</span></span
                            >
                            <div>
                                <div class="uploadedchip text-left mt-2">
                                    <div class="d-flex">
                                        <v-img
                                            src="/images/chair.jpeg"
                                            width="60"
                                            height="50"
                                            cover
                                        ></v-img>
                                        <span class="mt-4 ml-2"
                                            >themonkeysad.jpg</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <VCard
                                class="upload-card-resource"
                                @click="openFileInput"
                            >
                                <v-img
                                    v-if="selectedImage"
                                    class="image-resource"
                                    :src="selectedImage"
                                    cover
                                ></v-img>
                                <div v-else class="card-text">
                                    <div class="text-center">
                                        <div class="d-flex justify-center">
                                            <img
                                                src="/images/Icons.png"
                                                width="100"
                                            />
                                        </div>
                                        <div class="mt-2">
                                            <span class="drag-text">
                                                Drag your item to upload
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="fade-text">
                                                PNG, GIF, WebP, MP4 or MP3.
                                                Maximum file size 100 Mb.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </VCard>
                            <div>
                                <input
                                    type="file"
                                    ref="fileInput"
                                    style="display: none"
                                    @change="handleFileUpload"
                                />
                            </div>
                            <div class="mt-10 d-flex justify-center">
                                <v-btn
                                    varient="flat"
                                    color="#F6F6F6"
                                    class="cancel pppangram-bold"
                                    @click="isEditDialogVisible = false"
                                    width="200"
                                    rounded
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    varient="flat"
                                    color="#3749E9"
                                    class="textcolor ml-2 pppangram-bold"
                                    width="200"
                                    rounded
                                >
                                    Save
                                </v-btn>
                            </div>
                        </div>
                    </div>
                </VCardText>
            </VCard>
        </VDialog>
    </div>
</template>
<style>
.uploadedchip {
    display: flex;
    background: #e5e5e5;
    border-radius: 15px;
    align-items: center;
    width: 100%;
    padding: 16px 10px 16px 16px;
    gap: 15px;
    height: 74px;
    /* display: block; */
}
.resource-create-title {
    color: #161616 !important;
    /* H3 Ruddy */
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.resourcemenu {
    font-weight: bold !important;
    font-size: 20px !important;
    position: absolute !important;
    z-index: 1 !important;
    cursor: pointer;
    color: #000 !important;
    right: 6%;
}

.image-resource {
    height: 300px;
}

.input-label-resource {
    color: #000 !important;
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}
.upload-card-resource {
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}

:deep(#input-162) {
    border-radius: 100px !important;
}
</style>
