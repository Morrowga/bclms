<script setup>
import { ref, defineProps } from "vue";
import ShowDetail from "./ShowDetail.vue";
import ShowBookDetail from "./ShowBookDetail.vue";
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
    datas: {
        type: Array,
        default: [],
    },
    btnText: {
        type: String,
        default: "",
    },
    url: {
        type: String,
        default: "#",
    },
    type: {
        type: String,
        required: true,
    },
});
let dialog = ref(false);
const toggleDialog = (id) => {
    console.log("id", id);
    // dialog.value = !dialog.value;
};
const resolveComponent = (item) => {
    if (props.type == "games") return ShowDetail;

    return ShowBookDetail;
};
</script>
<template>
    <div class="control-position">
        <div class="head-section">
            <div class="title-section">
                <p class="heading">{{ title }}</p>
                <span class="subheading">{{ subtitle }}</span>
            </div>
            <div class="head-button">
                <Link :href="url">
                    <VBtn>{{ btnText }}</VBtn>
                </Link>
            </div>
        </div>
        <v-slide-group v-model="model" center-active show-arrows mandatory>
            <v-slide-group-item v-for="data in datas" :key="data.image">
                <!-- <ShowDetail :data="data" /> -->
                <Component :is="resolveComponent(item)" :data="data" />
            </v-slide-group-item>
        </v-slide-group>
    </div>
</template>

<style>
.control-position {
    position: relative;
}
.control-position .v-slide-group__next {
    cursor: pointer;
    position: absolute;
    top: 40px;
    right: -38px;
    height: 100%;
}
.control-position .v-slide-group__prev {
    cursor: pointer;
    position: absolute;
    top: 40px;
    left: -24px;
    height: 100%;
    z-index: 1;
}
.fit-img {
    object-fit: cover;
    width: 300px;
    height: auto;
    /* height: 100%; */
}

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
</style>
