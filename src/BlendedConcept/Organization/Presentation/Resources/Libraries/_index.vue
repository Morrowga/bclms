<template>
    <AdminLayout>
        <h1>Library Media Interface</h1>
        <v-card>
            <div
                class="d-flex justify-space-between bg-surface-variant mt-3 px-3 py-5"
            >
                <div class="d-flex gap-3">
                    <VBtn color="success">
                        Upload
                        <VIcon end icon="mdi-cloud-upload-outline" />
                    </VBtn>
                    <VBtn color="success">
                        create
                        <VIcon end icon="mdi-folder-plus" />
                    </VBtn>
                </div>
            </div>
            <div class="mt-5 ml-5">
                <v-row v-if="currentdir">
                    <v-col cols="2">
                        <vcard>
                            <VImg
                                src="https://random.imagecdn.app/100/100"
                                width="150"
                                height="150"
                            />
                            <v-card-title class="text-sm text-wrap w-80"
                                >text image name dnddd ddddd
                            </v-card-title>
                        </vcard>
                    </v-col>
                    <v-col cols="2" v-for="organization in props.site_settings.organizations" :key="organization.id">
                        <vcard>
                            <VImg :src="folder" width="150" height="150" />
                            <v-card-title
                                class="text-sm text-wrap font-weight-bold w-80"
                                >
                            {{organization.name}}
                         </v-card-title>
                        </vcard>
                    </v-col>
                    <v-col cols="2">
                        <vcard @click="handleChange">
                            <VImg :src="folder" width="150" height="150" />
                            <v-card-title
                                class="text-sm text-uppercase text-wrap w-80 font-weight-bold"
                                >{{
                                    props.site_settings.folder_name
                                }}</v-card-title
                            >
                        </vcard>
                    </v-col>
                </v-row>
                <v-row v-if="!currentdir">
                    <v-col
                        cols="2"
                        v-for="image in props.site_settings.images"
                        :key="image.id"
                    >
                        <vcard>
                            <VImg
                                :src="image.original_url"
                                width="150"
                                height="150"
                            />
                            <v-card-title
                                class="text-sm text-wrap text-truncate w-80 font-weight-bold"
                                >{{ image.file_name }}</v-card-title
                            >
                        </vcard>
                    </v-col>
                </v-row>
                <VBtn color="info" class="mb-2 mt-5" @click="handleChange" v-if="!currentdir">
                    <VIcon start icon="mdi-arrow-left" />
                    Back
                </VBtn>
            </div>
        </v-card>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import folder from "@images/folder.png";
let currentdir = ref(true);
let props = defineProps(["site_settings",'organizations']);
function handleChange() {
    currentdir.value = !currentdir.value;
}
</script>
