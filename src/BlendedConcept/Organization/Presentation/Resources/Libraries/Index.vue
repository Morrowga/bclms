<template>
    <AdminLayout>
        <h1>Library Media Interface</h1>
        <v-card>
            <div class="d-flex justify-space-between bg-surface-variant mt-3 px-3 py-5">
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
                <v-row>
                    <v-col cols="3">
                        <v-card>
                            <v-list v-model:opened="open">
                                <v-list-item
                                    @click="handleChange(true)"
                                    prepend-icon="mdi-folder"
                                    title="Home"
                                ></v-list-item>
                                 <v-list-item
                                    prepend-icon="mdi-folder"
                                    title="Organization"
                                 >
                                </v-list-item>
                                 <v-list-item
                                    prepend-icon="mdi-folder"
                                    title="Organization"
                                 >
                                </v-list-item>
                            </v-list>
                        </v-card>
                    </v-col>
                    <v-col cols="9">
                        <v-row v-if="currentdir == true">
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
                            <v-col cols="2">
                                <vcard>
                                    <VImg
                                        :src="folder"
                                        width="150"
                                        height="150"
                                    />
                                    <v-card-title
                                        class="text-sm text-wrap font-weight-bold w-80"
                                    >
                                        ORGANIZATION
                                    </v-card-title>
                                </vcard>
                            </v-col>
                            <v-col cols="2">
                                <vcard @click="handleChange('users')">
                                    <VImg
                                        :src="folder"
                                        width="150"
                                        height="150"
                                    />
                                    <v-card-title
                                        class="text-sm text-wrap font-weight-bold w-80"
                                    >
                                        USERS
                                    </v-card-title>
                                </vcard>
                            </v-col>
                            <v-col cols="2">
                                <vcard @click="handleChange('site_settings')">
                                    <VImg
                                        :src="folder"
                                        width="150"
                                        height="150"
                                    />
                                    <v-card-title
                                        class="text-sm text-uppercase text-wrap w-80 font-weight-bold"
                                        >{{
                                            props.libary_settings.folder_name
                                        }}</v-card-title
                                    >
                                </vcard>
                            </v-col>
                        </v-row>
                        <v-row v-if="currentdir == 'site_settings'">
                            <v-col
                                cols="2"
                                v-for="image in props.libary_settings
                                    .site_settings.media"
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
                        <v-row v-if="currentdir == 'users'">
                            <v-col
                                cols="2"
                                v-for="user in props.libary_settings.users.data"
                                :key="user.id"
                            >
                                <vcard>
                                    <VImg
                                        :src="user?.media[0]?.original_url"
                                        width="150"
                                        height="150"
                                    />
                                    <v-card-title
                                        class="text-sm text-wrap text-truncate w-80 font-weight-bold"
                                    >
                                        {{ user?.media[0]?.file_name }}
                                    </v-card-title>
                                </vcard>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </div>
        </v-card>
    </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import folder from "@images/folder.png";
let currentdir = ref(true);
let props = defineProps(["libary_settings"]);
let open = ref("Users");
let admins = ref([
    ["Management", "mdi-account-multiple-outline"],
    ["Settings", "mdi-cog-outline"],
]);

let cruds = ref([
    ["Create", "mdi-plus-outline"],
    ["Read", "mdi-file-outline"],
    ["Update", "mdi-update"],
    ["Delete", "mdi-delete"],
]);
function handleChange(item) {
    currentdir.value = item;
}
</script>
