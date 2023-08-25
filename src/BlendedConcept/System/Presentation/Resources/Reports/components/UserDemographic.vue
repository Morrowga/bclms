<script setup>
import ApexChartExpenseRatio from "@/views/charts/apex-chart/ApexChartExpenseRatio.vue";
import ChartJsBarChart from "@/views/charts/chartjs/ChartJsBarChart.vue";
const chartJsCustomColors = {
    white: "#fff",
    yellow: "#ffe802",
    primary: "#836af9",
    areaChartBlue: "#2c9aff",
    barChartYellow: "#ffcf5c",
    polarChartGrey: "#4f5d70",
    polarChartInfo: "#299aff",
    lineChartYellow: "#d4e157",
    polarChartGreen: "#28dac6",
    lineChartPrimary: "#9e69fd",
    lineChartWarning: "#ff9800",
    horizontalBarInfo: "#26c6da",
    polarChartWarning: "#ff8131",
    scatterChartGreen: "#28c76f",
    warningShade: "#ffbd1f",
    areaChartBlueLight: "#84d0ff",
    areaChartGreyLight: "#edf1f4",
    scatterChartWarning: "#ff9f43",
};
</script>
<template>
    <VRow>
        <VCol cols="12" md="6">
            <VRow>
                <VCol cols="12" md="10">
                    <span class="main-title pppangram-medium">Child Data</span
                    ><br />
                    <span class="title pppangram-medium">Age Of Child</span
                    ><br />
                    <span class="subtitle pppangram-medium"
                        >Blended Concept</span
                    ><br />
                </VCol>
                <VCol cols="12" md="2" class="text-end">
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
                <VCol cols="12">
                    <VRow>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="secondary" class="w-100"
                                >Age</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Gender</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Education Level</v-btn
                            >
                        </VCol>
                        <VCol cols="12">
                            <ApexChartExpenseRatio />
                        </VCol>
                        <VCol cols="6" md="3">
                            <v-btn size="small" color="none" class="w-100"
                                >Condition</v-btn
                            >
                        </VCol>
                        <VCol cols="6" md="3">
                            <v-btn size="small" color="none" class="w-100"
                                >School</v-btn
                            >
                        </VCol>
                        <VCol cols="6" md="3">
                            <v-btn size="small" color="none" class="w-100"
                                >Country</v-btn
                            >
                        </VCol>
                        <VCol cols="6" md="3">
                            <v-btn size="small" color="none" class="w-100"
                                >Device</v-btn
                            >
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="6">
            <VRow>
                <VCol cols="12" md="10">
                    <span class="main-title pppangram-medium"
                        >Caregiver Data</span
                    ><br />
                    <span class="title pppangram-medium">Economic Status</span
                    ><br />
                    <span class="subtitle pppangram-medium"
                        >Blended Concept</span
                    ><br />
                </VCol>
                <VCol cols="12" md="2" class="text-end">
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
                <VCol cols="12">
                    <VRow>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="secondary" class="w-100"
                                >Economic Status</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Relationship to Child</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Education Level</v-btn
                            >
                        </VCol>
                        <VCol cols="12">
                            <ChartJsBarChart :colors="chartJsCustomColors" />
                        </VCol>
                        <VCol cols="6" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Confidence</v-btn
                            >
                        </VCol>
                        <VCol cols="6" md="4">
                            <v-btn size="small" color="none" class="w-100">
                                <span class="text-wrap"> Frequency of </span>
                            </v-btn>
                        </VCol>
                        <VCol cols="6" md="4">
                            <v-btn size="small" color="none" class="w-100"
                                >Perception</v-btn
                            >
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VCol>
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
