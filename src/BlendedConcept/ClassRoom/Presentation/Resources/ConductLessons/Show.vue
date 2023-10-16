<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";

let props = defineProps(["version"]);
const is_interactive = ref(true);
const videoSrc = ref(null);
const videoIframe = ref(null);

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

const getVideoLink = () => {
  const iframe = videoIframe.value;
  if (iframe) {
    // Access the iframe's content document
    const iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

    // Assuming the video is inside the iframe content, you can select it by its tag or attributes
    const videoElement = iframeDocument.querySelector('video');

    if (videoElement) {
      // Get the video source URL
      const videoSource = videoElement.getAttribute('src');

      return videoSource;
    } else {
      console.log('No video element found inside the iframe.');
    }
  } else {
    console.log('Iframe element not found.');
  }
};

 const changeMode = (bool) => {
    if(bool == false){
       let videoLink = getVideoLink();
       videoSrc.value = videoLink
    }
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
                        ref="videoIframe"
                        :src="app_url + '/admin/h5p/h5p/' + props.version.h5p_id"
                        frameborder="0"
                        scrolling="auto"
                        class="h5p-width"
                    ></iframe>
                </div>
                <div v-else>
                    <video controls class="classmode">
                    <source :src="''" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
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
