<script setup>
const dataProps = defineProps(["data"]);
let truncatedText = (text) => {
    if (text) {
        if (text?.length <= 20) {
            return text;
        } else {
            return text?.substring(0, 20) + "...";
        }
    }
};

// console.log(dataProps.data.url);

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
const showPreview = (data) => {
    // Replace 'path/to/your_pdf_file.pdf' with the actual path to your PDF file
    var pdfUrl = data.data.url;
    // Create HTML content for the new window
    var content = `<html><head><title>PDF Viewer</title></head><body style="margin:0;"><iframe src="${pdfUrl}" style="width:100%; height:100%; border: none;"></iframe></body></html>`;

    // Open a new window with the HTML content
    var newPopup = window.open("", "_blank", "width=800,height=600");
    newPopup.document.write(content);
    newPopup.document.close();
};
</script>
<template>
    <v-hover v-slot="{ isHovering, props }">
        <v-card
            class="mr-5 grab-pointer"
            style="z-index: 9 !important"
            v-bind="props"
        >
            <div class="resource-main">
                <img src="/images/pdf.png" alt="" />
                <div
                    v-if="isHovering"
                    class="physicalresourcepdfbar pa-1 px-2 d-flex align-center"
                    v-bind="props"
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
                                <div
                                    class="d-flex align-center gap-4"
                                    style="flex-wrap: wrap"
                                >
                                    <a
                                        style="z-index: 10 !important"
                                        :href="dataProps.data.url"
                                        :download="dataProps.data?.name"
                                    >
                                        <VBtn
                                            size="small"
                                            variant="outlined"
                                            color="secondary"
                                            class="w-25"
                                        >
                                            <v-tooltip
                                                activator="parent"
                                                location="top"
                                                >Download</v-tooltip
                                            >
                                            <v-icon
                                                icon="mdi-download"
                                                color="#fff"
                                            ></v-icon>
                                        </VBtn>
                                    </a>
                                    <VBtn
                                        size="small"
                                        variant="outlined"
                                        color="secondary"
                                        class="w-25"
                                        @click="showPreview(dataProps)"
                                    >
                                        <v-tooltip
                                            activator="parent"
                                            location="top"
                                            >Preview</v-tooltip
                                        >
                                        <v-icon
                                            icon="mdi-eye"
                                            color="#fff"
                                        ></v-icon>
                                    </VBtn>
                                </div>
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
    width: 25px;
}
.download-btn {
    width: 30px !important;
}
</style>
