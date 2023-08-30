<script setup>
import { useTheme } from "vuetify";
import PieChart from "@/@core/libs/chartjs/components/PieChart";
import { getLatestBarChartConfig } from "@core/libs/chartjs/chartjsConfig";

const props = defineProps({
    colors: {
        type: null,
        required: true,
    },
});

const vuetifyTheme = useTheme();
const chartOptions = { responsive: true, maintainAspectRatio: false };

const data = {
    labels: ["Red", "Blue", "Yellow"],
    datasets: [
        {
            label: "My First Dataset",
            data: [300, 50, 100],
            backgroundColor: [
                "rgb(255, 99, 132)",
                "rgb(54, 162, 235)",
                "rgb(255, 205, 86)",
            ],
            hoverOffset: 4,
        },
    ],
};
</script>

<template>
    <PieChart :height="400" :chart-data="data" :chart-options="chartOptions" />
</template>
