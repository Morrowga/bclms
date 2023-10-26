<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, ref } from "vue";
import SelectStudent from "./components/SelectStudent.vue";
import SelectTeacher from "./components/SelectTeacher.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { requiredValidator } from "@validators";
import LargeDropFile from "@mainRoot/components/LargeDropFile/LargeDropFile.vue";
import { FlashMessage } from "@actions/useFlashMessage";
let props = defineProps(["flash", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const isFormValid = ref(false);
let refForm = ref();

const form = useForm({
    name: "",
    description: "",
    image: "",
    students: [],
    teachers: [],
});

const handleSubmit = () => {
    refForm.value?.validate().then(({ valid }) => {
        if (valid) {
            form.post(route("classrooms.store"), {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
                onError: (error) => {},
            });
        }
    });
};
</script>

<template>
    <AdminLayout>
        <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="handleSubmit"
            @keydown.enter="$event.preventDefault()"
        >
            <VContainer>
                <span class="span-text ruddy-bold">Create Classroom</span>
                <VRow class="mt-3">
                    <VCol cols="12" md="6">
                        <LargeDropFile v-model="form.image" />
                    </VCol>
                    <VCol cols="12" sm="6" md="6">
                        <span class="semi-label pppangram-bold"
                            >Classroom Details</span
                        >
                        <div>
                            <span class="input-label"
                                >Name <span class="star">*</span></span
                            >
                            <VTextField
                                v-model="form.name"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.name"
                            />
                        </div>
                        <div class="mt-2">
                            <span class="input-label">Description</span>
                            <VTextarea rows="2" v-model="form.description" />
                        </div>
                    </VCol>
                </VRow>
                <div class="mt-15">
                    <v-expansion-panels>
                        <SelectTeacher :form="form" />
                    </v-expansion-panels>
                </div>
                <div class="mt-3">
                    <v-expansion-panels>
                        <SelectStudent :form="form" />
                    </v-expansion-panels>
                </div>
                <div class="mt-10 d-flex justify-center">
                    <Link :href="route('classrooms.index')">
                        <v-btn
                            varient="flat"
                            color="#F6F6F6"
                            class="cancel pppangram-bold"
                            width="200"
                            rounded
                        >
                            Cancel
                        </v-btn>
                    </Link>
                    <v-btn
                        type="submit"
                        varient="flat"
                        color="#3749E9"
                        class="textcolor ml-2 pppangram-bold"
                        width="200"
                        rounded
                    >
                        Create
                    </v-btn>
                </div>
            </VContainer>
        </VForm>
    </AdminLayout>
</template>

<style lang="scss" scoped>
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.card-text {
    padding: 145px 80px;
    justify-content: center;
    align-items: center;
}

.fade-text {
    color: var(--secondary-2, rgba(86, 86, 96, 0.4));
    font-size: 14px !important;
    font-style: normal !important;
    font-weight: 400 !important;
    line-height: 22px !important; /* 157.143% */
    text-transform: capitalize !important;
}

.cancel {
    border-radius: 23px !important;
    background: rgba(55, 73, 233, 0.1) !important;
    color: #3749e9 !important;
}

.input-label {
    color: var(--gray, #bfc0c1);
    /* Body Style Small */
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 26px !important; /* 162.5% */
}

.star {
    color: var(--candy-red, #ff6262);
}

.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 32px !important; /* 160% */
}

.drag-text {
    color: var(--secondary, #565660);
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 24px !important; /* 150% */
}

.upload-card {
    width: 100%;
    background: #e3e3e3;
    box-shadow: none !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.cloud {
    text-align: center;
}

.span-text {
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

.textcolor {
    color: #fff;
}

.classname {
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

.blur-p {
    color: var(--Secondary2, rgba(86, 86, 96, 0.4));
    text-align: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px; /* 157.143% */
    text-transform: capitalize;
}

.profile-drag {
    align-items: center;
    text-align: center;
    width: 100%;
    background: #f7f7f7;
    height: 440px;
    border: 1px solid black;
    border-radius: 10px;
    overflow: hidden;
}
.profileimg {
    object-fit: contain !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
    margin-bottom: 0;
}
.img-frame {
    position: relative;
}

.remove-img {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
