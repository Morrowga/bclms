<script setup>
import StudentLayout from "@Layouts/Dashboard/StudentLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/core";
import { computed, defineProps, ref } from "vue";
let props = defineProps(["book"]);
let flash = computed(() => usePage().props.flash);
let permissions = computed(() => usePage().props.auth.data.permissions);
let iframeRef = ref("");
const active = ref("assigned");

const activeTab = (name) => {
    active.value = name;
};
const page = usePage();
const app_url = ref("");
onMounted(() => {
    iframeRef.value.style.display = "none";
    iframeRef.value.addEventListener("load", () => {
        app_url.value = page?.props?.route_site_url;
        iframeRef.value.style.display = "flex";
        let subIframe =
            iframeRef.value.contentWindow.document.querySelector(".h5p-iframe");
        let actionBar = subIframe.contentWindow.document.querySelector(
            ".h5p-iframe body div > .h5p-actions"
        );

        const cancelbutton =
            iframeRef.value.contentWindow.document.querySelector(
                "body > div > div > div p"
            );
        if (actionBar && cancelbutton) {
            actionBar.style.display = "none";
            cancelbutton.style.display = "none";
        } else {
            console.log("Buttons not found!");
        }
    });
});
</script>
<template>
    <StudentLayout>
        <section class="book_view">
            <div class="">
                <img
                    src="/images/back.png"
                    @click="() => router.get(route('storybooks'))"
                    class="backarrow"
                    alt=""
                />
            </div>
            <div class="d-flex justify-center">
                <iframe
                    :src="`${app_url}/admin/h5p/h5p/${props.book.h5p_id}`"
                    frameborder="0"
                    class="h5p-width"
                    ref="iframeRef"
                ></iframe>
            </div>
        </section>
    </StudentLayout>
</template>

<style lang="scss">
.book_view {
    min-height: 100vh;
}
.backarrow {
    cursor: pointer;
    width: 40px !important;
    height: 40px !important;
}
.h5p-width {
    width: 75%;
    height: 840px;
}

// .student .layout-page-content{
//     background: url('/images/artbg.png') no-repeat !important;
//     background-size: cover !important;
//     background-position: center !important;
// }
.videoplayer {
    height: 600px;
}

.app-user-search-filter {
    inline-size: 24.0625rem;
}

.overlay-container {
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

// .user-data-table table.vgt-table thead th {
//     background: rgb(var(--v-theme-surface)) !important;
//     color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
// }

.user-list-name:not(:hover) {
    color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>
