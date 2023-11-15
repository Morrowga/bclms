<script setup>
import { defineProps, ref } from "vue";
import Edit from "./Edit.vue";
import axios from "@axios";
import { format } from "date-fns";
import { isConfirmedDialog } from "@actions/useConfirm";
import { router } from "@inertiajs/core";
import { checkPermission } from "@actions/useCheckPermission";
import { FlashMessage } from "@actions/useFlashMessage";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    disabilitytypes: {
        type: Object,
        required: true,
    },
    devices: {
        type: Object,
        required: true,
    },
});
let flash = computed(() => usePage().props.flash);
let dialog = ref(false);

const toggleDialog = () => {
    dialog.value = !dialog.value;
};
// console.log(props.data.devices);

const formatDate = (dateString) => {
    // Parse the date string into a Date object
    const date = new Date(dateString);
    // Format the date using date-fns
    return format(date, "d MMM yyyy h:mm  a"); // Customize the format string as needed
};
const setImage = () => {
    return props.data.thumbnail == "" || !props.data.thumbnail
        ? "/images/defaults/organisation_logo.png"
        : props.data.thumbnail;
};

const deleteGame = () => {
    dialog.value = false;
    isConfirmedDialog({
        title: "You won't be able to revert this!",
        denyButtonText: "Yes,delete it!",
        onConfirm: () => {
            router.delete("games/" + props.data.id, {
                onSuccess: () => {
                    FlashMessage({ flash });
                },
            });
        },
    });
};

const download = async () => {
    try {
        const response = await axios.post(
            "/games/gamedownload/" + props.data.id,
            {
                responseType: "blob", // Specify the response type as a blob
            }
        );
        // Create a blob URL for the response data
        const blob = new Blob([response.data]);
        const url = window.URL.createObjectURL(blob);

        // Create an anchor element to trigger the download
        const a = document.createElement("a");
        a.href = url;
        a.download = props.data.name + ".zip"; // Set the desired file name
        a.style.display = "none";
        document.body.appendChild(a);
        a.click();

        // Cleanup and remove the anchor element
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    } catch (error) {
        console.error("Error downloading file:", error);
    }
};
</script>
<template>
    <div>
        <v-hover v-slot="{ isHovering, props }" open-delay="200">
            <v-card
                class="item-frame"
                v-bind="props"
                :class="{ 'on-hover': isHovering }"
            >
                <v-img
                    @click="toggleDialog"
                    :src="setImage()"
                    alt="Your Image"
                    max-height="200"
                    cover
                ></v-img>
            </v-card>
        </v-hover>
        <v-dialog v-model="dialog" width="auto" max-width="800" min-width="800">
            <v-card>
                <v-card-title class="pa-0">
                    <div class="faded-image">
                        <v-img
                            :src="setImage()"
                            class="img-header"
                            alt="Faded Image"
                            cover
                            aspect-ratio="16/9"
                        />
                        <div class="faded-overlay"></div>
                        <div class="book-title">
                            <span>{{ data.name }}</span>
                            <VIcon
                                icon="mdi-tray-arrow-down"
                                class="ml-3 mb-3 cursor-pointer"
                                @click="download()"
                                color="#000"
                                size="25"
                            ></VIcon>
                        </div>
                        <div class="edit-icon">
                            <Edit
                                v-if="checkPermission('edit_game')"
                                :datas="props.data"
                                :disabilitytypes="props.disabilitytypes"
                                :devices="props.devices"
                            />
                            <v-btn
                                v-if="checkPermission('delete_game')"
                                @click="deleteGame"
                                class="mt-1"
                                icon="mdi-trash"
                                size="x-small"
                                color="secondary"
                            ></v-btn>
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
                    <br />
                    <div class="disability">
                        <span class="font-weight-black text-black"
                            >Disability Types</span
                        ><br />
                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="(
                                    disability, index
                                ) in data.disability_types"
                                :key="index"
                            >
                                {{ disability.name }}
                            </v-chip>
                        </v-chip-group>
                    </div>
                    <br />
                    <div class="supported">
                        <span class="font-weight-black text-black"
                            >Supported Accessibility Devices</span
                        ><br />
                        <v-chip-group>
                            <v-chip
                                size="small"
                                v-for="(device, index) in data.devices"
                                :key="index"
                                >{{ device.name }}</v-chip
                            >
                        </v-chip-group>
                    </div>
                </v-card-text>
                <v-card-actions class="d-flex justify-end">
                    <span class="text-caption"
                        >Last updated on
                        {{ formatDate(props.data.updated_at) }}</span
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
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
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.v-card:not(.on-hover) {
    opacity: 1;
}

.edit-icon {
    position: absolute;
    bottom: 7px;
    right: 40px;
}
</style>
