<script setup></script>
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
                                class="align-self-start px-2"
                                src="/images/pdficon.png"
                            />
                            <div>
                                <span>Receiptasdasfddsfsa.pdf</span>
                                <br />
                                <span>64 KB</span>
                                <br />
                                <br />
                                <VBtn
                                    size="small"
                                    variant="outlined"
                                    color="secondary"
                                >
                                    <v-icon
                                        icon="mdi-download"
                                        color="#fff"
                                    ></v-icon>
                                </VBtn>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="physicalresourcepdfbar-unhover pa-1 px-2 d-flex align-center"
                >
                    <div class="physicalresource-child-content">
                        <img src="/images/pdficon.png" class="px-2" />
                        <span class="text-white"
                            >Receiptasdasfddsfsadfasdf...</span
                        >
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
</style>
