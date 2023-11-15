<script setup>
import { ref, defineProps } from "vue";
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
    // console.log("id", id);
    // dialog.value = !dialog.value;
};
</script>
<template>
    <div class="control-position">
        <div class="head-section">
            <div class="title-section">
                <p class="heading-title">Sticker Library</p>
                <span class="subheading">{{ subtitle }}</span>
            </div>
            <div class="search-sticker">
                <v-text-field
                    placeholder="Search Sticker"
                    variant="outlined"
                    density="compact"
                ></v-text-field>
            </div>
        </div>
        <v-slide-group v-model="model" center-active show-arrows>
            <v-slide-group-item
                v-for="data in datas"
                :key="data.image"
                v-slot="{ isSelected, toggle }"
            >
                <div class="ps-relative">
                    <v-card
                        height="200"
                        width="350"
                        @click="toggle"
                        class="ma-4 ps-relative"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <img class="bg-white fit-img-2" :src="data.image" />
                        </div>
                    </v-card>
                    <p class="font-weight-bold text-center">{{ data.title }}</p>
                    <div
                        class="dot dot--empty"
                        :class="isSelected ? 'active' : 'in-active'"
                    ></div>
                </div>
            </v-slide-group-item>
        </v-slide-group>
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
    line-height: 52px !important; /* 130% */
    text-transform: capitalize !important;
    color: var(--tiggie-blue, #4066e4);
    padding-left: 66px !important;
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
.search-sticker {
    padding-right: 55px;
    width: 30%;
}
.dot {
    position: absolute;
    box-sizing: border-box;
    width: 0.7rem;
    height: 0.7rem;
    border-radius: 50%;
    border: 0.125rem solid;
    display: inline-block;
    top: 25px;
    left: 27px;
}
.dot--empty {
    background-color: transparent;
}
.active {
    color: #fff;
    background: #4066e4;
}
.in-active {
    color: #fff;
    background: #fff;
}
</style>
