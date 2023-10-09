<script setup>
let circleDatas = [
    {
        data: "Very Good",
        color: "#009688",
    },
    {
        data: "Good",
        color: "#8BC34A",
    },
    {
        data: "Natural",
        color: "gray",
    },
    {
        data: "Bad",
        color: "#EEFF41",
    },
    {
        data: "Very Bad",
        color: "#F44336",
    },
];
let barwidth = 100;
</script>
<template>
    <div class="circle-chart pt-4">
        <v-card>
            <v-card-title>
                <h1 class="tiggie-title mb-4">How Happy Are you</h1>
            </v-card-title>
            <v-card-text>
                <v-row class="pt-4">
                    <v-col cols="12" md="6">
                        <v-img src="/images/circlechart.png" />
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-card>
                            <v-card-title>
                                <h1 class="tiggie-title mb-4">Legend</h1>
                            </v-card-title>
                            <v-table>
                                <thead>
                                    <tr>
                                        <th class="text-left">Data</th>
                                        <th class="text-left">Color</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="item in circleDatas"
                                        :key="item.name"
                                    >
                                        <td>{{ item.data }}</td>
                                        <td>
                                            <div class="circle-chart">
                                                <v-progress-linear
                                                    :color="item.color"
                                                    v-model="barwidth"
                                                    height="25"
                                                ></v-progress-linear>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>
<style scoped>
.circle-chart {
    width: 100px;
    height: 30px;
}
</style>
