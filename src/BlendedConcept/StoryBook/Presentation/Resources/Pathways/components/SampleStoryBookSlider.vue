<script setup>
import { ref, defineProps } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
let model = ref(false);
const props = defineProps({
    title: {
        type: String,
        default: "",
    },
    subtitle: {
        type: String,
        default: "",
    },
});
let datas = [
    {
        id: 1,
        image: "/images/image1.png",
        title: "Story 1",
    },
    {
        id: 2,
        image: "/images/image2.png",
        title: "Story 2",
    },
    {
        id: 3,
        image: "/images/image3.png",
        title: "Story 3",
    },
    {
        id: 4,
        image: "/images/image4.png",
        title: "Story 4",
    },
    {
        id: 5,
        image: "/images/image5.png",
        title: "Story 5",
    },
];
const toggleDialog = (id) => {
    console.log("id", id);
    // dialog.value = !dialog.value;
};
</script>
<template>
    <div class="control-position">
        <div class="head-section">
            <div class="title-section">
                <p class="heading-title">{{ title }}</p>
                <span class="subheading">{{ subtitle }}</span>
            </div>
        </div>
        <swiper :slides-per-view="3" :space-between="10">
            <swiper-slide v-for="data in datas" :key="data.image">
                <div style="position: relative">
                    <p
                        class="font-weight-bold text-right"
                        style="
                            position: absolute;
                            top: -9px;
                            right: 7px;
                            z-index: 3;
                        "
                    >
                        <VIcon
                            icon="mdi-minus-circle"
                            size="20"
                            color="#282828"
                            class="mb-2 ml-2"
                        />
                    </p>

                    <p
                        class="font-weight-bold text-right text-white"
                        style="
                            position: absolute;
                            top: 6px;
                            left: 21px;
                            z-index: 3;
                        "
                    >
                        <VBtn
                            color="#fff"
                            icon="dd"
                            size="x-small"
                            style="border: 3px solid #000 !important"
                        >
                            <span class="text-dark">1</span>
                        </VBtn>
                    </p>
                    <v-card
                        class="ma-4"
                        height="200"
                        style="position: relative; z-index: 1"
                        :color="'primary'"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <img class="bg-white fit-img-2" :src="data.image" />
                        </div>
                        <v-scale-transition class="full-icon">
                            <v-icon
                                size="48"
                                icon="mdi-check-circle-outline"
                            ></v-icon>
                        </v-scale-transition>
                    </v-card>
                    <p class="font-weight-bold text-center">{{ data.title }}</p>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>

<style scoped>
.control-position {
    position: relative;
}

.v-slide-group__next {
    cursor: pointer;
    position: absolute;
    top: 10px !important;
    right: -38px;
    height: 100%;
}

.v-slide-group__prev {
    cursor: pointer;
    position: absolute;
    top: 10px !important;
    left: -24px;
    height: 100%;
    z-index: 1;
}

.fit-img-2 {
    object-fit: cover;
    width: 120%;
    height: 120%;
    /* height: 100%; */
}

.head-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.heading-title {
    margin: 0;
    font-size: 20px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
    padding-left: 9px !important;
}

.head-button {
    align-self: flex-end;
}

.full-icon {
    position: absolute;
    left: 50%;
    right: 0;
    bottom: 0;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>
