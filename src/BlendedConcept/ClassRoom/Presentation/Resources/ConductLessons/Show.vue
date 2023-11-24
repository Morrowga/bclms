<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted,onBeforeUnmount } from 'vue';

let props = defineProps(["version", "video", "type"]);
const is_interactive = ref(true);
const videoSrc = ref(props.video);
const h5pIframe = ref(null);

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

 const changeMode = (bool) => {
    is_interactive.value = bool;
 }

 const storybookData = ref({
  timeSpend: '10mins',
  completed: 'yes',
  progress: '100%',
  accuracy: '5%'
});

// Retrieve data from localStorage on component mount
onMounted(() => {
  localStorage.setItem('storybook', JSON.stringify(storybookData.value));
  setCookie('storybook', JSON.stringify(storybookData.value), 30); // 30 days expiration
});

onBeforeUnmount(() => {
    const storedData = localStorage.getItem('storybook');
    if (storedData) {
        const storageData = JSON.parse(storedData);
        alert('that is storage data ' + storageData.timeSpend + ',' + storageData.completed + ',' + storageData.progress + ',' + storageData.accuracy);
    }

    const storedCookie = getCookie('storybook');
    if (storedCookie) {
        const parsedData = JSON.parse(storedCookie);
        alert('that is cookie data ' + parsedData.timeSpend + ',' + parsedData.completed + ',' + parsedData.progress + ',' + parsedData.accuracy);
    }
});

function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// Function to get a cookie value
function getCookie(name) {
    const keyValue = document.cookie.match(`(^|;) ?${name}=([^;]*)(;|$)`);
    return keyValue ? keyValue[2] : null;
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
                        v-if="props.type != 'HTML5'"
                        ref="h5pIframe"
                        :src="app_url + '/admin/h5p/h5p/' + props.version.h5p_id"
                        frameborder="0"
                        scrolling="auto"
                        class="h5p-width"
                    ></iframe>
                    <iframe v-else
                        ref="h5pIframe"
                        :src="app_url + '/book_html5/' + props.video"
                        frameborder="0"
                        scrolling="auto"
                        class="h5p-width"
                    ></iframe>
                </div>
                <div v-else>
                    <iframe
                    v-if="props.type != 'HTML5'"
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
