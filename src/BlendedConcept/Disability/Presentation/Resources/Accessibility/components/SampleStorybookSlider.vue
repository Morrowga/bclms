<script setup>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";

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
    books: {
        type: Array,
        default: "",
    },
    form: {
        type: Object,
        default: null,
    },
});
const toggleDialog = (id) => {
    console.log("id", id);
    // dialog.value = !dialog.value;
};
let isSelected = ref("");
const getImage = (data) => {
    return data.thumbnail_image ?? "/images/image8.png";
};
const selectBook = (id) => {
    isSelected.value = id;
    props.form.storybook_id = isSelected.value;
};
onMounted(() => {
    if (props.form?.storybook_id == "") {
        isSelected.value = 1;
        props.form.storybook_id = 1;
    } else {
        isSelected.value = props.form?.storybook_id;
    }
});
</script>
<template>
    <div class="control-position">
        <div class="head-section">
            <div class="title-section">
                <p class="heading-title">{{ title }}</p>
                <span class="subheading">{{ subtitle }}</span>
            </div>
        </div>
        <!-- <v-slide-group v-model="model" center-active show-arrows>
            <v-slide-group-item
                v-for="data in props.books"
                :key="data.id"
                v-slot="{ isSelected, toggle }"
            >
                <div>
                    <v-card
                        class="ma-4 pos-rel"
                        height="250"
                        width="400"
                        @click="toggle"
                        :color="isSelected ? 'primary' : 'grey-lighten-3'"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <img
                                class="bg-white fit-img-2"
                                :src="getImage(data)"
                            />
                        </div>
                        <v-scale-transition class="full-icon">
                            <v-icon
                                v-if="isSelected"
                                size="48"
                                icon="mdi-check-circle-outline"
                            ></v-icon>
                        </v-scale-transition>
                    </v-card>
                    <p class="font-weight-bold text-center">{{ data.name }}</p>
                </div>
            </v-slide-group-item>
        </v-slide-group> -->
        <swiper :slides-per-view="3" :space-between="10">
            <swiper-slide
                v-for="data in props.books"
                :key="data.id"
                @click="selectBook(data.id)"
            >
                <div class="ps-relative">
                    <v-card
                        class="ma-4 container-style"
                        height="200"
                        :color="'primary'"
                    >
                        <div
                            class="d-flex fill-height align-center justify-center"
                        >
                            <img
                                class="bg-white fit-img-2"
                                :src="getImage(data)"
                            />
                        </div>
                        <v-scale-transition class="full-icon">
                            <v-icon
                                v-if="isSelected == data.id"
                                size="48"
                                icon="mdi-check-circle-outline"
                            ></v-icon>
                        </v-scale-transition>
                    </v-card>
                    <p class="font-weight-bold text-center">{{ data.name }}</p>
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
    line-height: 52px !important; /* 130% */
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
.pos-rel {
    position: relative !important;
}
</style>
