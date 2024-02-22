<script setup>
import { router } from "@inertiajs/core";

let props = defineProps(["book"]);
const isDialogVisible = ref(false);
const isClaimed = ref(false);
const setImage = (book) => {
    return book.thumbnail_img == "" || !book.thumbnail_img
        ? "/images/defaults/organisation_logo.png"
        : book.thumbnail_img;
};
const userImage = (user) => {
    if (user) {
        return user.profile_pic ?? "/images/profile/profilefive.png";
    } else {
        return "/images/profile/profilefive.png";
    }
};

const downloadResource = (url) =>  {
      const anchor = document.createElement("a");
      anchor.style.display = "none";
      anchor.href = url;
      anchor.setAttribute("download", "");

      document.body.appendChild(anchor);

      anchor.click();

      document.body.removeChild(anchor);
}

const downloadPhysicalResource = () => {
    let downloadData = props.book.physical_resources;
    console.log(downloadData);
    downloadData.forEach(data => {
        downloadResource(data.url);
    });
}


const clickBook = (versions) => {
    if (versions && versions.length > 0) {
        isDialogVisible.value = true;
    } else {
        router.get(route("storybooks.show", { book: props.book.id }));
    }
};
const readOrginal = () => {
    router.get(route("storybooks.show", { book: props.book.id }));
};

const readVersion = (book_version_id) => {
    router.get(route("storybooks.version", { book_version: book_version_id }));
};
const setIsClaimed = (student_assigns) => {
    // console.log(student_assigns);
    let condition = student_assigns?.find(
        (assign) => assign.pivot.completed_once == 1
    );
    if (condition) {
        isClaimed.value = true;
    } else {
        isClaimed.value = false;
    }
};
const dynamicPhoto = () => {
    return isClaimed.value
        ? "/images/Silver Coin.png"
        : "/images/Gold Coin.png";
};
onMounted(() => {
    let data = props.book.book_versions;
    for (let i = 0; i < data.length; i++) {
        setIsClaimed(data[i].storybook_assigments);
    }
});
</script>
<template>
    <div>
        <VCard class="card-story" @click="clickBook(book.book_versions)">
            <v-img :src="setImage(book)" class="showimg" cover></v-img>
            <div class="d-flex justify-center">
                <img
                    src="/images/Play Button.png"
                    @click="() => router.get(route('storybooks.show'))"
                    class="playButton"
                    alt=""
                />
            </div>
            <div class="d-flex justify-center">
                <div class="goldCoin">
                    <v-chip class="coinChip text-center">
                        <div class="mt-2 text-center">
                            <span v-if="isClaimed" class="chipText">{{
                                book.num_silver_coins
                            }}</span>
                            <span v-else class="chipText">{{
                                book.num_gold_coins
                            }}</span>
                        </div>
                        <div class="text-center mt-2">
                            <img
                                :src="dynamicPhoto()"
                                width="30"
                                height="30"
                                alt=""
                            />
                        </div>
                    </v-chip>
                </div>
            </div>
        </VCard>
        <div class="text-center mt-3">
            <span class="bookname ruddy-bold">{{ book.name }}</span>
        </div>
        <VDialog v-model="isDialogVisible" width="700">
            <!-- Activator -->
            <!-- Dialog Content -->
            <VCard class="version-card">
                <VCardText>
                    <span class="ruddy-bold versiontext"
                        >Choose a version for {{ book.name }}</span
                    >
                </VCardText>
                <div class="px-7 my-6">
                    <VRow>
                        <!-- <VCol cols="4">
                            <VCard
                                class="version-mini-card"
                                @click="readOrginal()"
                            >
                                <div class="text-center">
                                    <span class="ruddy-bold versiontext"
                                        >Original</span
                                    >
                                </div>
                                <v-img
                                    :src="setImage(book)"
                                    class="mx-2"
                                    cover
                                ></v-img>
                                <div class="text-center">
                                    <span class="original"
                                        >The Original Copy</span
                                    >
                                </div>
                            </VCard>
                        </VCol> -->
                        <VCol
                            cols="4"
                            v-for="book_version in book.book_versions"
                            :key="book_version.id"
                        >
                            <VCard
                                class="version-mini-card"
                            >
                                <div class="text-center">
                                    <span class="ruddy-bold versiontext">{{
                                        book_version.name
                                    }}</span>
                                </div>
                                <v-img
                                    @click="readVersion(book_version.id)"
                                    :src="setImage(book)"
                                    class="mx-2"
                                    cover
                                ></v-img>
                                <div class="text-left">
                                    <p class="original ml-2 mt-2">
                                        {{ book_version.description }}
                                    </p>
                                    <p class="original ml-2 mt-2">
                                        {{ book.description }}
                                    </p>
                                    <div class="px-4">
                                        <a @click="downloadPhysicalResource()">
                                            <v-btn variant="flat" class="physical-resource-btn" rounded color="#fff1ce">Download Physical Resource</v-btn>
                                        </a>
                                    </div>
                                </div>

                                <div class="ml-2 mt-9 mb-5">
                                    <v-avatar size="30">
                                        <v-img
                                            :src="
                                                userImage(
                                                    book_version.owner?.user
                                                )
                                            "
                                            alt=""
                                        />
                                    </v-avatar>
                                    <span class="version-profile-text ml-2">{{
                                        book_version.owner
                                            ? book_version.owner.user.full_name
                                            : "Blended Concept"
                                    }}</span>
                                </div>
                            </VCard>
                        </VCol>
                    </VRow>
                </div>
                <!-- <VCardActions>
            <VSpacer />
            <VBtn @click="isDialogVisible = false">
            I accept
            </VBtn>
        </VCardActions> -->
            </VCard>
        </VDialog>
    </div>
</template>

<style scoped>
.version-profile-text {
    font-size: 10px !important;
    font-weight: bold !important;
    color: #000 !important;
}
.original {
    font-weight: bold !important;
    line-height: 1.5 !important;
    color: #000 !important;
    font-size: 10px !important;
}
.versiontext {
    color: #000 !important;
}
.version-card {
    border: 3px solid #000;
    background: #fff2ce;
}

.version-mini-card {
    border: 3px solid #000;
    background: #fff;
    height: 100%;
}

.physical-resource-btn{
    font-size: 10px !important;
    box-shadow: 2px 2px 2px rgb(0,0,0,0.3);
}

:deep(.physical-resource-btn .v-btn__content){
    font-size: 9px !important;
    color: #000 !important;
}
</style>
