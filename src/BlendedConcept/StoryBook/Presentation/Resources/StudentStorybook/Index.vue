<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
import { checkPermission } from "@actions/useCheckPermission";

import VersionCard from "@mainRoot/components/Teacher/VersionCard.vue";
let props = defineProps(["flash", "auth", "books", "playlists", "pathways"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
const active = ref("assigned");

const setCookie = (type) => {
    var cookieName = "storybook_type";
    var cookieValue = type;
    var expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 1);
    var expires = "expires=" + expirationDate.toUTCString();

    var cookieString =
        cookieName + "=" + cookieValue + ";" + expires + ";path=/";

    document.cookie = cookieString;
};
const activeTab = (name) => {
    active.value = name;
    setCookie(name);
};
const getImage = (pathway) => pathway.image_url ?? "images/Pathway Card.png";
onMounted(() => {
    setCookie("assigned");
});
let checkHide = computed(() => {
    return (
        checkPermission("access_studentAssign") ||
        checkPermission("access_studentPathway") ||
        checkPermission("access_studentPlaylist")
    );
});
</script>
<template>
    <StudentLayout>
        <section>
            <v-navigation-drawer
                floating
                permanent
                class="story-sidebar"
                v-if="checkHide"
            >
                <div
                    v-if="checkPermission('access_studentAssign')"
                    @click="activeTab('assigned')"
                    :class="{ 'inside-div': active === 'assigned' }"
                    class="mt-5"
                >
                    <div class="vlis" value="home">
                        <div class="d-flex justify-center mt-1">
                            <img
                                src="/images/bookicon.png"
                                class="icon-sidebar"
                                alt=""
                            />
                        </div>
                        <p class="text-center sidebartext pppangram-medium">
                            Assigned
                        </p>
                    </div>
                </div>
                <div
                    v-if="checkPermission('access_studentPathway')"
                    @click="activeTab('pathway')"
                    :class="{ 'inside-div': active === 'pathway' }"
                    class="mt-5"
                >
                    <div class="vlis" value="home">
                        <div class="d-flex justify-center mt-1">
                            <img
                                src="/images/pathicon.png"
                                class="icon-sidebar"
                                alt=""
                            />
                        </div>
                        <p class="text-center sidebartext pppangram-medium">
                            Path Way
                        </p>
                    </div>
                </div>
                <div
                    v-if="checkPermission('access_studentPlaylist')"
                    @click="activeTab('playlist')"
                    :class="{ 'inside-div': active === 'playlist' }"
                    class="mt-5"
                >
                    <div class="vlis" value="home">
                        <div class="d-flex justify-center mt-1">
                            <img
                                src="/images/play-square.png"
                                class="icon-sidebar"
                                alt=""
                            />
                        </div>
                        <p class="text-center sidebartext pppangram-medium">
                            Playlist
                        </p>
                    </div>
                </div>
            </v-navigation-drawer>
            <VContainer class="mb-3" v-if="active === 'assigned'">
                <VRow>
                    <VCol
                        v-for="book in props.books.data"
                        :key="book.id"
                        cols="12"
                        sm="6"
                        md="4"
                        lg="4"
                    >
                        <VersionCard :key="book.id" :book="book" />
                    </VCol>
                </VRow>
            </VContainer>
            <VContainer class="mb-3" v-if="active === 'pathway'">
                <div
                    class="d-flex justify-center my-6"
                    v-for="pathway in pathways.data"
                    :key="pathway.id"
                >
                    <img
                        :src="getImage(pathway)"
                        @click="
                            () =>
                                router.get(
                                    route('storybooks.pathway', pathway.id)
                                )
                        "
                        class="pathwayimg"
                        alt=""
                    />
                </div>
            </VContainer>
            <VContainer class="mb-3" v-if="active === 'playlist'">
                <div
                    v-for="playlist in props.playlists.data"
                    :key="playlist.id"
                >
                    <div class="text-center d-flex justify-center">
                        <div class="title-chip">
                            <span class="title-chip-text ruddy-bold"
                                >{{ playlist.name }} ({{
                                    playlist.storybooks.length
                                }}
                                Books)</span
                            >
                        </div>
                    </div>
                    <VRow class="mt-5">
                        <VCol
                            v-for="play_book in playlist.storybooks"
                            :key="play_book.id"
                            cols="12"
                            sm="6"
                            md="4"
                            lg="4"
                        >
                            <VersionCard
                                :key="play_book.id"
                                :book="play_book"
                            />
                        </VCol>
                    </VRow>
                </div>
            </VContainer>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }

.app-user-search-filter {
    inline-size: 24.0625rem;
}

.sidebartext {
    font-size: 10px !important;
    line-height: 1.5 !important;
    font-weight: bold;
    color: #000;
}

.title-chip {
    display: flex;
    padding: 0px 38px 0px 37px;
    height: 50px;
    border-radius: 30px;
    background: var(--sun-yellow, #fc0);
}

.title-chip-text {
    color: var(--graphite, #282828);
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    /* 123.333% */
    text-transform: capitalize !important;
}

.pathwayimg {
    width: 100vh;
    cursor: pointer;
}

.bookname {
    color: var(--white, #fff) !important;
    // font-family: Ruddy;
    font-size: 25px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    /* 130% */
    text-transform: capitalize !important;
}

.inside-div {
    // margin-top: 20px;
    margin-left: 0px;
    width: 78px;
    height: 75px;
    flex-shrink: 0;
    border-top-right-radius: 17px !important;
    border-bottom-right-radius: 17px !important;
    border-right: 3px solid var(--white, #fff);
    border-top: 3px solid var(--white, #fff);
    border-bottom: 3px solid var(--white, #fff);
    background: var(--sun-yellow, #fc0);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}

.coinChip {
    border-radius: 30px !important;
    display: inline-flex !important;
    height: 30px !important;
    padding: 20px !important;
    align-items: center !important;
    flex-shrink: 0 !important;
    background: var(--candy-red, #ff6262);
}

.chipText {
    color: #fff !important;
    // font-family: Ruddy;
    font-size: 25px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    /* 130% */
    letter-spacing: 5px;
    text-transform: capitalize !important;
}

.showimg {
    object-fit: cover;
    height: 230px;
}

.playButton {
    cursor: pointer;
    position: absolute;
    top: 28%;
    z-index: 1;
}

.icon-sidebar {
    width: 45px;
    height: 45px;
}

.story-sidebar {
    width: 90px !important;
    height: fit-content !important;
    margin-top: 15% !important;
    border-top: 4px solid #fff;
    border-bottom: 4px solid #fff;
    border-right: 4px solid #fff;
    border-top-right-radius: 17px;
    border-bottom-right-radius: 17px;
    background: #ff8015 !important;
}

.story-vlist {
    border-radius: 20px;
    background: #ff8015 !important;
}

.goldCoin {
    position: absolute;
    top: 0;
    margin: 10px;
    right: 0;
    letter-spacing: 15px;
    z-index: 1;
}

.card-story {
    justify-content: center;
    align-items: center;
    border-radius: 30px;
    border: 5px solid var(--white, #fff);
    backdrop-filter: blur(2px);
}

.overlay-container {
    //   z-index: 1;
    position: absolute;
    top: 8%;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-data-table table.vgt-table {
    background-color: rgb(var(--v-theme-surface));
    border-color: rgb(var(--v-theme-surface));
}

.user-data-table table.vgt-table td {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}

.textcolor {
    color: #fff;
}

.classname {
    color: #000;
    font-size: 36px;
    font-style: normal;
    font-weight: bold;
    text-transform: capitalize;
}

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
