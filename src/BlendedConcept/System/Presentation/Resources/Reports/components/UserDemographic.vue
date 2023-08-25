<script setup></script>
<template>
    <VRow>
        <VCol cols="12" md="6">
            <VRow>
                <VCol cols="12" md="6">
                    <span class="main-title pppangram-medium">Child Data</span
                    ><br />
                    <span class="title pppangram-medium">Age Of Child</span
                    ><br />
                    <span class="subtitle pppangram-medium"
                        >Blended Concept</span
                    ><br />
                </VCol>
                <VCol cols="12" md="6" class="text-end">
                    <v-btn
                        variant="flat"
                        color="inactive-tab inactive-border"
                        icon
                    >
                        <VIcon
                            size="30"
                            icon="mdi-swap-vertical-circle"
                        ></VIcon>
                    </v-btn>
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="6"> </VCol>
    </VRow>
</template>
<style scoped>
.main-title {
    color: var(--text, #2d2d2d) !important;

    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: normal !important;
}
.title {
    color: var(--text, #2d2d2d) !important;

    font-size: 30px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: normal !important;
    text-transform: capitalize !important;
}

.subtitle {
    color: var(--secondary-text, #72777b) !important;

    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: normal !important;
}
.inactive-border {
    border: 1px solid var(--line, #e5e5e5);
}
</style>
