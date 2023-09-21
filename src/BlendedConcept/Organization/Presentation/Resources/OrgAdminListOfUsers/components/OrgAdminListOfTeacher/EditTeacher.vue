<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { SuccessDialog } from "@actions/useSuccess";
import { useForm } from "@inertiajs/vue3";
let props = defineProps(['teacher']);

const teacherEditForm = useForm({
    first_name: props.teacher.data.first_name,
    last_name:  props.teacher.data.last_name,
    email: props.teacher.data.email,
    contact_number: props.teacher.data.contact_number,
    email_verification_send_on: props.teacher.data.email_verification_send_on,
    image: null,
    _method: 'PUT'
});

const profile = ref(props.teacher.data.profile_pic);
const dragging = ref(false);
const profileFile = ref(null);

const handleThumbnailChange = (event) => {
  const file = event.target.files[0];
  profileFile.value = file;
  profile.value = URL.createObjectURL(file);
  console.log(profile.value);
};

const onDropThumbnail = (event) => {
  event.preventDefault();
  dragging.value = false;
  const files = event.dataTransfer.files;
  profile.value = URL.createObjectURL(files[0]);
  console.log(profile.value);
  profileFile.value = files[0];
};

const updateTeacher = () => {
    teacherEditForm.image = profileFile.value
    teacherEditForm.post(route("organizations-teacher.update", props.teacher.data.id), {
        onSuccess: () => {
        SuccessDialog({ title: "You've successfully updated a teacher." });
        },
        onError: (error) => {
            teacherEditForm.setError("name", error?.name);
            teacherEditForm.setError("email", error?.email);
            teacherEditForm.setError("contact_number", error?.contact_number);
        },
    });
};
</script>
<template>
    <AdminLayout>
        <VContainer>
            <VRow justify="center">
                <VCol cols="6">
                    <div
                        class="profile-drag"
                        :class="!profile ? 'd-flex justify-center' : ''"
                        @dragover.prevent
                        @dragenter.prevent
                        @dragleave="dragging = false"
                        @drop.prevent="onDropThumbnail"
                    >
                        <div v-if="!profile">
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
                            <v-img :src="profile" class="profileimg" cover/>
                            <!-- <p>File Name: {{ gameFile.name }}</p> -->
                        <!-- <button @click="removeGameFile" class="remove-button">
                            Remove
                        </button> -->
                        </div>
                        <input
                        type="file"
                        style="display: none"
                        @change="handleThumbnailChange"
                        />
                    </div>
                    <!-- <VImg src="/images/teacherimg.png" /> -->
                </VCol>
                <VCol cols="6">
                    <VText class="teacherprofile-title">Profile</VText>
                    <div class="d-flex justify-space-between mt-10 pb-10">
                        <h1 class="tiggie-label fs-20">Personal Details</h1>
                    </div>
                    <VRow>
                        <VCol cols="6" class="py-2">
                            <VLabel class="tiggie-small-label">
                                First Name
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="teacherEditForm.first_name"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.first_name"
                            />
                        </VCol>
                        <VCol cols="6" class="py-2">
                            <VLabel class="tiggie-small-label">
                                Last Name
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="teacherEditForm.last_name"
                                :rules="[requiredValidator]"
                                :error-messages="form?.errors?.last_name"
                            />
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <VLabel class="tiggie-small-label">
                                Work Email
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="teacherEditForm.email"
                            />
                        </VCol>
                        <VCol cols="12" class="py-2">
                            <VLabel class="tiggie-small-label">
                                Contact Number
                                <span class="text-candy-red">*</span>
                            </VLabel>
                            <VTextField
                                placeholder=""
                                v-model="teacherEditForm.contact_number"
                            />
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>
            <VRow justify="center">
                <VCol cols="2">
                    <Link
                        :href="route('organizations-teacher.show', props.teacher.data.id)"
                        class="text-black"
                    >
                        <VBtn
                            color="#e9eff0"
                            variant="flat"
                            rounded
                            height="50"
                            class="pl-16 pr-16"
                        >
                            <span class="text-primary">Cancel</span>
                        </VBtn>
                    </Link>
                </VCol>
                <VCol cols="2">
                    <VBtn
                        color="primary"
                        variant="flat"
                        rounded
                        height="50"
                        class="pl-16 pr-16"
                        @click="updateTeacher()"
                    >
                        <span class="text-white">Save</span>
                    </VBtn>
                </VCol>
            </VRow>
        </VContainer>
    </AdminLayout>
</template>

<style scoped>
.teacherprofile-title {
    color: var(--text, #161616);
    /* H3 Ruddy */
    font-family: Ruddy;
    font-size: 40px !important;
    font-style: normal !important;
    font-weight: 700 !important;
    line-height: 52px !important;
    text-transform: capitalize !important;
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
