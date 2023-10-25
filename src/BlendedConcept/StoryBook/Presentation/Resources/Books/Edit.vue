<script setup>
import { defineProps, ref, defineEmits, onUpdated } from "vue";
import { useForm } from "@inertiajs/vue3";
import Upload from "./components/Upload.vue";
import { SuccessDialog } from "@actions/useSuccess";
import UploadThumbnail from "./components/UploadThumbnail.vue";
import UploadPhysicalResources from "./components/UploadPhysicalResources.vue";
import { integerValidator } from "@validators";
const props = defineProps({
    datas: {
        type: Object,
        required: true,
    },
    disability_types: {
        type: Object,
        requird: true,
    },
    devices: {
        type: Object,
        requird: true,
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
let emit = defineEmits();
let dialog = ref(false);
let thumbnailDialog = ref(false);
let physicalDialog = ref(false);
let types = ref([]);
let devices = ref([]);
let themes = ref([]);
let tags = ref([]);
let learningneeds = ref([]);
let systemDisabilityTypes = ref([]);
let systemDevices = ref([]);
let systemThemes = ref([]);
let systemLearningneeds = ref([]);
let deleteTags = ref([]);
const getThumbFile = ref(null);
const gameTag = ref("");

const toggleDialog = () => {
    dialog.value = !dialog.value;
};
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
    h5p_id: null,
    num_gold_coins: "",
    num_silver_coins: "",
    delete_tags: [],
    _method: "PUT",
});

props.datas.disability_types.forEach((item) => {
    types.value.push({
        id: item.id,
        name: item.name,
    });
});

props.datas.devices.forEach((item) => {
    devices.value.push({
        id: item.id,
        name: item.name,
    });
});
props.datas.themes.forEach((item) => {
    themes.value.push({
        id: item.id,
        name: item.name,
    });
});

props.datas.learningneeds.forEach((item) => {
    learningneeds.value.push({
        id: item.id,
        name: item.name,
    });
});

props.disability_types.forEach((item) => {
    systemDisabilityTypes.value.push({
        id: item.id,
        name: item.name,
    });
});

props.devices.forEach((item) => {
    systemDevices.value.push({
        id: item.id,
        name: item.name,
    });
});
props.themes.forEach((item) => {
    systemThemes.value.push({
        id: item.id,
        name: item.name,
    });
});

props.learningneeds.forEach((item) => {
    systemLearningneeds.value.push({
        id: item.id,
        name: item.name,
    });
});

const handleUpdate = () => {
    let typeIds = [];
    let deviceIds = [];
    let learningneedIds = [];
    let themeIds = [];
    types.value.forEach((item) => {
        typeIds.push(item.id);
    });

    devices.value.forEach((item) => {
        deviceIds.push(item.id);
    });
    themes.value.forEach((item) => {
        themeIds.push(item.id);
    });

    learningneeds.value.forEach((item) => {
        learningneedIds.push(item.id);
    });

    form.disability_type = typeIds;
    form.devices = deviceIds;
    form.sub_learning_needs = learningneedIds;
    form.themes = themeIds;

    form.thumbnail_img = getThumbFile.value;
    form.post(route("books.update", form.id), {
        onSuccess: () => {
            SuccessDialog({ title: props.flash?.successMessage });
            dialog.value = false;
        },
        onError: (error) => {
            console.log(error);
        },
    });
};
const handleThumbnailModalSubmit = (data) => {
    getThumbFile.value = data.thumb;
};
const removeFromArray = (disabilityId) => {
    types.value = types.value.filter((item) => item.id !== disabilityId);
};

const addToArray = (disability) => {
    types.value.push(disability);
};

const isInGameDisabilityTypes = (disabilityId) => {
    return types.value.some((type) => type.id === disabilityId);
};

const removeDeviceFromArray = (deviceId) => {
    devices.value = devices.value.filter((item) => item.id !== deviceId);
};

const addDeviceToArray = (device) => {
    devices.value.push(device);
};

const isInGameDevices = (deviceId) => {
    return devices.value.some((device) => device.id === deviceId);
};

const removeThemesFromArray = (themeId) => {
    themes.value = themes.value.filter((item) => item.id !== themeId);
};

const addThemeToArray = (theme) => {
    themes.value.push(theme);
};

const isInBookTheme = (themeId) => {
    return themes.value.some((theme) => theme.id === themeId);
};

const removeLearningneedsFromArray = (learningneedId) => {
    learningneeds.value = learningneeds.value.filter(
        (item) => item.id !== learningneedId
    );
};

const addLearningneedToArray = (learningneed) => {
    learningneeds.value.push(learningneed);
};

const isInBookLearningneed = (learningneedId) => {
    return learningneeds.value.some(
        (learningneed) => learningneed.id === learningneedId
    );
};

const addToSublearningArray = (tag) => {
    if (gameTag.value) {
        form.tags.push(gameTag.value);
        gameTag.value = "";
    }
};

const removeFromTagArray = (index) => {
    form.tags = form.tags.filter((tag, i) => i != index);
};
const removeFromTagIdArray = (tag_id) => {
    tags.value = tags.value.filter((tag, i) => tag.id != tag_id);
    if (tag_id) {
        deleteTags.value.push(tag_id);
        form.delete_tags = deleteTags.value;
    }
};

onUpdated(() => {
    form.id = props.datas.id;
    form.name = props.datas.name;
    form.description = props.datas.description;
    form.thumbnail_img = props.datas.thumbnail_img;
    form.disability_type = props.datas.disability_type;
    form.sub_learning_needs = props.datas.learningneeds;
    tags.value = props.datas.tags;
    form.themes = props.datas.themes;
    form.disability_type = props.datas.disability_types;
    form.devices = props.datas.devices;
    form.is_free = props.datas.is_free ? true : false;
    form.h5p_id = props.datas.h5p_id;
    form.num_gold_coins = props.datas.num_gold_coins;
    form.num_silver_coins = props.datas.num_silver_coins;
});
</script>
<template>
    <div>
        <v-btn
            @click="toggleDialog"
            icon="mdi-edit"
            size="x-small"
            color="secondary"
        ></v-btn>
        <v-dialog v-model="dialog" width="100%" max-width="800" persistent>
            <v-card>
                <v-card-title class="pa-0">
                    <div class="faded-image">
                        <v-img
                            :src="form.thumbnail_img"
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
                                    <!-- <span class="coin-text pl-1">{{
                                        form.num_gold_coins
                                    }}</span> -->
                                    <v-text-field
                                        variant="solo"
                                        type="number"
                                        class="coin-text text-white pl-1"
                                        v-model="form.num_gold_coins"
                                    />
                                </div>
                                <div class="d-flex space-between align-center">
                                    <img
                                        src="/images/icons/silvercoins.png"
                                        class="coin-image"
                                    />
                                    <!-- <span class="coin-text pl-2">
                                        {{ form.num_silver_coins }}
                                    </span> -->
                                    <v-text-field
                                        dark
                                        variant="solo"
                                        type="number"
                                        class="coin-text text-white pl-1"
                                        v-model="form.num_silver_coins"
                                    />
                                </div>
                            </div>
                        </v-img>
                        <div class="faded-overlay"></div>
                        <div class="book-title">
                            <div class="d-flex justify-end">
                                <VLabel class="tiggie-label pr-5"
                                    >Available for Free Users</VLabel
                                >
                                <VCheckbox v-model="form.is_free" />
                            </div>

                            <VRow>
                                <VCol cols="8">
                                    <v-text-field
                                        class="r-title"
                                        v-model="form.name"
                                    ></v-text-field>
                                </VCol>
                                <VCol cols="4">
                                    <VTextField
                                        class="f-title"
                                        v-model="gameTag"
                                        :error-messages="form?.errors?.tags"
                                        append-inner-icon="mdi-add-circle"
                                        @click:append-inner="
                                            addToSublearningArray
                                        "
                                    >
                                    </VTextField>
                                </VCol>
                            </VRow>
                        </div>
                        <div class="edit-icon">
                            <v-btn
                                icon="mdi-image-area"
                                size="x-small"
                                color="secondary"
                                @click="thumbnailDialog = true"
                            ></v-btn>

                            <v-btn
                                icon="mdi-content-save"
                                size="x-small"
                                color="secondary"
                                @click="handleUpdate"
                            ></v-btn>

                            <v-btn
                                icon="mdi-paperclip"
                                size="x-small"
                                color="secondary"
                                @click="physicalDialog = true"
                            ></v-btn>

                            <!-- <Upload /> -->
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
                <v-card-subtitle class="text-end d-flex justify-end">
                    <div
                        class="d-flex my-4 justify-end"
                        v-if="form.tags.length > 0"
                        :class="tags.length == 0 ? 'pr-16 mr-6' : ''"
                    >
                        <div
                            class="ps-relative"
                            v-for="(tag, index) in form.tags"
                            :key="index"
                        >
                            <v-chip size="small" color="primary">{{
                                tag
                            }}</v-chip>
                            <div
                                class="delete-chip"
                                @click="removeFromTagArray(index)"
                            >
                                <span>-</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex my-4 justify-end pr-16 mr-6"
                        v-if="tags.length > 0"
                    >
                        <div
                            class="ps-relative"
                            v-for="(tag, index) in tags"
                            :key="index"
                        >
                            <v-chip size="small" color="primary">{{
                                tag.name
                            }}</v-chip>
                            <div
                                class="delete-chip"
                                @click="removeFromTagIdArray(tag.id)"
                            >
                                <span>-</span>
                            </div>
                        </div>
                    </div>
                </v-card-subtitle>
                <v-card-text class="px-10 py-0 pb-5">
                    <div class="paragraph">
                        <v-textarea
                            class="max-w-edit-book"
                            variant="outlined"
                            v-model="form.description"
                        ></v-textarea>
                    </div>
                    <div class="learning pt-2">
                        <span class="font-weight-black text-black"
                            >Learning Needs</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div
                                    class="ps-relative"
                                    v-for="(
                                        learningneed, index
                                    ) in systemLearningneeds"
                                    :key="index"
                                >
                                    <v-chip size="small">
                                        {{ learningneed.name }}
                                    </v-chip>
                                    <div
                                        class="delete-chip"
                                        v-if="
                                            isInBookLearningneed(
                                                learningneed.id
                                            )
                                        "
                                    >
                                        <span
                                            @click="
                                                removeLearningneedsFromArray(
                                                    learningneed.id
                                                )
                                            "
                                            >-</span
                                        >
                                    </div>
                                    <div class="add-chip" v-else>
                                        <span
                                            @click="
                                                addLearningneedToArray(
                                                    learningneed
                                                )
                                            "
                                            >+</span
                                        >
                                    </div>
                                </div>
                            </v-chip-group>
                        </div>
                    </div>
                    <div class="themes pt-2">
                        <span class="font-weight-black text-black">Themes</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div
                                    class="ps-relative"
                                    v-for="(theme, index) in systemThemes"
                                    :key="index"
                                >
                                    <v-chip size="small">
                                        {{ theme.name }}
                                    </v-chip>
                                    <div
                                        class="delete-chip"
                                        v-if="isInBookTheme(theme.id)"
                                    >
                                        <span
                                            @click="
                                                removeThemesFromArray(theme.id)
                                            "
                                            >-</span
                                        >
                                    </div>
                                    <div class="add-chip" v-else>
                                        <span @click="addThemeToArray(theme)"
                                            >+</span
                                        >
                                    </div>
                                </div>
                            </v-chip-group>
                        </div>
                    </div>

                    <div class="disability pt-2">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div
                                    class="ps-relative"
                                    v-for="(
                                        disabilityType, index
                                    ) in systemDisabilityTypes"
                                    :key="index"
                                >
                                    <v-chip size="small">
                                        {{ disabilityType.name }}
                                    </v-chip>
                                    <div
                                        class="delete-chip"
                                        v-if="
                                            isInGameDisabilityTypes(
                                                disabilityType.id
                                            )
                                        "
                                    >
                                        <span
                                            @click="
                                                removeFromArray(
                                                    disabilityType.id
                                                )
                                            "
                                            >-</span
                                        >
                                    </div>
                                    <div class="add-chip" v-else>
                                        <span
                                            @click="addToArray(disabilityType)"
                                            >+</span
                                        >
                                    </div>
                                </div>
                            </v-chip-group>
                        </div>
                    </div>

                    <div class="supported pt-2">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        ><br />
                        <div class="d-flex">
                            <v-chip-group>
                                <div
                                    class="ps-relative"
                                    v-for="(device, index) in systemDevices"
                                    :key="index"
                                >
                                    <v-chip size="small">
                                        {{ device.name }}
                                    </v-chip>
                                    <div
                                        class="delete-chip"
                                        v-if="isInGameDevices(device.id)"
                                    >
                                        <span
                                            style="font-size: 10px !important"
                                            @click="
                                                removeDeviceFromArray(device.id)
                                            "
                                            >-</span
                                        >
                                    </div>
                                    <div class="add-chip" v-else>
                                        <span
                                            style="font-size: 10px !important"
                                            @click="addDeviceToArray(device)"
                                            >+</span
                                        >
                                    </div>
                                </div>
                            </v-chip-group>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions class="d-flex justify-end">
                    <span class="text-caption"
                        >Last updated on 14 Aug 2023 1:04Am</span
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <UploadThumbnail
            v-model:isThumbnailDialogVisible="thumbnailDialog"
            @submit="handleThumbnailModalSubmit"
        />
        <UploadPhysicalResources
            v-model:isPhysicalDialog="physicalDialog"
            :physical_resources="props.datas.physical_resources"
            :book_id="props.datas.id"
        />
    </div>
</template>

<style scoped>
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
    max-width: 650px;
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
.edit-icon {
    position: absolute;
    bottom: -5px;
    right: 40px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.v-input__control {
    height: auto !important;
}

:deep(.v-text-field input) {
    color: var(--graphite, #282828) !important;
    font-size: 35px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
    padding-top: 0;
    padding-bottom: 0;
}
:deep(#input-82) {
    color: var(--graphite, #282828) !important;
    font-size: 15px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 108.333% */
    text-transform: capitalize !important;
    padding-top: 0;
    padding-bottom: 0;
}

.delete-chip {
    background: rgb(109, 120, 141);
    border-radius: 50%;
    width: 15px;
    height: 15px;
    cursor: pointer;
    color: #fff;
    text-align: center;
    position: absolute;
    right: 0;
    top: 0;
}
.delete-chip span {
    position: absolute;
    top: -6px;
    left: 0;
    bottom: 0;
    right: 0;
    color: #fff;
}

.add-chip {
    background: rgb(109, 120, 141);
    border-radius: 50%;
    width: 15px;
    height: 15px;
    cursor: pointer;
    color: #fff;
    text-align: center;
    position: absolute;
    right: 0;
    top: 0;
}
.add-chip span {
    position: absolute;
    top: -6px;
    left: 0;
    bottom: 0;
    right: 0;
    color: #fff;
}
.max-w-edit-book {
    max-width: 650px !important;
}

/* coin images class */

.coins-bg {
    display: flex;
    flex-direction: row;
    gap: 10px;
    width: 360px !important;
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
</style>
