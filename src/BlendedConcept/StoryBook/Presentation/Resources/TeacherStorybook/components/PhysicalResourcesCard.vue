<script setup>
const dataProps = defineProps(["data"]);
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 30) {
            return text;
        } else {
            return text?.substring(0, 30) + "...";
        }
    }
};

const imageType = (type) => {
    switch (type) {
        case "application/pdf":
            return "/images/pdficon.png";
            break;
        default:
            return "/images/docxicon.png";
            break;
    }
};
</script>
<template>
    <v-hover v-slot="{ isHovering, props }">
        <v-card width="300" class="mr-5" v-bind="props">
            <div class="resource-main">
                <img src="/images/pdf.png" alt="" />
                <div
                    v-if="isHovering"
                    class="physicalresourcepdfbar pa-1 px-2 d-flex align-center"
                >
                    <div class="physicalresource-child-content">
                        <div class="d-flex align-center">
                            <img
                                class="align-self-start px-2 icon-size"
                                :src="imageType(dataProps.data.type)"
                            />
                            <div>
                                <span>{{
                                    truncatedText(dataProps.data?.file_name)
                                }}</span>
                                <br />
                                <span>{{ dataProps.data?.size }} KB</span>
                                <br />
                                <br />
                                <a
                                    :href="dataProps.data.url"
                                    :download="dataProps.data?.name"
                                >
                                    <VBtn
                                        size="small"
                                        variant="outlined"
                                        color="secondary"
                                        class="w-50"
                                    >
                                        <v-icon
                                            icon="mdi-download"
                                            color="#fff"
                                        ></v-icon>
                                    </VBtn>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="physicalresourcepdfbar-unhover pa-1 px-2 d-flex align-center"
                >
                    <div
                        class="physicalresource-child-content d-flex align-center"
                    >
                        <img
                            :src="imageType(dataProps.data.type)"
                            class="px-2 icon-size"
                        />
                        <span class="text-white">{{
                            truncatedText(dataProps.data?.name)
                        }}</span>
                    </div>
                </div>
            </div>
        </v-card>
    </v-hover>
</template>
<style>
.resource-main {
    position: relative;
}
.physicalresourcepdfbar > .physicalresource-child-content > div > div > span {
    color: #fff !important;
}

.physicalresource-child-content {
    padding: 10px !important;
}

.physicalresourcepdfbar {
    background: rgb(22, 22, 22) !important;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
}
.physicalresourcepdfbar-unhover {
    background: rgba(22, 22, 22, 0.8) !important;
}
.icon-size {
    width: 50px;
}
.download-btn {
    width: 30px !important;
}
</style>
