<script setup>
import { defineProps, ref, onUpdated } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";

import Edit from "./Edit.vue";
import { router } from "@inertiajs/core";
import { isConfirmedDialog } from "@mainRoot/components/Actions/useConfirm";
import { checkPermission } from "@actions/useCheckPermission";
import { FlashMessage } from "@actions/useFlashMessage";
const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    disability_types: {
        type: Object,
        required: true,
    },
    devices: {
        type: Object,
        required: true,
    },
    themes: {
        type: Object,
        required: true,
    },
    learningneeds: {
        type: Object,
        required: true,
    },
});
let dialog = ref(false);
let flash = computed(() => usePage().props.flash);
const toggleDialog = () => {
    dialog.value = !dialog.value;
};
const isEdit = ref(false);
const form = useForm({
    id: "",
    name: "",
    tag_name: "",
    is_free: 0,
    description: "",
    tags: [],
    sub_learning_needs: [],
    themes: [],
    disability_type: [],
    devices: [],
    thumbnail_img: "",
    _method: "PUT",
});

const handleUpdate = () => {
    form.post(route("books.update", form.id), {
        onSuccess: () => {
            FlashMessage({ flash });
            dialog.value = false;
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
const setImage = () => {
    return form.thumbnail_img == "" || !form.thumbnail_img
        ? "/images/defaults/organisation_logo.png"
        : form.thumbnail_img;
};
const deleteBook = (id) => {
    dialog.value = false;
    isConfirmedDialog({
        title: "You won't be able to revert it!",
        denyButtonText: "Yes, delete it!",
        onConfirm: () => {
            router.delete(route("books.destroy", id), {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
            });
        },
    });
};
onUpdated(() => {
    (form.id = props.data.id),
        (form.name = props.data.name),
        (form.description = props.data.description),
        (form.thumbnail_img = props.data.thumbnail_img),
        (form.disability_type = props.data.disability_type),
        (form.sub_learning_needs = props.data.learningneeds),
        (form.themes = props.data.themes),
        (form.disability_type = props.data.disability_types),
        (form.devices = props.data.devices);
});
</script>
<template>
    <div class="h-100">
        <v-hover v-slot="{ isHovering, props }" open-delay="200">
            <v-card
                class="item-frame h-100"
                v-bind="props"
                :class="{ 'on-hover': isHovering }"
            >
                <v-img
                    @click="toggleDialog"
                    :src="setImage()"
                    alt="Your Image"
                    max-height="200"
                    class="p-relative img-hover"
                    cover
                >
                    <!-- show free storybook is free -->
                    <div class="free-bar" v-if="data.is_free">
                        <div class="pppangram-bold">FREE</div>
                    </div>
                </v-img>
            </v-card>
        </v-hover>
        <!-- noted this dialog module is used for both show and edit on one page -->
        <v-dialog v-model="dialog" width="auto" max-width="800" min-width="800">
            <v-card>
                <v-card-title class="pa-0">
                    <div class="faded-image">
                        <v-img
                            :src="setImage()"
                            :aspect-ratio="16 / 9"
                            cover
                            alt="Faded Image"
                        >
                            <div class="pa-2 ml-10 mt-4 coins-bg">
                                <div class="d-flex space-between align-center">
                                    <img
                                        src="/images/icons/goldcoins.png"
                                        class="coin-image"
                                    />
                                    <span class="coin-text pl-1">{{
                                        data.num_gold_coins
                                    }}</span>
                                </div>
                                <div class="d-flex space-between align-center">
                                    <img
                                        src="/images/icons/silvercoins.png"
                                        class="coin-image"
                                    />
                                    <span class="coin-text pl-2">
                                        {{ data.num_silver_coins }}
                                    </span>
                                </div>
                            </div>
                        </v-img>
                        <div class="faded-overlay"></div>
                        <div class="book-title d-flex align-center">
                            <p>{{ data.name }}</p>
                            <div class="px-4 d-flex">
                                <v-chip size="small" color="warning">
                                    {{ data.type }}
                                </v-chip>
                                <v-chip
                                    size="small"
                                    color="success"
                                    v-if="data.is_free"
                                >
                                    free access
                                </v-chip>
                                <v-chip
                                    size="small"
                                    v-for="(tag, index) in data.tags"
                                    :key="index"
                                >
                                    {{ tag.name }}
                                </v-chip>
                            </div>
                        </div>
                        <div class="edit-icon">
                            <!-- <v-btn
                                icon="mdi-gift"
                                size="x-small"
                                color="secondary"
                            ></v-btn> -->
                            <v-btn
                                v-if="checkPermission('delete_book')"
                                icon="mdi-bin"
                                size="x-small"
                                class="text-white"
                                color="#000"
                                @click="deleteBook(data.id)"
                            ></v-btn>
                            <Edit
                                v-if="checkPermission('edit_book')"
                                :datas="data"
                                :disability_types="props.disability_types"
                                :devices="props.devices"
                                :themes="props.themes"
                                :learningneeds="props.learningneeds"
                            />
                            <!-- <v-btn icon="mdi-edit" size="x-small" color="secondary" @click="isEdit = true"/> -->
                            <Link
                                :href="route('books.edit', data.id)"
                                v-if="
                                    checkPermission('edit_book') &&
                                    data.type == 'H5P'
                                "
                            >
                                <!-- <v-btn
                                    icon="mdi-upload"
                                    size="x-small"
                                    color="secondary"
                                ></v-btn> -->
                                <v-avatar size="33">
                                    <v-img
                                        src="/images/icons/h5pIcon.png"
                                    ></v-img>
                                </v-avatar>
                            </Link>
                            <Link
                                :href="
                                    route('books.edit_html_version', data.id)
                                "
                                v-if="
                                    checkPermission('edit_book') &&
                                    data.type == 'HTML5'
                                "
                            >
                                <v-btn
                                    icon="mdi-content-copy"
                                    size="x-small"
                                    class="text-white"
                                    color="#000"
                                ></v-btn>
                            </Link>
                        </div>
                        <div class="close-btn">
                            <v-btn
                                @click="dialog = false"
                                color="default"
                                variant="elevated"
                                icon="$close"
                                :rounded="false"
                            >
                            </v-btn>
                        </div>
                    </div>
                </v-card-title>
                <v-card-text class="px-10 py-0 pb-5">
                    <div class="paragraph">
                        {{ data.description }}
                    </div>

                    <div class="learning pt-2">
                        <span class="font-weight-black text-black"
                            >Learning Needs</span
                        >

                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="(
                                    learningneed, index
                                ) in data.learningneeds"
                                :key="index"
                            >
                                {{ learningneed.name }}
                            </v-chip>
                        </v-chip-group>
                    </div>

                    <div class="themes pt-2">
                        <span class="font-weight-black text-black">Themes</span>
                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="theme in data.themes"
                                :key="theme.id"
                            >
                                {{ theme.name }}
                            </v-chip>
                        </v-chip-group>
                    </div>

                    <div class="disability pt-2">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        >
                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="disability in data.disability_types"
                                :key="disability.id"
                            >
                                {{ disability.name }}
                            </v-chip>
                        </v-chip-group>
                    </div>

                    <div class="supported pt-2">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        >
                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="device in data.devices"
                                :key="device.id"
                            >
                                {{ device.name }}
                            </v-chip>
                        </v-chip-group>
                    </div>
                </v-card-text>
                <v-card-actions class="d-flex justify-end">
                    <span class="text-caption"
                        >Last updated on 14 Aug 2023 1:04Am</span
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- noted this dialog module is used for both show and edit on one page -->
    </div>
</template>

<style scoped>
/* .img-header {

} */
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
.book-title p {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
    padding-bottom: 0;
    margin-bottom: 0;
}

.close-btn {
    position: absolute;
    top: 0;

    right: 0;
}
.close-btn .v-btn--icon {
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
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.v-card:not(.on-hover) {
    opacity: 1;
}

.edit-icon {
    position: absolute;
    bottom: -5px;
    right: 40px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
/* coin images class */

.coins-bg {
    display: flex;
    flex-direction: row;
    gap: 10px;
    width: 300px !important;
    height: 80px;
    border-radius: 30px !important;
    background: rgba(0, 0, 0, 0.75) !important;
    background-color: transparent;
}
.coin-image {
    width: 50px !important;
    height: 50px !important;
}
.coin-text {
    color: #fff !important;
    text-align: center !important;
    font-family: "ruddy-bold";
    font-size: 45px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 74px !important; /* 123.333% */
    text-transform: capitalize !important;
}

.p-relative {
    position: relative;
}
.free-bar {
    position: absolute;
    width: 160px;
    height: 37.191px;
    top: 15px;
    right: -40px;
    transform: rotate(40.242deg);
    flex-shrink: 0;
    background: #d7f2f0;
    text-align: center;
    padding-top: 5px;
    font-size: 24px;
    font-style: normal;
    font-weight: 700;
    color: #000 !important;
    line-height: 32px;
}
.img-hover:hover {
    fill: #282828;
    fill-opacity: 0.5;
}
</style>
