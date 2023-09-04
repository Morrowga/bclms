<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps } from "vue";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { SuccessDialog } from "@mainRoot/components/Actions/useSuccess";
let props = defineProps(["flash", "auth"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const deleteClassroom = () => {
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            SuccessDialog({
                title: "You have successfully deleted classroom!",
                color: "#17CAB6",
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <section>
            <VContainer>
                <VRow>
                    <VCol cols="12" sm="6" md="6">
                        <div class="classroom">
                            <v-img src="/images/bg.png" cover></v-img>
                            <div class="overlay-container">
                                <v-img
                                    src="/images/classroom9.jpeg"
                                    class="classroom-img"
                                ></v-img>
                            </div>
                        </div>
                    </VCol>
                    <VCol cols="12" sm="6" md="6" class="marginadjust">
                        <div class="text-left">
                            <span class="font-weight-black classname">
                                1 A
                            </span>
                            <v-chip class="ml-5 spacing">
                                <span class="text-center pppangram-bold">
                                    5 / 5</span
                                >
                            </v-chip>
                        </div>
                        <br />
                        <br />
                        <br />

                        <span class="description pppangram-bold"
                            >Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Cum ipsam animi aspernatur soluta. Illo odio
                            ut molestias ea dolorem alias consequuntur
                            reiciendis eius non minus tempora, adipisci rerum
                            necessitatibus atque?</span
                        >
                        <br />
                        <br />
                        <br />
                        <div>
                            <v-btn
                                prepend-icon="mdi-pencil"
                                varient="flat"
                                @click="() => router.get(route('editCopy'))"
                                color="#16cab6"
                                class="textcolor pppangram-bold"
                                rounded
                            >
                                Edit
                            </v-btn>
                            <v-btn
                                @click="deleteClassroom()"
                                prepend-icon="mdi-trash-can-outline"
                                color="#ff6262"
                                class="ml-2 textcolor pppangram-bold"
                                varient="flat"
                                rounded
                            >
                                Delete
                            </v-btn>
                        </div>
                    </VCol>
                </VRow>
                <div class="mt-10">
                    <span class="span-text ruddy-bold">Teachers</span>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom8.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Isbella Taylor</span
                                    >
                                </div>
                            </div>
                        </VCol>
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom7.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Liams William</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-15">
                    <span class="span-text ruddy-bold">Groups</span>
                    <div class="mt-5">
                        <span class="semi-label ruddy-bold">Group 1</span>
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom2.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Wren Clark</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom3.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Madge Dennis</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-15">
                    <div class="mt-5">
                        <span class="semi-label ruddy-bold">Group 2</span>
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom4.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Wren Clark</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
                <div class="mt-15">
                    <div class="mt-5">
                        <span class="semi-label ruddy-bold"
                            >Student Without A Group</span
                        >
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom6.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Ethan Jonathan</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom1.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Olivia Smith</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                        <VCol
                            cols="12"
                            sm="6"
                            md="4"
                            lg="2"
                            class="text-center d-flex justify-center"
                        >
                            <div>
                                <v-img
                                    src="/images/classroom5.jpeg"
                                    class="profile-img"
                                    cover
                                ></v-img>
                                <div class="mt-2">
                                    <span class="label-text pppangram-bold"
                                        >Emma Brown</span
                                    >
                                </div>
                                <div class="mt-1 d-flex justify-center">
                                    <div>
                                        <img
                                            width="20"
                                            src="/images/phone.svg"
                                        />
                                    </div>
                                    <span
                                        class="label-text-two ml-1 pppangram-bold"
                                    >
                                        9123 4567</span
                                    >
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </div>
            </VContainer>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
.app-user-search-filter {
    inline-size: 24.0625rem;
}

.marginadjust {
    margin-top: 11%;
}

.classroom {
    position: relative;
}

.classroom-img {
    height: 300px !important;
    flex-shrink: 0 !important;
}

.overlay-container {
    //   z-index: 1;
    position: absolute;
    top: 8%;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.label-text {
    color: var(--graphite, #282828) !important;
    /* Body Style Large */
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: 38px !important; /* 158.333% */
}

.label-text-two {
    color: #ff6262 !important;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.semi-label {
    color: var(--graphite, #282828) !important;
    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 42px !important; /* 140% */
    text-transform: capitalize !important;
}

.text-capitalize {
    text-transform: capitalize;
}

.span-text {
    color: #000 !important;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
}

.description {
    font-weight: bold !important;
    color: #000;
}

.profile-img {
    width: 180px;
    height: 180px;
    border-radius: 180px;
}

.spacing {
    color: #000;
    letter-spacing: 8px;
    height: 35px;
    border-radius: 100px;
    border: 1px solid #000 !important;
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(2px) !important;
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
</style>
