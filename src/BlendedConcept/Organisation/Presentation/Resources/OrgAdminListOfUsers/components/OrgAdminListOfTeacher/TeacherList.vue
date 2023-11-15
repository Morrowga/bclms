<script setup>
import TeacherAvatar from "@mainRoot/components/TeacherAvatar/TeacherAvatar.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import { usePage } from "@inertiajs/vue3";
import {
    onColumnFilter,
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";
const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    total_teachers: {
        default: 0,
    },
});

let filters = ref(null);
let filterDatas = ref([
    { title: "A-Z", value: "asc" },
    { title: "Z-A", value: "desc" },
    { title: "Contact Number", value: "contact_number" },
]);
// console.log(props.data);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});

const page = usePage();
const app_url = computed(() => page?.props?.route_site_url);

const formattedImageUrl = (imageUrl) => {
    // Check if the input starts with http:// or https://
    if (!/^https?:\/\//i.test(imageUrl)) {
        // If not, add http:// as the default prefix
        return app_url.value + "/" + imageUrl;
    } else {
        // If it already includes http:// or https://, use the input as is
        return imageUrl;
    }
};
function calculatePercentageByCount(specificCount, totalCount) {
    if (totalCount === 0) {
        return 0; // To avoid division by zero error
    }
    return (specificCount / totalCount) * 100;
}
const showUsedStorage = (teacher) => {
    return `${teacher.used_storage}/${teacher.allocated_storage_limit ?? 0}`;
};
</script>
<template>
    <VContainer>
        <VRow justify="space-between">
            <VCOl cols="4">
                <h1 class="tiggie-teacher-title">Teachers</h1>
            </VCOl>
            <VCol cols="8">
                <VRow align="center" justify="end">
                    <VCol cols="4" class="okay-par">
                        <VTextField
                            placeholder="Search User ..."
                            variant="plain"
                            density="compact"
                            @keyup.enter="searchItems"
                            v-model="serverParams.search"
                        >
                            <template #append-inner>
                                <VIcon
                                    icon="mdi-magnify"
                                    size="26px"
                                    height="26px"
                                    class="abs-right"
                                >
                                </VIcon>
                            </template>
                        </VTextField>
                    </VCol>
                    <VCol cols="4">
                        <selectBox
                            v-model="filters"
                            placeholder="Sort By"
                            :datas="filterDatas"
                            density="compact"
                            item_title="title"
                            item_value="value"
                        />
                    </VCol>
                    <VCol cols="12" class="pa-0">
                        <div class="d-flex justify-end">
                            <div class="w-25">
                                <span
                                    >{{ props.data.meta.total }}/{{
                                        props.total_teachers
                                    }}
                                    Used
                                </span>
                                <VProgressLinear
                                    color="yellow-darken-2"
                                    :model-value="
                                        calculatePercentageByCount(
                                            props.data.meta.total,
                                            props.total_teachers
                                        )
                                    "
                                    :height="15"
                                ></VProgressLinear>
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VCol>
        </VRow>
        <VRow cols="6">
            <VCol
                cols="12"
                sm="6"
                md="3"
                lg="2"
                class="pe-2"
                v-for="item in props.data.data"
                :key="item.user.id"
            >
                <!--  -->
                <TeacherAvatar
                    class="teacherAvatar"
                    :image="formattedImageUrl(item.user.profile_pic)"
                    :route="route('organisations-teacher.show', item.user.id)"
                    :title="item.user.first_name + ' ' + item.user.last_name"
                    :phone_number="item.user.contact_number"
                    :storage="showUsedStorage(item)"
                />
            </VCol>
        </VRow>
        <div class="d-flex justify-center">
            <Pagination :metadata="props.data.meta" />
        </div>
    </VContainer>
</template>
<style scoped>
:deep(.okay-par .v-text-field input) {
    border-radius: 100px !important;
    border: 1px solid #e5e5e5 !important;
    padding: 8px 16px 8px 20px !important;
    background: #f6f6f6 !important;
}

:deep(.teacherAvatar .tiggie-subtitle) {
    font-size: 20px !important;
}

.abs-right {
    position: absolute !important;
    right: 10px !important;
}
</style>
