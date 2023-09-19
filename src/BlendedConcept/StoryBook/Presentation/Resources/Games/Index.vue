<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import Show from "./Show.vue";
import Create from "./Create.vue";
let props = defineProps(['disabilityTypes', 'games']);
console.log(props.games.data);
// let datas = [
//     {
//         id: 1,
//         image: "/images/image1.png",
//         title: "Story 1",
//     },
//     {
//         id: 2,
//         image: "/images/image2.png",
//         title: "Story 2",
//     },
//     {
//         id: 3,
//         image: "/images/image3.png",
//         title: "Story 3",
//     },
//     {
//         id: 4,
//         image: "/images/image4.png",
//         title: "Story 4",
//     },
//     {
//         id: 5,
//         image: "/images/image5.png",
//         title: "Story 5",
//     },
//     {
//         id: 6,
//         image: "/images/image6.png",
//         title: "Story 6",
//     },
//     {
//         id: 7,
//         image: "/images/image7.png",
//         title: "Story 7",
//     },
//     {
//         id: 8,
//         image: "/images/image8.png",
//         title: "Story 8",
//     },
//     {
//         id: 9,
//         image: "/images/image9.png",
//         title: "Story 9",
//     },
//     {
//         id: 10,
//         image: "/images/image10.png",
//         title: "Story 10",
//     },
//     {
//         id: 11,
//         image: "/images/image3.png",
//         title: "Story 11",
//     },
//     {
//         id: 12,
//         image: "/images/image4.png",
//         title: "Story 12",
//     },
// ];
const alertNow = () => {
    alert("hello world");
};
</script>
<template>
    <AdminLayout>
        <VContainer fluid>
            <div class="head-section">
                <div class="title-section">
                    <p class="heading">Manage Games</p>
                    <span class="subheading">Showing 18 games</span>
                </div>
                <div class="head-button">
                    <Create :disabilityTypes="props.disabilityTypes.data"/>
                </div>
            </div>

            <VRow class="mt-5">
                <VCol
                    cols="12"
                    sm="6"
                    md="4"
                    lg="3"
                    v-for="data in props.games.data"
                    :key="data.thumbnail"
                >
                    <Show :data="data" />
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.heading {
    margin: 0;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
}

.head-button {
    align-self: flex-end;
}
.fit-img {
    width: 100%;
    height: 100%;
    max-height: 217px;
}
.item-frame {
    position: relative;
}
.v-card {
    transition: opacity 0.4s ease-in-out;
    opacity: 0.8;
}

.v-card:not(.on-hover) {
    opacity: 1;
}
</style>
