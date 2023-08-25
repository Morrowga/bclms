<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
import SelectStudent from "./components/SelectStudent.vue";
import SelectTeacher from "./components/SelectTeacher.vue";
let props = defineProps([
    "flash",
    "auth",
]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const selectedImage = ref(null);

const handleFileUpload = (event) => {
  const selectedFile = event.target.files[0];
  if (selectedFile) {
    selectedImage.value = URL.createObjectURL(selectedFile);
  }
};

const fileInput = ref(null);

const openFileInput = () => {
  fileInput.value.click();
};

</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
                <span class="span-text ruddy-bold">Create Classroom</span>
                <VRow class="mt-3">
                    <VCol cols="12" sm="6" md="6">
                        <VCard class="upload-card" @click="openFileInput">
                            <v-img v-if="selectedImage" :src="selectedImage" cover></v-img>
                            <div v-else class="card-text">
                                <div class="text-center">
                                <div class="d-flex justify-center">
                                    <img src="/images/Icons.png" width="100">
                                </div>
                                <div class="mt-2">
                                    <span class="drag-text">
                                        Drag your item to upload
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="fade-text">
                                        PNG, GIF, WebP, MP4 or MP3. Maximum file size 100 Mb.
                                    </span>
                                </div>
                            </div>
                            </div>

                        </VCard>
                        <input type="file" ref="fileInput" style="display: none" @change="handleFileUpload">
                    </VCol>
                    <VCol cols="12" sm="6" md="4">
                        <span class="semi-label pppangram-bold">Classroom Details</span>
                        <div>
                            <span class="input-label">Name <span class="star">*</span></span>
                            <VTextField/>
                        </div>
                        <div class="mt-2">
                            <span class="input-label">Description</span>
                            <VTextarea rows="2">

                            </VTextarea>
                        </div>
                    </VCol>
                </VRow>
                <div class="mt-15">
                    <v-expansion-panels>
                        <SelectTeacher />
                    </v-expansion-panels>
                </div>
                <div class="mt-3">
                    <v-expansion-panels>
                        <SelectStudent />
                    </v-expansion-panels>
                </div>
                <div class="mt-10 d-flex justify-center">
                    <v-btn varient="flat" color="#F6F6F6" class="cancel pppangram-bold" width="200" rounded>
                         Cancel
                    </v-btn>
                    <v-btn varient="flat" color="#3749E9" class="textcolor ml-2 pppangram-bold" width="200" rounded>
                         Create
                    </v-btn>
                </div>
            </VContainer>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.card-text{
    padding: 145px 80px;
    justify-content: center;
    align-items: center;
}

.fade-text{
    color: var(--secondary-2, rgba(86, 86, 96, 0.40));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important; /* 157.143% */
    text-transform: capitalize !important;
}

.cancel{
    border-radius: 23px !important;
    background: rgba(55, 73, 233, 0.10) !important;
    color: #3749E9 !important;
}

.input-label{
    color: var(--gray, #BFC0C1);
    /* Body Style Small */
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}

.star{
    color: var(--candy-red, #FF6262);
}

.semi-label{
    color: var(--graphite, #282828) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 32px !important; /* 160% */
}

.drag-text{
    color: var(--secondary, #565660);
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 24px !important; /* 150% */
}

.upload-card{
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.cloud{
    text-align: center;
}

.span-text{
    color: #000 !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.textcolor{
    color: #fff;
}

.classname{
    color: #000;
    font-size: 36px;
    font-style: normal;
    font-weight: bold;
    text-transform: capitalize;
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
