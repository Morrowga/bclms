<template>
   <AdminLayout>
   <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 rounded-lg bg-white p-6 shadow-lg my-14">
            <div class="flex flex-col mb-10">
                <div class="relative">
                    <form @submit.prevent="saveForm">
                        <div class="grid grid-cols-12 gap-y-2">
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-left pb-5 align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                                >
                                    User Particulars
                                </h1>


                                 <NoLabelSelectInput
                                  v-model="form.role"
                                  :datas="props.roles"
                                  :error="form.errors?.role"
                                  defaultSelected="Please Select Role"/>
                                <NoLabelInput
                                    v-model="form.name"
                                    placeholder="Name"
                                    :type="number"
                                    :error="form.errors?.name"
                                    class="pb-5 pt-5"
                                />
                                <NoLabelInput
                                    v-model="form.contact_number"
                                    placeholder="Contact Number"
                                    :error="form.errors?.contact_number"
                                    class="pb-5"
                                />
                                <NoLabelInput
                                    v-model="form.email"
                                    placeholder="Email"
                                    :error="form.errors?.email"
                                    class="pb-5"
                                />
                            </div>
                            <div class="col-span-12 sm:col-span-6">
                                <h1
                                    class="text-center align-middle mt-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-lg lg:text-xl dark:text-white"
                                >
                                    Add Profile Picture
                                </h1>
                                <ImageUpload v-model="form.image"/>
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
   </AdminLayout>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AdminLayout from "@dashboard/AdminLayout.vue";
import Dropdown from "primevue/dropdown"
import NoLabelSelectInput from "@Composables/NoLabelSelectInput.vue";
import ImageUpload from "@Composables/ImageUpload.vue";
import NoLabelInput from "@Composables/NoLabelInput.vue";
import DefaultButton from "@Composables/DefaultButton.vue";
let props = defineProps(["roles", "errors",'user']);

let form = useForm({
    name: props?.user?.name,
    contact_number: props.user.contact_number,
    email: props.user.email,
    role: props?.user?.roles[0].id,
    _method: "put",
    image: props?.user?.image[0]?.original_url || "https://getstamped.co.uk/wp-content/uploads/WebsiteAssets/Placeholder.jpg",
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
    form.post(route("users.update",props.user.id), {
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
