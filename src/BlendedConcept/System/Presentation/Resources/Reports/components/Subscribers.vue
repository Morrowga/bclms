<script setup>
import ChartJsBarChart from "@/views/charts/chartjs/ChartJsBarChart.vue";
import ChartJsPieChart from "@/views/charts/chartjs/ChartJsPieChart.vue";
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
                    <span class="main-title pppangram-medium">Pie Chart</span
                    ><br />
                    <span class="title pppangram-medium"
                        >Number Of Subscribers</span
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
                        <VCol cols="12" md="6">
                            <v-btn size="small" color="secondary" class="w-100"
                                >Subscribers</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="6">
                            <v-btn size="small" color="" class="w-100"
                                >Ads Engagement
                            </v-btn>
                        </VCol>

                        <VCol cols="12">
                            <ChartJsPieChart :colors="chartJsCustomColors" />
                        </VCol>
                        <VCol cols="6" md="6">
                            <v-btn size="small" color="none" class="w-100"
                                >Sharing Platform</v-btn
                            >
                        </VCol>
                        <VCol cols="6" md="6">
                            <v-btn size="small" color="none" class="w-100">
                                <span class="text-wrap">
                                    Subscription Plans
                                </span>
                            </v-btn>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="6">
            <VRow>
                <VCol cols="12" md="10">
                    <span class="main-title pppangram-medium">Histogram</span
                    ><br />
                    <span class="title pppangram-medium">Total Revenue</span
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
                        <VCol cols="12" md="6">
                            <v-btn size="small" color="secondary" class="w-100"
                                >Economic Status</v-btn
                            >
                        </VCol>
                        <VCol cols="12" md="6">
                            <v-btn size="small" color="none" class="w-100"
                                >New Subscribers</v-btn
                            >
                        </VCol>

                        <VCol cols="12">
                            <ChartJsBarChart :colors="chartJsCustomColors" />
                        </VCol>
                        <VCol cols="12">
                            <v-btn size="small" color="none" class="w-100"
                                >Account Subjected for Renewal</v-btn
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
