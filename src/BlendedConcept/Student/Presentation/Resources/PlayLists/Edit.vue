<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import PlayListSelectBox from "./components/PlayListSelectBox.vue";
import { SuccessDialog } from "@actions/useSuccess";
import SelectStudent from "./components/SelectStudent.vue";
import SelectStorybook from "./components/SelectStorybook.vue";
import { useForm } from "@inertiajs/vue3";

let props = defineProps([
    'playlist'
]);

const playlist = ref(props.playlist.data.playlist_photo);
const dragging = ref(false);
const playlistFile = ref(null);
const storybookids = ref([]);

for (const item of props.playlist.data.storybooks) {
    storybookids.value.push(item.id);
}
const form = useForm({
    name: props.playlist.data.name,
    image: null,
    student_id: props.playlist.data.student.student_id,
    teacher_id: props.playlist.data.teacher_id,
    storybooks: storybookids.value.length > 0 ? storybookids.value : [] ,
    _method: 'PUT'
});

const handlePlaylistChange = (event) => {
  const file = event.target.files[0];
  playlistFile.value = file;
  playlist.value = URL.createObjectURL(file);
  console.log(profile.value);
};

const onDropPlaylist = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  playlist.value = URL.createObjectURL(files[0]);
  playlistFile.value = files[0];
};

const updatePlaylist = () => {
    form.image = playlistFile.value
    form.post(route("playlists.update", props.playlist.data.id), {
        onSuccess: () => {
            SuccessDialog({
                title: "You have successfully updated playlist!",
                color: "#17CAB6",
            });
        },
        onError: (error) => {
            form.setError("name", error?.name);
        },
    });
};

</script>

<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="space-around">
                <VCol cols="12">
                    <h4 class="tiggie-teacher-title">Edit Playlist</h4>
                </VCol>
                <VCol cols="6" class="pr-10">
                    <div
                            class="profile-drag"
                            :class="!playlist ? 'd-flex justify-center' : ''"
                            @dragover.prevent
                            @dragenter.prevent
                            @dragleave="dragging = false"
                            @drop.prevent="onDropPlaylist"
                        >
                            <div v-if="!playlist">
                                <div class="d-flex justify-center text-center">
                                    <v-img src="/images/Icons.png" width="80" height="80"></v-img>
                                </div>
                                <p class="pppangram-bold mt-5">
                                    Drag your item to upload
                                </p>
                                <p class="mt-2 blur-p">
                                    PNG, GIF, WebP, MP4 or MP3. Maximum file size 100 Mb.
                                </p>
                            </div>
                            <div v-else>
                                <v-img :src="playlist" class="profileimg" cover/>
                                <!-- <p>File Name: {{ gameFile.name }}</p> -->
                            <!-- <button @click="removeGameFile" class="remove-button">
                                Remove
                            </button> -->
                            </div>
                            <input
                            type="file"
                            style="display: none"
                            @change="handlePlaylistChange"
                            />
                        </div>
                </VCol>

                <VCol cols="6">
                    <h1 class="tiggie-teacher-subtitle mb-5">
                        Playlist Details
                    </h1>

                    <VLabel class="tiggie-teacher-label mb-2 required"
                        >Name</VLabel
                    >

                    <VTextField placeholder="e.g. Bravery" v-model="form.name" color="line" />
                </VCol>
                <VCol cols="12">
                        <div class="mt-15">
                            <v-expansion-panels>
                                <SelectStudent :form="form" />
                            </v-expansion-panels>
                        </div>
                        <div class="mt-3">
                            <v-expansion-panels>
                                <SelectStorybook :form="form" />
                            </v-expansion-panels>
                        </div>
                        <!-- 👉 Collapsible Section -->
                        <!-- <PlayListSelectBox :datas="props.students.data" :storybooks="props.storybooks.data" /> -->
                    </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="4">
                    <div class="d-flex gap-3">
                        <VBtn
                            class="text-tiggie-blue px-16"
                            color="pale-blue"
                            variant="flat"
                            rounded
                        >
                            Cancel
                        </VBtn>
                        <VBtn
                            class="text-white px-16"
                            color="primary"
                            variant="flat"
                            rounded
                            @click="updatePlaylist()"
                        >
                            Update
                        </VBtn>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.playlist-border {
    border: 3px solid #565660 !important;
}

.blur-p{
    color: var(--Secondary2, rgba(86, 86, 96, 0.40));
    text-align: center;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px; /* 157.143% */
    text-transform: capitalize;
}

.profile-drag {
  align-items: center;
  text-align: center;
  width: 100%;
  background: #f7f7f7;
  height: 440px;
  border: 1px solid rgb(182,182,186, 0.6);
  border-radius: 10px;
}

.profileimg{
    object-fit: cover !important;
    height: 440px;
    border-radius: 10px;
}
.profile-drag p {
  margin-bottom: 0;
}
</style>
