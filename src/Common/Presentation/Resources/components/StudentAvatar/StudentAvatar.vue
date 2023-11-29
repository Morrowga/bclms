<script setup>
const props = defineProps(["title", "route", "phone_number", "image"]);
</script>
<template>
    <div>
        <Link
            :href="props.route"
            class="d-flex flex-column justify-center align-center"
        >
            <VImg :src="props.image" class="tggie-student-img mb-2" />
            <h4 class="tiggie-subtitle">{{ props.title }}</h4>
            <p class="text-candy-red" v-if="props?.phone_number">
                <VIcon icon="mdi-phone" color="candy-red"></VIcon>&nbsp;
                {{ props.phone_number }}
            </p>
        </Link>
    </div>
</template>
