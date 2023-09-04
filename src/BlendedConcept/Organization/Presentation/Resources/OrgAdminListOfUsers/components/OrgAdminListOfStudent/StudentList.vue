<script setup>
import StudentAvatar from "@mainRoot/components/StudentAvatar/StudentAvatar.vue";
import Pagination from "@mainRoot/components/Pagination/Pagination.vue";
import SelectBox from "@mainRoot/components/SelectBox/SelectBox.vue";
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
                        >
                            <template #append-inner>
                                <VIcon
                                    icon="mdi-magnify"
                                    size="26px"
                                    height="26px"
                                    style="position: absolute; right: 10px"
                                >
                                </VIcon>
                            </template>
                        </VTextField>
                    </VCol>
                    <VCol cols="4">
                        <SelectBox
                            v-model="selectedRole"
                            placeholder="Sort By"
                            :datas="['A-Z', 'Z-A', 'Contact Number']"
                            :density="compact"
                        />
                    </VCol>
                    <VCol cols="12" class="pa-0">
                        <div class="d-flex justify-end">
                            <div class="w-25">
                                <span>50/100 Used </span>
                                <VProgressLinear
                                    color="yellow-darken-2"
                                    model-value="50"
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
                v-for="item in 12"
                :key="item"
            >
                <StudentAvatar
                    image="/images/student.png"
                    title="Wren Clark"
                    phone_number="9111 1112"
                    :route="route('org_view_teacher_student.student.show')"
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
</style>
