<script setup>
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
import {
    onColumnFilter,
    serverParams,
    searchItems,
} from "@Composables/useServerSideDatable.js";
let props = defineProps(["students", "total_students"]);
console.log(props.students);
let filters = ref(null);
let filterDatas = ref([
    { title: "A-Z", value: "asc" },
    { title: "Z-A", value: "desc" },
    { title: "Contact Number", value: "contact_number" },
]);
watch(filters, (newValue) => {
    onColumnFilter({
        columnFilters: {
            filter: newValue,
        },
    });
});
function calculatePercentageByCount(specificCount, totalCount) {
    if (totalCount === 0) {
        return 0; // To avoid division by zero error
    }
    return (specificCount / totalCount) * 100;
}
// console.log(props, "fuck");
</script>
<template>
    <VContainer>
        <VRow justify="space-between">
            <VCOl cols="4">
                <h1 class="tiggie-teacher-title">Students</h1>
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
                                    >{{ props.students.meta.total }}/{{
                                        props.total_students
                                    }}
                                    Used
                                </span>
                                <VProgressLinear
                                    color="yellow-darken-2"
                                    :model-value="
                                        calculatePercentageByCount(
                                            props.students.meta.total,
                                            props.total_students
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
                v-for="item in students.data"
                :key="item.student_id"
            >
                <StudentAvatar
                    :route="
                        route('organisations-student.show', item.student_id)
                    "
                    :image="item.user.profile_pic"
                    :title="item.user.full_name"
                    :phone_number="item.parent?.user?.contact_number"
                />
            </VCol>
        </VRow>
        <div class="d-flex justify-center">
            <Pagination />
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
.abs-right {
    position: absolute !important;
    right: 10px !important;
}
</style>
