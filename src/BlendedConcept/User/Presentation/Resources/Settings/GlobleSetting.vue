<template>
  <div class="card">
    <div class="grid grid-cols-12 gap-3">
      <div class="flex flex-col col-span-3 flex-wrap gap-2">
        <label class="text-primary font-bold">App Name</label>
        <InputText
          id="app_name"
          v-model="form.app_name"
          class="h-10"
          aria-describedby="username-help"
        />
      </div>
      <div class="col-span-9"></div>
    </div>

    <!-- fav icon section  -->
    <h1 class="text-primary font-bold text-h4 mt-4">App Logos</h1>

    <div class="grid grid-cols-12 gap-3 pb-2 mb-4">
      <div class="flex flex-col lg:col-span-6 col-span-12 pr-2 gap-2">
        <label class="text-primary font-bold">Fav Icon</label>
        <div class="card">
          <FileUpload
            name="photo"
            v-model="form.favicon"
            accept="image/*"
            multiple="false"
            :maxFileSize="10000000"
          >
            <!-- custome buttton  -->
            <template #header="{ chooseCallback, clearCallback, files }">
              <div
                class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2"
              >
                <div class="flex gap-2">
                  <Button
                    @click="chooseCallback()"
                    icon="pi pi-images"
                    rounded
                    outlined
                  ></Button>
                  <Button
                    @click="clearCallback()"
                    icon="pi pi-times"
                    rounded
                    outlined
                    severity="danger"
                    :disabled="!files || files.length === 0"
                  ></Button>
                </div>
              </div>
            </template>
            <!-- custom button end -->
            <!-- custom content -->
            <template #content="{ files }">
              <div class="flex flex-wrap p-1 gap-5">
                <div
                  v-for="file of files"
                  :key="file.name + file.type + file.size"
                  class="card m-0 flex flex-column border-1 surface-border align-items-center gap-3"
                >
                  <div>
                    <img
                      role="presentation"
                      :alt="file.name"
                      :src="file.objectURL"
                      style="width: 300px; height: 134px"
                      class="shadow-2"
                    />
                  </div>
                </div>
              </div>
            </template>
            <template #empty>
              <p>Drag and drop files to here to upload.</p>
            </template>
          </FileUpload>
        </div>
      </div>
      <!-- end fav icon setting -->
      <!-- logo section -->
      <div class="flex flex-col lg:col-span-6 col-span-12 pr-2 gap-2">
        <label class="text-primary font-bold">Logo</label>
        <div class="card">
          <FileUpload
            name="photo"
            v-model="form.logo"
            accept="image/*"
            multiple="false"
            :maxFileSize="10000000"
          >
            <!-- custome buttton  -->
            <template #header="{ chooseCallback, clearCallback, files }">
              <div
                class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2"
              >
                <div class="flex gap-2">
                  <Button
                    @click="chooseCallback()"
                    icon="pi pi-images"
                    rounded
                    outlined
                  ></Button>
                  <Button
                    @click="clearCallback()"
                    icon="pi pi-times"
                    rounded
                    outlined
                    severity="danger"
                    :disabled="!files || files.length === 0"
                  ></Button>
                </div>
              </div>
            </template>
            <!-- custom button end -->
            <!-- custom content -->
            <template #content="{ files }">
              <div class="flex flex-wrap p-1 gap-5">
                <div
                  v-for="file of files"
                  :key="file.name + file.type + file.size"
                  class="card m-0 flex flex-column border-1 surface-border align-items-center gap-3"
                >
                  <div>
                    <img
                      role="presentation"
                      :alt="file.name"
                      :src="file.objectURL"
                      style="width: 300px; height: 134px"
                      class="shadow-2"
                    />
                  </div>
                </div>
              </div>
            </template>
            <template #empty>
              <p>Drag and drop files to here to upload.</p>
            </template>
          </FileUpload>
        </div>
      </div>
      <!-- log -->
      <!-- footer logo -->
      <div class="flex flex-col lg:col-span-6 col-span-12 pr-2 gap-2">
        <label class="text-primary font-bold">Footer Logo</label>
        <div class="card">
          <FileUpload
            name="photo"
            v-model="form.footerlogo"
            accept="image/*"
            multiple="false"
            :maxFileSize="10000000"
          >
            <!-- custome buttton  -->
            <template #header="{ chooseCallback, clearCallback, files }">
              <div
                class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2"
              >
                <div class="flex gap-2">
                  <Button
                    @click="chooseCallback()"
                    icon="pi pi-images"
                    rounded
                    outlined
                  ></Button>
                  <Button
                    @click="clearCallback()"
                    icon="pi pi-times"
                    rounded
                    outlined
                    severity="danger"
                    :disabled="!files || files.length === 0"
                  ></Button>
                </div>
              </div>
            </template>
            <!-- custom button end -->
            <!-- custom content -->
            <template #content="{ files }">
              <div class="flex flex-wrap p-1 gap-5">
                <div
                  v-for="file of files"
                  :key="file.name + file.type + file.size"
                  class="card m-0 flex flex-column border-1 surface-border align-items-center gap-3"
                >
                  <div>
                    <img
                      role="presentation"
                      :alt="file.name"
                      :src="file.objectURL"
                      style="width: 300px; height: 134px"
                      class="shadow-2"
                    />
                  </div>
                </div>
              </div>
            </template>
            <template #empty>
              <p>Drag and drop files to here to upload.</p>
            </template>
          </FileUpload>
        </div>
      </div>
      <!-- footer log end -->
      <!-- background image  -->
      <div class="flex flex-col lg:col-span-6 col-span-12 pr-2 gap-2">
        <label class="text-primary font-bold">Background Image</label>
        <div class="card">
          <FileUpload
            name="photo"
            v-model="form.background"
            accept="image/*"
            multiple="false"
            :maxFileSize="10000000"
          >
            <!-- custome buttton  -->
            <template #header="{ chooseCallback, clearCallback, files }">
              <div
                class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2"
              >
                <div class="flex gap-2">
                  <Button
                    @click="chooseCallback()"
                    icon="pi pi-images"
                    rounded
                    outlined
                  ></Button>
                  <Button
                    @click="clearCallback()"
                    icon="pi pi-times"
                    rounded
                    outlined
                    severity="danger"
                    :disabled="!files || files.length === 0"
                  ></Button>
                </div>
              </div>
            </template>
            <!-- custom button end -->
            <!-- custom content -->
            <template #content="{ files }">
              <div class="flex flex-wrap p-1 gap-5">
                <div
                  v-for="file of files"
                  :key="file.name + file.type + file.size"
                  class="card m-0 flex flex-column border-1 surface-border align-items-center gap-3"
                >
                  <div>
                    <img
                      role="presentation"
                      :alt="file.name"
                      :src="file.objectURL"
                      style="width: 300px; height: 134px"
                      class="shadow-2"
                    />
                  </div>
                </div>
              </div>
            </template>
            <template #empty>
              <p>Drag and drop files to here to upload.</p>
            </template>
          </FileUpload>
        </div>
      </div>
      <!-- background image end -->
    </div>

    <h1 class="text-primary font-bold mt-5 mb-5">Color Apperances</h1>
    <div class="grid grid-cols-12 gap-3 pb-2 mb-4">
      <div class="flex flex-col col-span-3 flex-wrap gap-2">
        <label class="text-primary font-bold">Text Colors</label>
        <div>
          <input
            type="radio"
            aria-label="Yes"
            name=""
            class="accent-red-500 w-100 border-none border-r-red-50 text-2xl"
          />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
          <input type="radio" name="" />
        </div>
      </div>
      <div class="flex flex-col col-span-3 flex-wrap gap-2">
        <label class="text-primary font-bold">Preview</label>
        <h1>This is demo text color</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import InputText from "primevue/inputtext";
import FileUpload from "primevue/fileupload";
import { useForm } from "@inertiajs/inertia-vue3";
import Divider from "primevue/divider";

let form = useForm({
  app_name: "",
  favicon: "",
  logo: "",
  footerlogo: "",
  bgimage: "",
});
// uplaode images
const uploadEvent = (files) => {
  console.log(files);
};

// upload error settings
const onAdvancedUpload = (value) => {
  // save site logo
  console.log(value);
  if (value == "applogo") {
    alert("Upload Site Image successfully");
  }
  toast.add({
    severity: "info",
    summary: "Success",
    detail: "File Uploaded",
    life: 3000,
  });
};
</script>
