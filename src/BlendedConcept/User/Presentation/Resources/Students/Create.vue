<template>
    <Student>
        <div
            class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14"
        >
            <div class="flex flex-col mb-10">
                <div class="relative">
                    <form @submit.prevent="saveForm">
                        <div class="grid grid-cols-12 gap-y-2">
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-left pb-5 align-middle text-primary mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white">
                                    Student Particulars
                                </h1>

                                <div class="flex gap-5 justify-center">
                                    <NoLabelInput
                                        v-model="form.firstname"
                                        placeholder="First Name"
                                        :type="number"
                                        :error="form.errors?.firstname"
                                        class="w-96"
                                    />
                                    <NoLabelInput
                                        v-model="form.lastname"
                                        placeholder="Last Name"
                                        :error="form.errors?.lastname"
                                        class="w-96"
                                    />
                                </div>
                                <div class="flex pt-7 ">
                                 <Calendar v-model="form.dob" showIcon  class="w-96 h-10"/>
                                </div>
                               <h1
                                    class="text-left pb-5 align-middle text-primary mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white">
                                    Learning Needs
                               </h1>
                               <div class="flex flex-col gap-5">
                                  <NoLabelSelectInput
                                  v-model="form.needs"
                                  :datas="needs"
                                  :error="form.errors?.needs"
                                  defaultSelected="needs"
                                  class="w-96"/>


                                  <NoLabelInput
                                        v-model="form.grade"
                                        placeholder="Grade"
                                        :type="text"
                                        :error="form.errors?.grade"
                                        class="w-60"
                                    />
                                </div>
                                 <h1
                                    class="text-primary">
                                    Learning Needs ?
                               </h1>
                               <div class="flex flex-row gap-5 flex-wrap">
                                  <div class="flex items-center w-[50%] ">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >First Choice</label
                                        >
                                  </div>
                                  <div class="flex items-center">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >secondary Choice</label
                                        >
                                  </div>
                                   <div class="flex items-center w-[50%]">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Third Choice</label
                                        >
                                  </div>
                                  <div class="flex items-center">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Fourth Choice</label
                                        >
                                  </div>
                                  <div class="flex items-center w-[50%]">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Fifth Choice</label
                                        >
                                  </div>
                                  <div class="flex items-center">
                                        <input
                                            id="default-radio-1"
                                            type="radio"
                                            value="on"
                                            name="organization"
                                            v-model="organization"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />

                                        <label
                                            for="default-radio-1"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >Other</label
                                        >
                                  </div>
                               </div>

                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                                >
                                    Add Profile Picture
                                </h1>
                                <div class="flex flex-wrap justify-center mt-3">
                                    <div
                                        class="w-6/12 sm:w-4/12 px-4 dropzone"
                                        @click="SelectImage"
                                    >
                                        <input
                                            type="file"
                                            ref="file"
                                            @change="fileData"
                                            accept="image/*"
                                            hidden
                                        />
                                        <div class="img-area" data-img="">
                                            <img
                                                src="https://getstamped.co.uk/wp-content/uploads/WebsiteAssets/Placeholder.jpg"
                                                class="shadow-lg rounded max-w-full h-auto align-middle border-none"
                                            />
                                            <h3>Upload Image</h3>
                                            <p>
                                                Image size must be less than
                                                <span>2MB</span>
                                            </p>
                                        </div>
                                        <!-- <button type="button" class="select-image">Select Image</button> -->
                                    </div>
                                </div>
                                <div
                                    class="flex justify-end items-center p-6 space-x-2 rounded-b dark:border-gray-600"
                                >
                                    <Link :href="route('users.index')">
                                        <DefaultButton
                                            title="Back"
                                            type="button"
                                        />
                                    </Link>
                                    <DefaultButton
                                        type="submit"
                                        title="Create"
                                        buttonColor="blue"
                                    />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Student>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import Student from "@dashboard/Student.vue";
import Dropdown from "primevue/dropdown";
import Calendar from "primevue/calendar"
import NoLabelSelectInput from "@Composables/NoLabelSelectInput.vue";
import NoLabelInput from "@Composables/NoLabelInput.vue";
import DefaultButton from "@Composables/DefaultButton.vue";
let props = defineProps(["errors"]);
let needs = ref({
name:'need'
})
let form = useForm({
    firstname: "",
    lastname: "",
    dob: "",
    need: "needs",
    role: "selected",
    image: null,
    password: "",
});
let file = ref(null);
function SelectImage() {
    //select image from hidden field
    file.value.click();
}

function fileData(event) {
    let image = event.target.files[0];
    let imgArea = document.querySelector(".img-area");
    // file is less than
    if (image.size < 5000000) {
        let reader = new FileReader();
        reader.onload = () => {
            let allImg = imgArea.querySelectorAll("img");
            allImg.forEach((item) => item.remove());
            let imgUrl = reader.result;
            let img = document.createElement("img");
            img.src = imgUrl;
            form.image = event.target.files[0];
            imgArea.appendChild(img);
            imgArea.classList.add("active");
            imgArea.dataset.img = image.name;
        };
        reader.readAsDataURL(image);
    } else {
        alert("Image size more than 5MB");
    }
}

let saveForm = () => {
    form.post(route("users.store"), {
        onSuccess: () => {},
        onError: (error) => {
            form.setError("role", error?.role);
            form.setError("name", error?.name);
            form.setError("email", error?.email);
            form.setError("password", error?.password);
            form.setError("contact_number", error?.contact_number);
        },
    });
};
</script>
<style>
.dropzone {
    max-width: 400px;
    width: 100%;
    background: #fff;
    padding: 30px;
    border-radius: 30px;
}
.img-area {
    position: relative;
    width: 100%;
    height: 240px;
    background: var(--grey);
    margin-bottom: 30px;
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.img-area .icon {
    font-size: 100px;
}
.img-area h3 {
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 6px;
}
.img-area p {
    color: #999;
}
.img-area p span {
    font-weight: 600;
}
.img-area img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 100;
}
.img-area::before {
    content: attr(data-img);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    font-weight: 500;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 200;
}
.img-area.active:hover::before {
    opacity: 1;
}
.select-image {
    display: block;
    width: 100%;
    padding: 6px 0;
    border-radius: 15px;
    background: blue;
    color: #fff;
    font-weight: 500;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}
.select-image:hover {
    background: darkblue;
}
</style>
