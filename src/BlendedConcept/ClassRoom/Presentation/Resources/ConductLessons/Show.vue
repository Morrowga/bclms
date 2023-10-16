<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";

let props = defineProps(["version", "video"]);
const is_interactive = ref(true);
const videoSrc = ref(props.video);
const h5pIframe = ref(null);

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

 const changeMode = (bool) => {
    is_interactive.value = bool;
 }
</script>
<template>
    <AdminLayout>
        <VContainer>
            <div class="d-flex mb-4">
                <h1 class="mb-4 font-weight-bold text-h5">
                    {{ props.version.name  }}
                </h1>
                <v-spacer></v-spacer>
            </div>
            <div class="book-panels">
                <div class="d-flex">
                    <v-btn class="mr-2 text-white" color="#EF5350"
                    @click="changeMode(false)"
                        >Class Mode</v-btn
                    >
                    <v-btn color="#42A5F5" class="text-white"
                    @click="changeMode(true)"
                        >Interactive Mode</v-btn
                    >
                </div>
                <br />
                <div class="mt-10" v-if="is_interactive">
                    <iframe
                        ref="h5pIframe"
                        :src="app_url + '/admin/h5p/h5p/' + props.version.h5p_id"
                        frameborder="0"
                        scrolling="auto"
                        class="h5p-width"
                    ></iframe>
                </div>
                <div v-else>
                    <iframe
                    :src="videoSrc"
                    frameborder="0"
                    scrolling="auto"
                    class="h5p-width"
                    >
                    </iframe>
                </div>
            </div>
            <br />
            <Link :href="route('conduct_lessons.index')">
                <v-btn variant="flat" class="text-white" color="#FC0" rounded
                    >Back</v-btn
                >
            </Link>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.v-label.v-field-label {
    color: unset !important;
    font-size: unset !important;
    font-style: unset !important;
    font-weight: unset !important;
    text-transform: unset !important;
}

.h5p-width {
    width: 100%;
    height: 1000px;
}

.classmode{
    width: 100%;
}
</style>
