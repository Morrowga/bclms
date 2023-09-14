<script setup>
import AdminLayout from "@Layouts/Dashboard/AdminLayout.vue";
import { router } from "@inertiajs/core";
import { ref } from "vue";

let tab = ref(false);
</script>
<template>
    <AdminLayout>
        <VContainer>
            <p class="ruddy-bold editstorybookversion mt-5">Edit Storybook Version</p>

            <p class="ruddy-bold editstorybook-mini mt-10">Version Details</p>

            <VCol cols="6">
                <span class="pppangram-bold label-h5p-edit">Name</span>
                <VTextField class="mt-3"
                    placeholder=""
                    density="compact"
                    variant="solo"
                />
            </VCol>
            <VCol cols="6">
                <span class="pppangram-bold label-h5p-edit">Description</span>
                <VTextField class="mt-3"
                    placeholder=""
                    density="compact"
                    variant="solo"
                />
            </VCol>
            <div class="mt-15">
                <p class="editstorybook-mini ruddy-bold">Edit Personalisation / Customisation Content</p>

                <div class="mt-10">
                    <iframe
                    src="https://bc.dev.leaptech.sg/admin/h5p/h5p/1/edit"
                    frameborder="0"
                    scrolling="auto"
                    class="h5p-width"
                    ></iframe>
                </div>
            </div>
        </VContainer>
    </AdminLayout>
</template>
<style scoped>
.main-pic {
    z-index: 2;
}

.label-h5p-edit{
    color: var(--Graphite, #282828) !important;
}
.h5p-width{
    width: 100%;
    height: 1500px;
}

.editstorybook-mini{
    color: var(--Text, #161616);
    font-size: 25px  !important;
    font-style: normal;
    font-weight: 700;
    line-height: 42px; /* 140% */
    text-transform: capitalize;
}

.editstorybookversion{
    color: var(--Graphite, #282828);
    font-size: 35px !important;
    font-style: normal;
    font-weight: 700;
    line-height: 52px; /* 130% */
    text-transform: capitalize;
}
.vector-background {
    position: absolute;
    top: -52%;
    left: -36%;
    z-index: 1;
}
.vector-background img {
    width: 900px;
    height: auto;
}
</style>
